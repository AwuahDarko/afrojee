@extends('backend.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 mt-n4 mx-3 z-index-2 position-relative">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
                            <h6 class="text-white text-capitalize">Order Details - {{ $order->order_number }}</h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Customer Information</h6>
                                <p><strong>Name:</strong>
                                    {{ $order->shippingAddress->first_name . ' ' . $order->shippingAddress->last_name }}</p>
                                <p><strong>Email:</strong> {{ $order->shippingAddress->email ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $order->shippingAddress->mobile_number ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-3">Order Summary</h6>
                                <p><strong>Status:</strong> <span
                                        class="badge bg-gradient-secondary">{{ ucfirst($order->status) }}</span></p>
                                <p><strong>Payment:</strong> <span
                                        class="badge bg-gradient-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                                <p><strong>Total:</strong> GHS {{ number_format($order->total_amount, 2) }}</p>
                                <p><strong>Placed on:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">Items Ordered</h6>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Quantity
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Unit Price
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Total Price
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Unit Weight
                                        </th>
                                         <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Total Weight
                                        </th>
                                       
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderProducts as $item)
                                        <tr>
                                            <td>
                                                <p class="text-sm mb-0">{{ $item->product->name ?? 'Product deleted' }}</p>
                                            </td>
                                             <td>
                                                <span class="text-sm">{{ $item->quantity }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm"> {{ number_format($item->unit_price, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm"> {{ number_format($item->total_price, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm"> {{ $item->unit_weight  }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm"> {{ $item->total_weight }}</span>
                                            </td>
                                           
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Back to Orders</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
