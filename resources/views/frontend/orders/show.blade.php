@extends('frontend.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <section class="relative py-16 sm:py-20">
        <div class="container mx-auto px-4 max-w-5xl bg-white/90 backdrop-blur rounded-3xl shadow-lg border border-[#e0c3b6]/40">
            <div class="px-6 sm:px-10 py-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-8 border-b border-[#e0c3b6]/50">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-semibold text-[#2E2E2E]">Order Summary</h1>
                        <p class="text-sm sm:text-base text-gray-600 mt-2">
                            Order number <span class="font-semibold text-[#9d3f5b]">{{ $order->order_number }}</span>
                            placed on {{ $order->created_at?->format('F j, Y g:i A') ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-medium bg-[#f8f6f1] text-[#9d3f5b] border border-[#e0c3b6]">
                            Status: {{ ucfirst($order->status ?? 'pending') }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-medium bg-[#ef380d]/10 text-[#ef380d] border border-[#ef380d]/40">
                            Payment: {{ ucfirst($order->payment_status ?? 'pending') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="border border-[#e0c3b6]/50 rounded-2xl p-6 bg-white">
                            <h2 class="text-xl font-semibold text-[#2E2E2E] mb-4">Items</h2>
                            @if ($order->orderProducts->isEmpty())
                                <p class="text-gray-600">No items found for this order.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach ($order->orderProducts as $item)
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#f8f6f1] rounded-xl p-4 border border-[#e0c3b6]/40">
                                            <div>
                                                <p class="text-lg font-medium text-[#2E2E2E]">
                                                    {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    Quantity: {{ $item->quantity }}
                                                    @if ($item->size)
                                                        <span class="mx-2">•</span>
                                                        Size: {{ $item->size->name }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Unit price</p>
                                                <p class="text-base font-semibold text-[#9d3f5b]">
                                                    {{ app_currency() }} {{ number_format($item->unit_price ?? 0, 2) }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Line total: {{ app_currency() }} {{ number_format($item->total_price ?? 0, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-[#e0c3b6]/50 rounded-2xl p-6 bg-white">
                                <h2 class="text-xl font-semibold text-[#2E2E2E] mb-4">Billing Information</h2>
                                @if ($billingAddress)
                                    <ul class="space-y-1 text-sm text-gray-600">
                                        <li class="font-medium text-[#2E2E2E]">
                                            {{ trim(($billingAddress->first_name ?? '') . ' ' . ($billingAddress->last_name ?? '')) ?: 'N/A' }}
                                        </li>
                                        <li>{{ $billingAddress->address_line_1 ?? '—' }}</li>
                                        @if (!empty($billingAddress->address_line_2))
                                            <li>{{ $billingAddress->address_line_2 }}</li>
                                        @endif
                                        <li>
                                            {{ $billingAddress->city ?? '' }}
                                            @if (!empty($billingAddress->county))
                                                , {{ $billingAddress->county }}
                                            @endif
                                            @if (!empty($billingAddress->postcode))
                                                , {{ $billingAddress->postcode }}
                                            @endif
                                        </li>
                                        <li>{{ optional($billingAddress->country)->name ?? '' }}</li>
                                        <li>Email: {{ $billingAddress->email ?? '—' }}</li>
                                        <li>Phone: {{ $billingAddress->mobile_number ?? '—' }}</li>
                                    </ul>
                                @else
                                    <p class="text-gray-600">Billing details not available.</p>
                                @endif
                            </div>

                            <div class="border border-[#e0c3b6]/50 rounded-2xl p-6 bg-white">
                                <h2 class="text-xl font-semibold text-[#2E2E2E] mb-4">Shipping Information</h2>
                                @if ($shippingAddress)
                                    <ul class="space-y-1 text-sm text-gray-600">
                                        <li class="font-medium text-[#2E2E2E]">
                                            {{ trim(($shippingAddress->first_name ?? '') . ' ' . ($shippingAddress->last_name ?? '')) ?: 'N/A' }}
                                        </li>
                                        <li>{{ $shippingAddress->address_line_1 ?? '—' }}</li>
                                        @if (!empty($shippingAddress->address_line_2))
                                            <li>{{ $shippingAddress->address_line_2 }}</li>
                                        @endif
                                        <li>
                                            {{ $shippingAddress->city ?? '' }}
                                            @if (!empty($shippingAddress->county))
                                                , {{ $shippingAddress->county }}
                                            @endif
                                            @if (!empty($shippingAddress->postcode))
                                                , {{ $shippingAddress->postcode }}
                                            @endif
                                        </li>
                                        <li>{{ optional($shippingAddress->country)->name ?? '' }}</li>
                                        <li>Email: {{ $shippingAddress->email ?? '—' }}</li>
                                        <li>Phone: {{ $shippingAddress->mobile_number ?? '—' }}</li>
                                    </ul>
                                @else
                                    <p class="text-gray-600">Shipping details not available.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="border border-[#e0c3b6]/50 rounded-2xl p-6 bg-white h-fit">
                        <h2 class="text-xl font-semibold text-[#2E2E2E] mb-4">Order Totals</h2>
                        <dl class="space-y-3 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-[#2E2E2E]">
                                    {{ app_currency() }} {{ number_format($order->subtotal ?? 0, 2) }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Delivery fee</dt>
                                <dd class="font-medium text-[#2E2E2E]">
                                    {{ app_currency() }} {{ number_format($order->delivery_fee ?? 0, 2) }}
                                </dd>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-dashed border-[#e0c3b6]/60">
                                <dt class="text-base font-semibold text-[#2E2E2E]">Total</dt>
                                <dd class="text-base font-semibold text-[#9d3f5b]">
                                    {{ app_currency() }} {{ number_format($order->total_amount ?? 0, 2) }}
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-8">
                            <a href="{{ route('home') }}"
                               class="inline-flex items-center justify-center px-5 py-3 w-full text-center text-sm font-semibold text-white bg-[#ef380d] hover:bg-[#f06243ff] rounded-full transition-colors duration-200">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

