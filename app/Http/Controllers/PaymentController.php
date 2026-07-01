<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Services\ChapaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(protected ChapaService $chapa) {}

   public function checkout(Product $product)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('info', 'Please login to purchase.');
    }

    $user = Auth::user();
    $nameParts = explode(' ', $user->name, 2);

    // Sanitize description: only letters, numbers, hyphens, underscores, spaces, dots allowed
    $description = preg_replace('/[^A-Za-z0-9\-_. ]/', '', 'Purchase ' . $product->title);
    $description = Str::limit($description, 100, '');

    $result = $this->chapa->initializePayment([
        'amount'       => $product->price,
        'email'        => $user->email,
        'first_name'   => $nameParts[0],
        'last_name'    => $nameParts[1] ?? 'N/A',
        'phone_number' => $user->phone ?? '0900000000',
        'title'        => preg_replace('/[^A-Za-z0-9\-_. ]/', '', config('app.name')),
        'description'  => $description,
    ]);

    if (!$result['success']) {
        return back()->with('error', 'Payment initialization failed: ' . $result['message']);
    }

    Order::create([
        'user_id'    => $user->id,
        'product_id' => $product->id,
        'tx_ref'     => $result['tx_ref'],
        'amount'     => $product->price,
        'status'     => 'pending',
    ]);

    return redirect($result['checkout_url']);
}

    public function callback(Request $request)
    {
        // Webhook from Chapa
        $txRef = $request->input('trx_ref') ?? $request->input('tx_ref');
        $this->processPayment($txRef);
        return response()->json(['status' => 'ok']);
    }

    public function returnFromChapa(Request $request)
    {
        $txRef = $request->query('tx_ref');
        $this->processPayment($txRef);

        $order = Order::where('tx_ref', $txRef)->first();

        if ($order && $order->status === 'paid') {
            return redirect()->route('orders.success', $order)->with('success', 'Payment successful!');
        }

        return redirect()->route('home')->with('error', 'Payment could not be verified.');
    }

    private function processPayment(string $txRef): void
    {
        $order = Order::where('tx_ref', $txRef)->first();
        if (!$order || $order->status === 'paid') return;

        $verification = $this->chapa->verifyPayment($txRef);

        if (
            isset($verification['status']) &&
            $verification['status'] === 'success' &&
            $verification['data']['status'] === 'success'
        ) {
            $order->update(['status' => 'paid']);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'chapa_reference' => $verification['data']['reference'] ?? null,
                    'amount'          => $order->amount,
                    'currency'        => 'ETB',
                    'payment_method'  => $verification['data']['payment_method'] ?? null,
                    'chapa_response'  => json_encode($verification['data']),
                    'status'          => 'success',
                ]
            );

            // Increment download counter
            $order->product->increment('downloads');
        } else {
            $order->update(['status' => 'failed']);
        }
    }
}