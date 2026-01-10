<div class="flex justify-between items-center mb-3">
    <p class="text-gray-700">{{ __('common.checkout.product_subtotal') }}</p>
    <p class="font-bold text-gray-900">  {{ number_format($total_price, 2) }} {{app_currency()}}</p>
</div>
@if(isset($isFirstOrder) && $isFirstOrder && isset($discountAmount) && $discountAmount > 0)
<div class="flex justify-between items-center mb-3">
    <div class="flex items-center gap-1">
        <p class="text-gray-700">{{ __('common.checkout.discount') }}</p>
        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full hidden">{{ __('common.checkout.saved') }}</span>
    </div>
    <p class="font-bold text-green-600">-{{ number_format($discountAmount, 2) }} {{app_currency()}}</p>
</div>
@endif
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-700">{{ __('common.checkout.delivery') }}</p>
        @if(isset($carrier_name) && $carrier_name)
            <p class="text-xs text-gray-500 mt-1">{{ $carrier_name }}</p>
        @endif
    </div>
    <p class="font-bold text-gray-900">  {{ number_format($total_shipping, 2) }} {{app_currency()}}</p>
</div>
<div class="flex justify-between items-center border-t border-gray-300 pt-4 mb-6">
    <p class="text-xl font-bold text-gray-900">{{ __('common.cart.total') }}</p>
    <p class="text-3xl font-bold text-gray-900">  {{ number_format($grand_total, 2) }} {{app_currency()}}</p>
</div>
