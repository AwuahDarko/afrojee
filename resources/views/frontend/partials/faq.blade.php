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

    .faq-item {
      height: 4rem; /* h-16 */
      transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .faq-item.active {
      height: auto; /* h-full equivalent */
    }
  </style>

<section class="bg-[#f5f3e8]">
  <div class="max-w-3xl mx-auto px-4 py-16">
    <div>
      <h2 class="text-5xl font-semibold text-gray-700">Got</h2>
      <h2 class="text-5xl font-semibold text-gray-700 mb-6">Questions?</h2>
      <div class="border-t border-gray-300 mb-8"></div>
      <p class="text-gray-700 mb-10">
        Check out our FAQ section where we've answered some of the most common queries to help you get the most out of our products
      </p>
    </div>
    
    <div class="space-y-4">
      <!-- FAQ Item 1 - Open by default -->
      <div class="faq-item border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none" aria-expanded="true">
          <span class="font-bold">Are your products suitable for all skin and hair types?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </span>
            <span class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content active px-6 pb-4">
          <p class="text-gray-700">
            Yes, our products are designed to be gentle and effective for all skin and hair types, including sensitive skin and delicate hair
          </p>
        </div>
      </div>
      
      <!-- FAQ Item 2 -->
      <div class="faq-item border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none" aria-expanded="false">
          <span class="font-bold">Can I buy your products in physical stores?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </span>
            <span class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-gray-700">
            Yes, our products are available in select retail locations across the country. We partner with beauty boutiques, spa retreats, and select department stores. You can use our store locator on our website to find the nearest retailer carrying Afro Jee products.
          </p>
        </div>
      </div>
      
      <!-- FAQ Item 3 -->
      <div class="faq-item border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none" aria-expanded="false">
          <span class="font-bold">Do you offer any discounts or promotions?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </span>
            <span class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-gray-700">
            Yes, we frequently offer seasonal promotions and special discounts. Subscribe to our newsletter to stay updated on our latest offers. We also have a loyalty program where you earn points on every purchase that can be redeemed for discounts on future orders.
          </p>
        </div>
      </div>
      
      <!-- FAQ Item 4 -->
      <div class="faq-item border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none" aria-expanded="false">
          <span class="font-bold">How long will it take to receive my order?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </span>
            <span class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-gray-700">
            Domestic orders typically arrive within 3-5 business days. International shipping can take 7-14 business days depending on your location. We offer expedited shipping options at checkout if you need your products sooner.
          </p>
        </div>
      </div>
      
      <!-- FAQ Item 5 -->
      <div class="faq-item border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
        <button class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none" aria-expanded="false">
          <span class="font-bold">How should I store my products?</span>
          <div class="relative ml-2">
            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </span>
            <span class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
              <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
              </svg>
            </span>
          </div>
        </button>
        <div class="faq-content px-6 pb-4">
          <p class="text-gray-700">
            For optimal quality and longevity, store your Afro Jee products in a cool, dry place away from direct sunlight. Some of our products containing natural ingredients may be better stored in the refrigerator, particularly during hot weather. Each product label provides specific storage instructions.
          </p>
        </div>
      </div>
    </div>
    
    <div class="flex justify-end mt-10">
      <a href="#" class="bg-rose-700 text-white px-6 py-3 rounded-full flex items-center hover:bg-rose-800 transition-colors duration-300">
        View More
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </a>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const faqButtons = document.querySelectorAll('.faq-button');
      
      // Set first item as active by default
      if (faqButtons.length > 0) {
        faqButtons[0].setAttribute('aria-expanded', 'true');
        faqButtons[0].nextElementSibling.classList.add('active');
        faqButtons[0].closest('.faq-item').classList.add('active');

      }
      
      faqButtons.forEach(button => {
        button.addEventListener('click', () => {
          const isExpanded = button.getAttribute('aria-expanded') === 'true';
          const faqItem = button.closest('.faq-item');
          
          // Close all FAQs
          faqButtons.forEach(btn => {
            const content = btn.nextElementSibling;
            if (btn !== button) {
              btn.setAttribute('aria-expanded', 'false');
              content.classList.remove('active');
            }
          });
          
          // Toggle the clicked FAQ
          button.setAttribute('aria-expanded', !isExpanded);
          const content = button.nextElementSibling;
          content.classList.toggle('active');
          button.parentElement.toggle('active')
        });
      });
    });


    document.addEventListener('DOMContentLoaded', function() {
      const faqButtons = document.querySelectorAll('.faq-button');
      
      // Set first item as active by default
      if (faqButtons.length > 0) {
        faqButtons[0].setAttribute('aria-expanded', 'true');
        faqButtons[0].closest('.faq-item').classList.add('active');
      }
      
      faqButtons.forEach(button => {
        button.addEventListener('click', () => {
          const isExpanded = button.getAttribute('aria-expanded') === 'true';
          const faqItem = button.closest('.faq-item');
          
          // Close all FAQs
          document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) {
              item.classList.remove('active');
              item.querySelector('.faq-button').setAttribute('aria-expanded', 'false');
            }
          });
          
          // Toggle the clicked FAQ
          button.setAttribute('aria-expanded', !isExpanded);
          faqItem.classList.toggle('active');
        });
      });
    });
  
  </script>
</section>