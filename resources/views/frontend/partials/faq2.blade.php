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
          <span class="block font-light text-primary">{{ __('common.faq.title') }}</span>
          <span class="block font-bold text-primary">{{ __('common.faq.title_bold') }}</span>
        </h1>
        <div class="w-full h-1 bg-primary-light mt-4 md:mt-0"></div>
      </div>
    </div>

    <div class="mb-10 max-w-3xl">
      <p class="text-stone-700 text-lg">
        {{ __('common.faq.subtitle') }}
      </p>
    </div>

    <div class="space-y-4">
      <!-- FAQ Item 1 - Open by default -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="true">
          <span class="font-bold">{{ __('common.faq.question_1') }}</span>
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
            {{ __('common.faq.answer_1') }} <a
              href="mailto:info@afrojee.store" class="text-[#ef380d] hover:underline">info@afrojee.store</a>.
          </p>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">{{ __('common.faq.question_2') }}</span>
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
            {{ __('common.faq.answer_2') }}
          </p>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">{{ __('common.faq.question_3') }}</span>
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
            {{ __('common.faq.answer_3') }}
          </p>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">{{ __('common.faq.question_4') }}</span>
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
            {{ __('common.faq.answer_4') }}
          </p>
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div
        class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
          aria-expanded="false">
          <span class="font-bold">{{ __('common.faq.question_5') }}</span>
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
            {{ __('common.faq.answer_5') }}
          </p>
        </div>
      </div>
    </div>

    <div class="flex justify-end mt-10">
      <a href="/faq"
        class="bg-[#ef380d] text-white px-6 py-3 rounded-full flex items-center hover:bg-[#d6320c] transition-colors duration-300">
        {{ __('common.faq.view_more') }}
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