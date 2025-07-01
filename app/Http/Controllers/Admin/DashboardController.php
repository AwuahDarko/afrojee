<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order; 


class DashboardController extends Controller
{
    public function index(){
    $this_month_order_count = Order::whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->where('payment_status', 'paid')
    ->count();

    $total_orders = Order::whereYear('created_at', now()->year)
    ->where('payment_status', 'paid')
    ->count();

    $this_month_payment_count = Payment::whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->count();

    $total_sales_this_month = Payment::whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->sum('amount');

    $total_sales =  $total_sales_this_month = Payment::whereYear('created_at', now()->year)
    ->sum('amount');


        $orders = Order::with(['billingAddress'])->orderBy('id', 'desc')->limit(20)->get();
        $payments = Payment::with('order')->orderBy('id', 'desc')->limit(20)->get();


        return view('backend.dashboard',
         compact(
            'this_month_order_count',
            'orders',
            'this_month_payment_count',
            'payments',
            'total_sales_this_month',
            'total_sales',
            'total_orders'
        ));
    }
}
