<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

     private int $items_per_page = 30;

    public function orders(Request $request)
    {
        $search = $request->input('q');
        $status = $request->input('status');
        $paymentStatus = $request->input('payment_status');
        $date = $request->input('date');


        $query = Order::with('orderProducts')->orderBy('id', 'desc');

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

        if ($date) {
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
        $order = Order::with(['shippingAddress', 'orderProducts'], 'items.product')->findOrFail($id);
         
      

        // Select the dummy order based on the provided ID
        // $order = $dummyOrders[$id] ?? $dummyOrders[1];
        return view('backend.view-order', compact('order'));
    }

    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $order = Order::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();
        // Optional: notify customer via email
        // if ($order->customer && $order->customer->email) {
        //     Mail::raw("Your order #{$order->order_number} status has been updated to: {$order->status}.", function ($message) use ($order) {
        //         $message->to($order->customer->email)
        //             ->subject("Order Status Updated");
        //     });
        // }

        // Optional notification
        if ($request->has('notify_user')) {
            // Example: send email or SMS (you can expand this)
            try {
                $user = $order->customer;

                if ($user && $user->email) {
                    \Mail::raw("Your order #{$order->order_number} has been updated to '{$order->status}'.", function ($message) use ($user) {
                        $message->to($user->email)
                            ->subject('Order Status Updated');
                    });
                }

                // You can add SMS logic here too if you have an SMS provider integrated.
            } catch (\Exception $e) {
                \Log::error('Failed to notify customer: ' . $e->getMessage());
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
