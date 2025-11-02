@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions | Afro Jee')

@section('content')
<section class="bg-gradient-to-br from-[#F5F3E7] to-orange-50/30 py-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-gray-800 mb-4">
                Terms & <span class="font-bold text-[#ef380d]">Conditions</span>
            </h2>
            <div class="w-24 h-1 bg-[#ef380d] mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                Please read these terms and conditions carefully before using our website and making a purchase.
            </p>
            <p class="text-gray-500 text-sm mt-4">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 space-y-8">
            <!-- Section 1: Acceptance of Terms -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">1. Acceptance of Terms</h3>
                <p class="text-gray-700 leading-relaxed">
                    By accessing and using the Afro Jee website and purchasing our products, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, please do not use our website or purchase our products.
                </p>
            </div>

            <!-- Section 2: Products and Pricing -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">2. Products and Pricing</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    All products displayed on our website are subject to availability. We reserve the right to limit quantities and discontinue any product at any time.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    All prices are displayed in Euros (€). Prices are subject to change without notice. We strive to ensure accuracy in pricing, but errors may occur. In the event of a pricing error, we reserve the right to refuse or cancel any orders placed at the incorrect price.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    For international orders shipped from Spain, customs duties or additional fees may apply depending on the destination country. These charges are the responsibility of the customer.
                </p>
            </div>

            <!-- Section 3: Orders and Payment -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">3. Orders and Payment</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    When you place an order, you are making an offer to purchase products at the prices stated. We reserve the right to accept or decline your order for any reason.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We accept the following payment methods:
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li>All major credit and debit cards (Visa, MasterCard, American Express, Maestro)</li>
                    <li>PayPal</li>
                    <li>Apple Pay</li>
                </ul>
                <p class="text-gray-700 leading-relaxed">
                    All payments are processed through trusted, encrypted gateways. Payment is required at the time of order placement. Your order will not be processed until payment is confirmed.
                </p>
            </div>

            <!-- Section 4: Shipping and Delivery -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">4. Shipping and Delivery</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Shipping rates vary depending on your location and will be automatically calculated during checkout. All orders are processed within one working day (excluding weekends and holidays).
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Once your package has been shipped, you will receive a confirmation email with your tracking number so you can follow your delivery in real time.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Estimated delivery times are provided for guidance only and are not guaranteed. We are not liable for delays caused by shipping carriers or customs.
                </p>
            </div>

            <!-- Section 5: Returns and Refunds -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">5. Returns and Refunds</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Due to the nature of our handmade and personal care items, we only accept returns in specific cases, such as if the product arrives damaged, defective, or affected by an incident during shipping.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    To initiate a return, please contact us within 15 days of receiving your order at <a href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a>, including your order number, photos of the issue, and a brief description of what happened.
                </p>
                <p class="text-gray-700 leading-relaxed mb-2 font-semibold">We do not accept returns or exchanges if:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li>The product has been opened, used, or damaged after delivery</li>
                    <li>Items are not in their original packaging, unused and sealed</li>
                    <li>The return is requested for reasons related to preference, scent, or texture</li>
                    <li>The return has not been authorized by our team</li>
                </ul>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If your return is approved, your refund will be issued to the original payment method within 10 business days. Please note that banks or credit card providers may take a few additional days to process the transaction.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    All return shipping costs are the responsibility of the customer, unless the return is due to an error on our part or a damaged item.
                </p>
            </div>

            <!-- Section 6: Product Use and Safety -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">6. Product Use and Safety</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Our products are made with natural ingredients and are designed for personal care use. Please read all product labels and instructions before use.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you experience any adverse reactions, discontinue use immediately and consult a healthcare professional. We are not responsible for any allergic reactions or adverse effects resulting from product use.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Store products in a cool, dry place away from direct sunlight. Some products with natural ingredients may benefit from refrigeration during hot weather.
                </p>
            </div>

            <!-- Section 7: Intellectual Property -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">7. Intellectual Property</h3>
                <p class="text-gray-700 leading-relaxed">
                    All content on this website, including text, graphics, logos, images, and software, is the property of Afro Jee and is protected by copyright and trademark laws. You may not reproduce, distribute, or create derivative works from any content on this website without our express written permission.
                </p>
            </div>

            <!-- Section 8: Limitation of Liability -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">8. Limitation of Liability</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    To the fullest extent permitted by law, Afro Jee shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible losses.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Our total liability for any claim arising from your use of our products or website shall not exceed the amount you paid for the product in question.
                </p>
            </div>

            <!-- Section 9: Changes to Terms -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">9. Changes to Terms</h3>
                <p class="text-gray-700 leading-relaxed">
                    We reserve the right to modify these Terms and Conditions at any time. Changes will be effective immediately upon posting to our website. Your continued use of our website or products after changes are posted constitutes your acceptance of the modified terms.
                </p>
            </div>

            <!-- Section 10: Contact Information -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">10. Contact Information</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have any questions about these Terms and Conditions, please contact us:
                </p>
                <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-6 rounded-xl border border-[#ef380d]/10">
                    <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a></p>
                    <p class="text-gray-700">We aim to respond to all inquiries within 24 hours.</p>
                </div>
            </div>

            <!-- Section 11: Governing Law -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">11. Governing Law</h3>
                <p class="text-gray-700 leading-relaxed">
                    These Terms and Conditions are governed by and construed in accordance with the laws of Spain. Any disputes arising from these terms or your use of our website shall be subject to the exclusive jurisdiction of the courts of Barcelona, Spain.
                </p>
            </div>
        </div>

        <!-- Back to FAQ Link -->
        <div class="text-center mt-12">
            <a href="{{ route('web.questions') }}" class="inline-flex items-center text-[#ef380d] hover:text-[#d6320c] font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to FAQs
            </a>
        </div>
    </div>
</section>
@endsection

