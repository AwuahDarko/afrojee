<div class="flex justify-between items-center mb-3">
    <p class="text-gray-700">Product sub-total</p>
    <p class="font-bold text-gray-900"> {{app_currency()}} {{ number_format($total_price, 2) }}</p>
</div>
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-700">Delivery</p>
        @if(isset($carrier_name) && $carrier_name)
            <p class="text-xs text-gray-500 mt-1">{{ $carrier_name }}</p>
        @endif
    </div>
    <p class="font-bold text-gray-900"> {{app_currency()}} {{ number_format($total_shipping, 2) }}</p>
</div>
<div class="flex justify-between items-center border-t border-gray-300 pt-4 mb-6">
    <p class="text-xl font-bold text-gray-900">Total</p>
    <p class="text-3xl font-bold text-gray-900"> {{app_currency()}} {{ number_format($grand_total, 2) }}</p>
</div>
