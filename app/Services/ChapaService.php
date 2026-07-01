<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChapaService
{
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.chapa.secret_key');
        $this->baseUrl   = config('services.chapa.base_url');
    }

    public function initializePayment(array $data): array
    {
        $txRef = 'MKT-' . Str::upper(Str::random(12)) . '-' . time();

        $payload = [
            'amount'       => (string) $data['amount'],
            'currency'     => 'ETB',
            'email'        => $data['email'],
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'phone_number' => $data['phone_number'] ?? '0900000000',
            'tx_ref'       => $txRef,
            'callback_url' => route('payment.callback'),
            'return_url'   => route('payment.return', ['tx_ref' => $txRef]),
            'customization' => [
                'title'       => $data['title'] ?? config('app.name'),
                'description' => $data['description'] ?? 'Product Purchase',
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type'  => 'application/json',
        ])->post($this->baseUrl . '/transaction/initialize', $payload);

        $result = $response->json();

        Log::info('Chapa initialize response', [
            'status'  => $response->status(),
            'payload' => $payload,
            'body'    => $result,
        ]);

        $message = $result['message'] ?? 'Payment initialization failed';
        if (is_array($message)) {
            $message = collect($message)->flatten()->implode(', ');
        }

        return [
            'tx_ref'       => $txRef,
            'checkout_url' => $result['data']['checkout_url'] ?? null,
            'success'      => $response->successful() && isset($result['data']['checkout_url']),
            'message'      => $message,
        ];
    }

    public function verifyPayment(string $txRef): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
        ])->get($this->baseUrl . '/transaction/verify/' . $txRef);

        return $response->json();
    }
}