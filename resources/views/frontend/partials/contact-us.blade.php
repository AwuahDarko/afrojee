@extends('frontend.layouts.app')

@section('title', 'Contact Us | Afro Jee')

@section('content')

<!-- Contact Hero Section -->
<section class="bg-white py-20 px-6 md:px-20">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-light mb-6 text-gray-900">
            Keep In Touch with Us
        </h1>
        <p class="text-gray-500 text-lg max-w-3xl mx-auto leading-relaxed">
            We're talking about clean beauty gift sets, of course – and we've got a bouquet of beauties for yourself or someone you love.
        </p>
    </div>
</section>

<!-- Contact Form & Info Section -->
<section class="bg-[#F8F7F4] py-20 px-6 md:px-20">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16">
            
            <!-- Left Column - Contact Form -->
            <div>
                <h2 class="text-4xl font-light mb-8 text-gray-900">Send A Message</h2>
                
                @if(session('contact_success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6">
                        <p class="font-medium">{{ session('contact_success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg mb-6">
                        <p class="font-medium mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name & Email Row -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <input type="text" 
                                   name="name" 
                                   placeholder="Name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition">
                        </div>
                        <div>
                            <input type="email" 
                                   name="email" 
                                   placeholder="Email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition">
                        </div>
                    </div>

                    <!-- Phone (Optional) -->
                    <div>
                        <input type="tel" 
                               name="phone" 
                               placeholder="Phone (Optional)" 
                               value="{{ old('phone') }}"
                               class="w-full px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition">
                    </div>

                    <!-- Subject -->
                    <div>
                        <input type="text" 
                               name="subject" 
                               placeholder="Subject" 
                               value="{{ old('subject') }}"
                               required
                               class="w-full px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition">
                    </div>

                    <!-- Message -->
                    <div>
                        <textarea name="message" 
                                  rows="6" 
                                  placeholder="Message" 
                                  required
                                  class="w-full px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition resize-none">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="bg-gray-900 hover:bg-gray-800 text-white px-12 py-4 rounded-lg font-medium transition-all duration-300 hover:scale-105 shadow-sm">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column - Contact Info -->
            <div class="space-y-12">
                
                <!-- Address -->
                <div class="hidden">
                    <h3 class="text-2xl font-light mb-6 text-gray-900">Address</h3>
                    <div class="space-y-4 text-gray-600">
                        <p class="text-lg leading-relaxed">
                            Carrer de Balmes, 123<br>
                            Barcelona, Spain 08008
                        </p>
                        <p class="text-lg leading-relaxed">
                            Accra, Ghana<br>
                            West Africa
                        </p>
                    </div>
                    <a href="https://www.google.com/maps" 
                       target="_blank"
                       class="inline-block mt-4 text-gray-900 font-medium border-b-2 border-gray-900 hover:border-gray-600 transition">
                        Get Direction
                    </a>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-2xl font-light mb-6 text-gray-900">Contact</h3>
                    <div class="space-y-3 text-gray-600 text-lg">
                        <p>
                            <span class="text-gray-500">Mobile:</span> 
                            <a href="tel:+34602181565" class="text-gray-900 hover:text-[#ef380d] transition">
                                +34 602 181 565
                            </a>
                        </p>
                        <p>
                            <span class="text-gray-500">WhatsApp:</span> 
                            <a href="https://wa.me/34602181565" target="_blank" class="text-gray-900 hover:text-[#ef380d] transition">
                                +34 602 181 565
                            </a>
                        </p>
                        <p>
                            <span class="text-gray-500">E-mail:</span> 
                            <a href="mailto:info@afrojee.store" class="text-gray-900 hover:text-[#ef380d] transition">
                                info@afrojee.store
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="text-2xl font-light mb-6 text-gray-900">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="https://www.instagram.com/afro_jeee/" 
                           target="_blank"
                           class="w-12 h-12 bg-white hover:bg-gray-900 text-gray-900 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/34602181565" 
                           target="_blank"
                           class="w-12 h-12 bg-white hover:bg-gray-900 text-gray-900 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com" 
                           target="_blank"
                           class="w-12 h-12 bg-white hover:bg-gray-900 text-gray-900 hover:text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-110">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="bg-white">
    <div class="w-full h-96">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2993.2589447429745!2d2.158774315451679!3d41.39361997926457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4a2f8b5b5b5b5%3A0x0!2zNDHCsDIzJzM3LjAiTiAywrAwOSczMy4wIkU!5e0!3m2!1sen!2ses!4v1234567890123!5m2!1sen!2ses" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            class="grayscale">
        </iframe>
    </div>
</section>

<!-- Newsletter Section -->
<section class="bg-[#F8F7F4] py-20 px-6 md:px-20">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-light mb-6 text-gray-900">
            Stay Updated
        </h2>
        <p class="text-gray-500 text-lg mb-8 max-w-2xl mx-auto">
            Subscribe to our newsletter for exclusive offers, hair care tips, and product updates.
        </p>
        
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            @csrf
            <input type="email" 
                   name="newsletter_email" 
                   placeholder="Enter your email" 
                   required
                   class="flex-1 px-6 py-4 bg-white border-0 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 transition">
            <button type="submit" 
                    class="bg-gray-900 hover:bg-gray-800 text-white px-8 py-4 rounded-lg font-medium transition-all duration-300 hover:scale-105 shadow-sm whitespace-nowrap">
                Subscribe
            </button>
        </form>
    </div>
</section>

<style>
/* Form input animations */
input:focus, textarea:focus {
    transform: translateY(-2px);
}

/* Smooth transitions */
* {
    transition: all 0.2s ease;
}

/* Map grayscale effect */
iframe.grayscale {
    filter: grayscale(100%) contrast(1.2);
}

iframe.grayscale:hover {
    filter: grayscale(0%) contrast(1);
}
</style>

@endsection