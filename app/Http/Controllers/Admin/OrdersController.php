<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DeliveryMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{

     private int $items_per_page = 30;

    public function orders(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('status');
        $paymentStatus = $request->input('payment_status');
        $date = $request->input('date');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');


        $query = Order::with(['orderProducts', 'shippingAddress'])->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($paymentStatus) {
            $query->where('payment_status', $paymentStatus);
        }

        // Support date range (from/to takes precedence over single date)
        if ($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ]);
        } elseif ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        } elseif ($date) {
            // Legacy support for single date filter
            $query->whereDate('created_at', $date);
        }

        $orders = $query->paginate($this->items_per_page);

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'revenue' => Order::where('status', 'completed')->sum('total_amount'),
        ];

        return view('backend.orders', compact('orders', 'stats'));
    }

    public function viewOrder($id)
    {
        $order = Order::with([
            'billingAddress.country',
            'billingAddress.zone',
            'shippingAddress.country',
            'shippingAddress.zone',
            'orderProducts.product',
            'orderProducts.size'
        ])->findOrFail($id);
         
      

        // Select the dummy order based on the provided ID
        // $order = $dummyOrders[$id] ?? $dummyOrders[1];
        return view('backend.view-order', compact('order'));
    }

    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|string',
            'tracking_number' => 'nullable|string|max:255',
            'tracking_link' => 'nullable|url|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $order = Order::findOrFail($request->id);
        $order = Order::with('billingAddress')->where('id', '=', $request->id)->first();

        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // Update tracking fields if provided
        if ($request->has('tracking_number')) {
            $order->tracking_number = $request->tracking_number;
        }
        if ($request->has('tracking_link')) {
            $order->tracking_link = $request->tracking_link;
        }
        
        $order->save();

        // Automatically send email when order is marked as completed
        // Also send if checkbox is checked for other status changes
        $shouldSendEmail = false;
        $emailReason = '';

        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            // Automatically send email when status changes to completed
            $shouldSendEmail = true;
            $emailReason = 'Order marked as completed';
        } elseif ($request->has('notify_user')) {
            // Send email if checkbox is checked for other status changes
            $shouldSendEmail = true;
            $emailReason = 'Admin requested notification';
        }

        if ($shouldSendEmail) {
            try {
                // Check if billing address exists and has email
                if ($order->billingAddress && $order->billingAddress->email) {
                    $data = [
                        'customer_name' => $order->billingAddress->first_name . ' ' . $order->billingAddress->last_name,
                        'order_id' => $order->order_number,
                        'status' => $request->status,
                        'tracking_number' => $order->tracking_number,
                        'tracking_link' => $order->tracking_link,
                    ];

                    Mail::to($order->billingAddress->email)->queue(new DeliveryMail($data));
                    Log::info("Delivery email sent for order #{$order->order_number}. Reason: {$emailReason}");
                } else {
                    Log::warning("Cannot send delivery email for order #{$order->order_number}: No billing address or email found");
                }
            } catch (\Exception $e) {
                Log::error('Failed to notify customer for order #' . $order->order_number . ': ' . $e->getMessage());
            }
        }
        return redirect()->route('admin.orders')->with('success', 'Order updated successfully.');
    }

    public function removeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order removed successfully.');
    }

    public function activateOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'active';
        $order->save();
        return redirect()->route('admin.orders')->with('success', 'Order activated successfully.');
    }

    public function deactivateOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'inactive';
        $order->save();
        return redirect()->route('admin.orders')->with('success', 'Order deactivated successfully.');
    }

    public function featureOrder($id)
    {
        return redirect()->route('admin.orders')->with('info', 'Feature functionality not implemented yet.');
    }
}
