@extends('frontend.layouts.app')

@section('content')
    <section class="max-w-6xl mx-auto py-12">
        <h1 class="text-4xl font-semibold text-gray-800 mb-8">Checkout</h1>

        <h2 class="text-xl font-semibold text-gray-800">Billing address</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <div class="bg-pink-100-light rounded-xl p-6 shadow-sm mb-8">
                    <div class="flex justify-between items-center mb-4">
                    <button id="toggleAddressBtn" class="text-pink-700 hover:text-pink-800 font-medium">
                            {{ $editingAddress ? 'Cancel' : 'Change address' }}
                        </button>
                    </div>

                    @if($editingAddress)
                        <!-- Editable Address Form -->
                        <form id="addressForm" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">First Name</label>
                                    <input type="text" value="Bridget" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Last Name</label>
                                    <input type="text" value="Serwaa" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Mobile Number</label>
                                <input type="tel" value="+1234567890" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Country</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <option selected>United States of America</option>
                                    <!-- Other countries would go here -->
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Address</label>
                                <input type="text" value="19889 Biz street" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>

                            <div>
                                <input type="text" placeholder="Enter Street name (Optional)" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">City</label>
                                    <input type="text" value="Knoxville" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">County</label>
                                    <input type="text" value="Texas" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Postcode</label>
                                <input type="text" placeholder="Enter your postcode" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>

                            <div class="flex space-x-4 pt-4">
                                <button type="button" id="saveAddressBtn" class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-2 rounded-full font-medium">
                                    Save Address
                                </button>
                                <button type="button" id="cancelEditBtn" class="border border-pink-800 text-pink-800 hover:bg-pink-50 px-6 py-2 rounded-full font-medium">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Display Address -->
                        <div class="text-gray-700 leading-relaxed">
                            <p class="font-bold">Bridget Serwaa</p>
                            <p>Texas</p>
                            <p>Knoxville</p>
                            <p>19889 Biz street</p>
                            <p>United States</p>
                            <p>+1234567890</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Card Details</h2>

                    <div class="mb-4">
                        <label for="cardNumber" class="block text-gray-700 text-sm font-medium mb-2">Card Number</label>
                        <div class="relative">
                            <input type="text" id="cardNumber" placeholder="Enter card number"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            <svg class="w-6 h-6 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="expiryDate" class="block text-gray-700 text-sm font-medium mb-2">Expiry Date</label>
                            <input type="text" id="expiryDate" placeholder="MM/YY"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                        </div>
                        <div>
                            <label for="cvv" class="block text-gray-700 text-sm font-medium mb-2">CVV</label>
                            <input type="text" id="cvv" placeholder="Enter CVV"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="nameOnCard" class="block text-gray-700 text-sm font-medium mb-2">Name on Card</label>
                        <input type="text" id="nameOnCard" placeholder="Enter the name on the card"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                    </div>

                    <button
                        class="bg-pink-200-light hover:bg-pink-300-light text-pink-800 font-semibold px-6 py-3 rounded-full w-full transition duration-300 ease-in-out">
                        Use this card
                    </button>
                </div>
            </div>

            <div class="md:col-span-1 bg-white rounded-xl p-6 shadow-sm h-fit sticky top-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Your Bill</h2>
                <div class="flex justify-between items-center mb-3">
                    <p class="text-gray-700">Product sub-total</p>
                    <p class="font-bold text-gray-900">$ 60.00</p>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-700">Delivery</p>
                    <p class="font-bold text-gray-900">$ 15.99</p>
                </div>
                <div class="flex justify-between items-center border-t border-gray-300 pt-4 mb-6">
                    <p class="text-xl font-bold text-gray-900">Total</p>
                    <p class="text-3xl font-bold text-gray-900">$ 75.99</p>
                </div>
                <button
                    class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-3 rounded-full font-medium w-full flex items-center justify-center gap-2">
                    Proceed to checkout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-white rounded-xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-800">Billing address</h3>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" placeholder="Enter first name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" placeholder="Enter last name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Mobile Number</label>
                            <input type="tel" placeholder="Enter mobile number" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Country</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option>United States of America</option>
                                <!-- Other countries would go here -->
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" placeholder="Enter your address" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <input type="text" placeholder="Enter Street name (Optional)" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">City</label>
                                <input type="text" placeholder="Enter the city you're from" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">County</label>
                                <input type="text" placeholder="Enter the county you're from" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Postcode</label>
                            <input type="text" placeholder="Enter your postcode" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <button type="button" class="bg-pink-800 hover:bg-pink-900 text-white w-full py-3 rounded-full font-medium">
                            Use this address
                        </button>
                        <button type="button" class="border border-pink-800 text-pink-800 hover:bg-pink-50 w-full py-3 rounded-full font-medium">
                            Save this address
                        </button>
                    </div>
                </form>
            </div>
        </div>


   

        <script>
            const toggleBtn = document.getElementById('toggleAddressBtn');
                const cancelBtn = document.getElementById('cancelEditBtn');
                const saveBtn = document.getElementById('saveAddressBtn');
                const addressForm = document.getElementById('addressForm');
                // alert('Address saved!');
                // console.log('Address saved!');
    
                // This would be handled by your backend in a real application
                let editingAddress = {{ $editingAddress ? 'true' : 'false' }};
    
                // Toggle between edit and view modes
                function toggleEditMode() {
                    window.location.href = "{{ request()->fullUrlWithQuery(['edit_address' => !$editingAddress]) }}";
                }
    
                toggleBtn.addEventListener('click', toggleEditMode);
                if (cancelBtn) {
                    cancelBtn.addEventListener('click', toggleEditMode);
                }
    
                if (saveBtn) {
                    saveBtn.addEventListener('click', function() {
                        // Here you would typically submit the form via AJAX or regular form submission
                        alert('Address saved!');
                        toggleEditMode();
                    });
                }
             </script>
    </section>
        <!-- @push('scripts') -->

    <!-- @endpush -->
@endsection