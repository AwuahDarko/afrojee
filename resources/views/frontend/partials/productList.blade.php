@extends('frontend.layouts.app') @section('content')
  <section class="bg-[#f7f3e9] py-16 px-6">
    <div class="max-w-7xl mx-auto text-center">
    <!-- Header -->
    <div class="mb-12">
      <div class="flex items-center mb-2">
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe mb-2">
        View <br /><span class="font-bold">Our Products</span>
      </h2>
      <div class="bg-taupe h-1 backdrop-blur-sm w-full min-w-lg mt-4 mb-8"></div>
      </div>
      <p class="text-taupe text-lg md:text-xl max-w-4xl">
      Explore our collection and find the perfect products to elevate your
      beauty routine
      </p>
    </div>

    <!-- Search Bar -->
    <div
      class="max-w-lg mb-8 flex justify-start items-center bg-white border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
      <input id="productSearch" type="text" placeholder="Enter product to search"
      class="flex-grow bg-transparent focus:outline-none text-gray-700" />
      <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
      </svg>
    </div>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap justify-start gap-4 mb-10">
      <button data-filter="all"
      class="filter-btn active-filter px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-colors duration-200">
      All Products
      </button>
      @foreach($categories as $category)
      <button data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}"
      class="filter-btn px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-colors duration-200">
      {{ $category->name }}
      </button>
    @endforeach
    </div>

    <!-- Product Grid -->
    <div id="productGrid" class="grid gap-10 sm:grid-cols-2 md:grid-cols-3">
      @foreach($products as $product)
      <div class="product-card text-left"
      data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">
      <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded-lg w-full h-90 mb-4" />
      <h3 class="font-semibold text-gray-800 text-lg mb-2">
      {{ $product->name }}
      </h3>
      <p class="text-gray-700 mb-4">
      ${{ number_format($product->price, 2) }}
      </p>
      <div class="flex items-center gap-4">
      <button
      class="bg-pink-800 hover:bg-pink-900 text-white w-full justify-center px-6 py-2 rounded-full font-medium flex items-center gap-2 transition-colors duration-200">
      Buy Now
      <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#a)">
        <g clip-path="url(#b)">
        <g clip-path="url(#c)">
        <mask id="d" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="31"
          height="32">
          <path d="M31 .5v31H0V.5z" fill="#fff" />
        </mask>
        <g mask="url(#d)">
          <path
          d="M17.558 24.318 25.834 16l-8.276-8.32a.86.86 0 1 0-1.196 1.215l6.19 6.242H6.08a.861.861 0 1 0 0 1.723h16.473l-6.191 6.243a.86.86 0 0 0-.011 1.233.86.86 0 0 0 1.233-.019z"
          fill="#fff" />
        </g>
        </g>
        </g>
        </g>
        <defs>
        <clipPath id="a">
        <path fill="#fff" d="M0 .5h31v31H0z" />
        </clipPath>
        <clipPath id="b">
        <path fill="#fff" d="M0 .5h31v31H0z" />
        </clipPath>
        <clipPath id="c">
        <path fill="#fff" d="M0 .5h31v31H0z" />
        </clipPath>
        </defs>
      </svg>
      </button>
      <button class="bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100 transition-colors duration-200">
      <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#a)" fill="#99395C">
        <path
        d="M21.25 22.5a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.113-2.5 2.5-2.5m-20-20h4.088L6.513 5H25a1.25 1.25 0 0 1 1.25 1.25c0 .213-.062.425-.15.625l-4.475 8.088a2.51 2.51 0 0 1-2.187 1.287h-9.313L9 18.288l-.037.15a.313.313 0 0 0 .312.312H23.75v2.5h-15a2.5 2.5 0 0 1-2.5-2.5c0-.437.112-.85.3-1.2l1.7-3.062L3.75 5h-2.5zm7.5 20a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.112-2.5 2.5-2.5M20 13.75l3.475-6.25h-15.8l2.95 6.25z" />
        <path d="M25 15.5v6h6v4h-6v6h-4v-6h-6v-4h6v-6z" stroke="#F4F3E7" stroke-width="2" />
        </g>
        <defs>
        <clipPath id="a">
        <path fill="#fff" d="M0 0h30v30H0z" />
        </clipPath>
        </defs>
      </svg>
      </button>
      </div>
      </div>
    @endforeach
    </div>
    </div>
  </section>

