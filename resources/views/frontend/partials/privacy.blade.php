@extends('frontend.layouts.app')

@section('title', 'Privacy Policy | Afro Jee')

@section('content')
<section class="bg-gradient-to-br from-[#F5F3E7] to-orange-50/30 py-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-gray-800 mb-4">
                Privacy <span class="font-bold text-[#ef380d]">Policy</span>
            </h2>
            <div class="w-24 h-1 bg-[#ef380d] mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.
            </p>
            <p class="text-gray-500 text-sm mt-4">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 space-y-8">
            <!-- Section 1: Introduction -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">1. Introduction</h3>
                <p class="text-gray-700 leading-relaxed">
                    At Afro Jee, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase.
                </p>
            </div>

            <!-- Section 2: Information We Collect -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">2. Information We Collect</h3>
                <p class="text-gray-700 leading-relaxed mb-4">We collect information that you provide directly to us, including:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li><strong>Personal Information:</strong> Name, email address, phone number, billing and shipping addresses</li>
                    <li><strong>Payment Information:</strong> Credit card details, payment method information (processed securely through our payment gateway)</li>
                    <li><strong>Order Information:</strong> Products purchased, order history, preferences</li>
                    <li><strong>Communication Information:</strong> Messages, inquiries, and feedback you send to us</li>
                </ul>
                <p class="text-gray-700 leading-relaxed mb-4">We also automatically collect certain information when you visit our website:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li><strong>Usage Data:</strong> IP address, browser type, device information, pages visited, time spent on pages</li>
                    <li><strong>Cookies:</strong> We use cookies to enhance your browsing experience and analyze website traffic</li>
                </ul>
            </div>

            <!-- Section 3: How We Use Your Information -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">3. How We Use Your Information</h3>
                <p class="text-gray-700 leading-relaxed mb-4">We use the information we collect to:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li>Process and fulfill your orders</li>
                    <li>Send you order confirmations, shipping updates, and delivery notifications</li>
                    <li>Respond to your inquiries and provide customer support</li>
                    <li>Send you marketing communications (only with your consent) including newsletters and promotional offers</li>
                    <li>Improve our website, products, and services</li>
                    <li>Detect and prevent fraud or abuse</li>
                    <li>Comply with legal obligations</li>
                </ul>
            </div>

            <!-- Section 4: Information Sharing -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">4. Information Sharing and Disclosure</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li><strong>Service Providers:</strong> We may share information with trusted third-party service providers who assist us in operating our website, processing payments, shipping orders, and conducting business</li>
                    <li><strong>Legal Requirements:</strong> We may disclose information if required by law or in response to valid legal requests</li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of the transaction</li>
                    <li><strong>With Your Consent:</strong> We may share information with your explicit consent</li>
                </ul>
            </div>

            <!-- Section 5: Data Security -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">5. Data Security</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    All payments are processed through trusted, encrypted gateways that comply with PCI DSS standards. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    If you suspect any unauthorized use of your account or breach of security, please contact us immediately at <a href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a>.
                </p>
            </div>

            <!-- Section 6: Cookies and Tracking -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">6. Cookies and Tracking Technologies</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We use cookies and similar tracking technologies to enhance your browsing experience, analyze website traffic, and understand user preferences. Cookies are small text files stored on your device.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">Types of cookies we use:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li><strong>Essential Cookies:</strong> Required for the website to function properly</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our website</li>
                    <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements and track campaign performance</li>
                </ul>
                <p class="text-gray-700 leading-relaxed">
                    You can control cookies through your browser settings. However, disabling cookies may limit your ability to use certain features of our website.
                </p>
            </div>

            <!-- Section 7: Your Rights -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">7. Your Rights</h3>
                <p class="text-gray-700 leading-relaxed mb-4">Under applicable data protection laws, you have the right to:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4 ml-4">
                    <li><strong>Access:</strong> Request a copy of the personal information we hold about you</li>
                    <li><strong>Rectification:</strong> Request correction of inaccurate or incomplete information</li>
                    <li><strong>Erasure:</strong> Request deletion of your personal information (subject to legal obligations)</li>
                    <li><strong>Restriction:</strong> Request limitation of processing of your information</li>
                    <li><strong>Data Portability:</strong> Receive your data in a structured, commonly used format</li>
                    <li><strong>Objection:</strong> Object to processing of your information for marketing purposes</li>
                    <li><strong>Withdraw Consent:</strong> Withdraw consent at any time where processing is based on consent</li>
                </ul>
                <p class="text-gray-700 leading-relaxed">
                    To exercise any of these rights, please contact us at <a href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a>. We will respond to your request within 30 days.
                </p>
            </div>

            <!-- Section 8: Data Retention -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">8. Data Retention</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We retain your personal information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    When we no longer need your information, we will securely delete or anonymize it in accordance with our data retention policies and applicable laws.
                </p>
            </div>

            <!-- Section 9: Children's Privacy -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">9. Children's Privacy</h3>
                <p class="text-gray-700 leading-relaxed">
                    Our website and services are not intended for children under the age of 18. We do not knowingly collect personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately so we can delete such information.
                </p>
            </div>

            <!-- Section 10: International Transfers -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">10. International Data Transfers</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Your information may be transferred to and processed in countries other than your country of residence. These countries may have data protection laws that differ from those in your country.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    When we transfer your information internationally, we ensure appropriate safeguards are in place to protect your data in accordance with applicable data protection laws.
                </p>
            </div>

            <!-- Section 11: Changes to Privacy Policy -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">11. Changes to This Privacy Policy</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of any material changes by posting the new Privacy Policy on this page and updating the "Last updated" date.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    We encourage you to review this Privacy Policy periodically to stay informed about how we protect your information.
                </p>
            </div>

            <!-- Section 12: Contact Information -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">12. Contact Us</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:
                </p>
                <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-6 rounded-xl border border-[#ef380d]/10">
                    <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a></p>
                    <p class="text-gray-700 mb-2"><strong>Address:</strong> Barcelona, Spain</p>
                    <p class="text-gray-700">We aim to respond to all privacy-related inquiries within 30 days.</p>
                </div>
            </div>

            <!-- Section 13: Governing Law -->
            <div>
                <h3 class="text-2xl font-bold text-[#ef380d] mb-4">13. Governing Law</h3>
                <p class="text-gray-700 leading-relaxed">
                    This Privacy Policy is governed by and construed in accordance with the General Data Protection Regulation (GDPR) and the laws of Spain. If you are located outside the European Union, additional privacy rights may apply under your local laws.
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

