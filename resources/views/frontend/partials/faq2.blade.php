<!-- <style>
    .faq-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .faq-content.active {
      max-height: 1000px;
      transition: max-height 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .plus-icon, .minus-icon {
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    
    .faq-button[aria-expanded="true"] .plus-icon {
      opacity: 0;
      transform: rotate(90deg);
    }
    
    .faq-button[aria-expanded="false"] .minus-icon {
      opacity: 0;
      transform: rotate(-90deg);
    }
    
    .faq-button[aria-expanded="true"] span:not(.plus-icon):not(.minus-icon) {
      color: #be123c; /* rose-700 */
      transition: color 0.3s ease;
    }
    
    .faq-button[aria-expanded="false"] span:not(.plus-icon):not(.minus-icon) {
      color: #374151; /* gray-700 */
      transition: color 0.3s ease;
    }
    
    /* Smooth transform for the icons */
    .plus-icon, .minus-icon {
      transform-origin: center;
    }
    
    .faq-button[aria-expanded="true"] .minus-icon {
      opacity: 1;
      transform: rotate(0deg);
    }
    
    .faq-button[aria-expanded="false"] .plus-icon {
      opacity: 1;
      transform: rotate(0deg);
    }
  </style> -->
<script src="{{ asset('js/admin.js') }}"></script>

<section class="bg-[#f5f3e8]">
  <div class="container mx-auto px-6 py-16">

    <div class="mb-12">
      <div class="flex flex-col md:flex-row items-center justify-items-start">
        <h1 class="text-4xl md:text-5xl lg:text-6xl min-w-[26%] text-left">
          <span class="block font-light text-primary">Got</span>
          <span class="block font-bold text-primary">Questions?</span>
        </h1>
        <div class="w-full h-1 bg-primary-light mt-4 md:mt-0"></div>
      </div>
    </div>

    <div class="mb-16 max-w-3xl">
      <p class="text-stone-700 text-lg">
        Check out our FAQ section where we've answered some of the most common queries to help you get the most out of
        our products
      </p>
    </div>

    <div class="space-y-4">
      <!-- FAQ Item 1 - Open by default -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="true">
          <span class="font-bold">Do you ship internationally?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
              </svg>
            </span>
            <span
              class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content active px-6 pb-4">
          <p class="text-gray-700">
            Certainly! We ship internationally. The estimated delivery time will be displayed at checkout and depends on
            your delivery destination and selected shipping method. For further assistance, contact us at <a
              href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a>.
          </p>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">When will my order be processed?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
              </svg>
            </span>
            <span
              class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4 hidden">
          <p class="text-gray-700">
            All orders are shipped within 2 working days (excluding weekends and bank holidays). Once your order has
            been shipped, you'll receive a confirmation email with tracking information.
          </p>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">What payment options do you accept?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
              </svg>
            </span>
            <span
              class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4 hidden">
          <p class="text-gray-700">
            We offer several secure payment options: all major credit and debit cards (Visa, MasterCard, American
            Express, Maestro), PayPal, and Apple Pay. All payments are processed through trusted, encrypted gateways to
            ensure your data remains secure.
          </p>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">Are your products suitable for all hair types?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
              </svg>
            </span>
            <span
              class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4 hidden">
          <p class="text-gray-700">
            Yes! Afro Jee products are specially formulated for afro-textured hair but work wonderfully on all hair
            types. Our natural ingredients are gentle yet effective, making them suitable for various curl patterns and
            textures.
          </p>
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">How should I store my Afro Jee products?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
              </svg>
            </span>
            <span
              class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4 hidden">
          <p class="text-gray-700">
            Store your Afro Jee products in a cool, dry place away from direct sunlight. Some products with natural
            ingredients may benefit from refrigeration during hot weather. Always check product labels for specific
            storage instructions.
          </p>
        </div>
      </div>
    </div>

    <div class="flex justify-end mt-10">
      <a href="/faq"
        class="bg-[#ef380d] text-white px-6 py-3 rounded-full flex items-center hover:bg-[#d6320c] transition-colors duration-300">
        View More
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </a>
    </div>
  </div>
</section>

<style>
  .faq-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .faq-content.active {
    max-height: 1000px;
    transition: max-height 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .plus-icon,
  .minus-icon {
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
  }

  .faq-button[aria-expanded="true"] .plus-icon {
    opacity: 0;
    transform: rotate(90deg);
  }

  .faq-button[aria-expanded="false"] .minus-icon {
    opacity: 0;
    transform: rotate(-90deg);
  }

  .faq-button[aria-expanded="true"] span:not(.plus-icon):not(.minus-icon) {
    color: #ef380d;
    transition: color 0.3s ease;
  }

  .faq-button[aria-expanded="false"] span:not(.plus-icon):not(.minus-icon) {
    color: #374151;
    transition: color 0.3s ease;
  }

  .plus-icon,
  .minus-icon {
    transform-origin: center;
  }

  .faq-button[aria-expanded="true"] .minus-icon {
    opacity: 1;
    transform: rotate(0deg);
  }

  .faq-button[aria-expanded="false"] .plus-icon {
    opacity: 1;
    transform: rotate(0deg);
  }
</style>