<script>
  const filterButtons = document.querySelectorAll('.filter-btn');
  const products = document.querySelectorAll('.product-card');
  const searchInput = document.getElementById('productSearch');

  // Initialize GSAP timeline
  let tl = gsap.timeline();

  // Function to animate product filtering
  function animateProducts(visibleProducts, hiddenProducts) {
    // First hide products that should be hidden
    if (hiddenProducts.length > 0) {
      gsap.to(hiddenProducts, {
        opacity: 0,
        scale: 0.8,
        y: -20,
        duration: 0.3,
        ease: "power2.in",
        stagger: 0.05,
        onComplete: function() {
          hiddenProducts.forEach(product => {
            product.style.display = 'none';
          });
        }
      });
    }

    // Then show and animate visible products
    if (visibleProducts.length > 0) {
      // Set initial state for visible products
      visibleProducts.forEach(product => {
        product.style.display = 'block';
        gsap.set(product, { opacity: 0, scale: 0.8, y: 20 });
      });

      // Animate in visible products with stagger
      gsap.to(visibleProducts, {
        opacity: 1,
        scale: 1,
        y: 0,
        duration: 0.5,
        ease: "power2.out",
        stagger: 0.08,
        delay: hiddenProducts.length > 0 ? 0.2 : 0
      });
    }
  }

  // Enhanced filter button functionality
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');

      // Update active button style with animation
      filterButtons.forEach(btn => {
        btn.classList.remove('active-filter');
        gsap.to(btn, { scale: 1, duration: 0.2 });
      });
      
      button.classList.add('active-filter');
      gsap.to(button, { scale: 1.05, duration: 0.2, yoyo: true, repeat: 1 });

      // Categorize products
      const visibleProducts = [];
      const hiddenProducts = [];

      products.forEach(product => {
        const category = product.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          visibleProducts.push(product);
        } else {
          hiddenProducts.push(product);
        }
      });

      // Animate the transition
      animateProducts(visibleProducts, hiddenProducts);

      // Clear search input on filter change
      if (searchInput) {
        searchInput.value = '';
        gsap.to(searchInput, { scale: 1.02, duration: 0.1, yoyo: true, repeat: 1 });
      }
    });
  });

  // Enhanced search functionality with animations
  if (searchInput) {
    let searchTimeout;
    
    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimeout);
      
      // Debounce search for better performance
      searchTimeout = setTimeout(() => {
        const query = searchInput.value.toLowerCase();
        const visibleProducts = [];
        const hiddenProducts = [];

        products.forEach(product => {
          const name = product.querySelector('h3').textContent.toLowerCase();
          if (name.includes(query)) {
            visibleProducts.push(product);
          } else {
            hiddenProducts.push(product);
          }
        });

        // Animate search results
        animateProducts(visibleProducts, hiddenProducts);

        // Reset filter buttons active state when searching
        if (query.length > 0) {
          filterButtons.forEach(btn => {
            btn.classList.remove('active-filter');
            gsap.to(btn, { scale: 1, duration: 0.2 });
          });
        }
      }, 200);
    });

    // Add focus animation to search input
    searchInput.addEventListener('focus', () => {
      gsap.to(searchInput.parentElement, { 
        scale: 1.02, 
        boxShadow: "0 0 0 3px rgba(219, 39, 119, 0.1)",
        duration: 0.3 
      });
    });

    searchInput.addEventListener('blur', () => {
      gsap.to(searchInput.parentElement, { 
        scale: 1, 
        boxShadow: "0 1px 3px 0 rgba(0, 0, 0, 0.1)",
        duration: 0.3 
      });
    });
  }

  // Initial animation on page load
  document.addEventListener('DOMContentLoaded', () => {
    gsap.from('.product-card', {
      opacity: 0,
      y: 30,
      scale: 0.9,
      duration: 0.6,
      ease: "power2.out",
      stagger: 0.1
    });

    gsap.from('.filter-btn', {
      opacity: 0,
      y: -20,
      duration: 0.5,
      ease: "power2.out",
      stagger: 0.05,
      delay: 0.2
    });

    gsap.from('#productSearch', {
      opacity: 0,
      x: -30,
      duration: 0.5,
      ease: "power2.out",
      delay: 0.4
    });
  });

  // Add hover animations to product cards
  products.forEach(product => {
    product.addEventListener('mouseenter', () => {
      gsap.to(product, {
        y: -5,
        scale: 1.02,
        duration: 0.3,
        ease: "power2.out"
      });
    });

    product.addEventListener('mouseleave', () => {
      gsap.to(product, {
        y: 0,
        scale: 1,
        duration: 0.3,
        ease: "power2.out"
      });
    });
  });

  // Add click animation to buttons
  document.querySelectorAll('button').forEach(button => {
    button.addEventListener('click', (e) => {
      if (!button.classList.contains('filter-btn')) {
        gsap.to(button, {
          scale: 0.95,
          duration: 0.1,
          yoyo: true,
          repeat: 1,
          ease: "power2.inOut"
        });
      }
    });
  });
</script>
@endsection