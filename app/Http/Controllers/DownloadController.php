<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'paid') {
            return back()->with('error', 'Purchase required to download.');
        }

        $filePath = $order->product->file_path;

        if (!$filePath || !Storage::disk('private')->exists($filePath)) {
            return back()->with('error', 'This product file is not available yet. Please contact support.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION) ?: 'zip';

        return Storage::disk('private')->download(
            $filePath,
            $order->product->title . '.' . $extension
        );
    }
}