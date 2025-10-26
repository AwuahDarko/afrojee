window.addEventListener("DOMContentLoaded", () => {
  // Quantity Counter Logic
  const decrementButton = document.getElementById('decrement');
  const incrementButton = document.getElementById('increment');
  const quantityInput = document.getElementById('quantity');

  // decrementButton.addEventListener('click', () => {
  //   let currentValue = parseInt(quantityInput.value);
  //   if (currentValue > 1) {
  //     quantityInput.value = currentValue - 1;
  //   }
  // });

  // incrementButton.addEventListener('click', () => {
  //   let currentValue = parseInt(quantityInput.value);
  //   quantityInput.value = currentValue + 1;
  // });

  // Quantity Counter Logic
  const buyNowCounter = document.getElementById('buyNowCounter');
  const addToCartCounter = document.getElementById('addToCartCounter');

  // Function to update counters
  const updateCounters = () => {
    const currentValue = parseInt(quantityInput.value);
    // buyNowCounter.textContent = currentValue;
    // addToCartCounter.textContent = currentValue;
    const nav = document.getElementById('buy-now-link')
    const link = nav.getAttribute('href')
    const arr = link.split('/')
    arr[arr.length - 2] = currentValue  // Adjust for quantity in URL
    const newlink = arr.join('/')
    
    nav.setAttribute('href', newlink)
  };

  // decrementButton.addEventListener('click', () => {
  //   let currentValue = parseInt(quantityInput.value);
  //   if (currentValue > 1) {
  //     quantityInput.value = currentValue - 1;
  //     updateCounters();
  //   }
  // });

  // incrementButton.addEventListener('click', () => {
  //   let currentValue = parseInt(quantityInput.value);
  //   quantityInput.value = currentValue + 1;
  //   updateCounters();
  // });

  // Initialize counters on page load
  updateCounters();


  // Reviews Pagination Logic
  const reviewsData = productReviews || [];
  const reviewsPerPage = 3;
  let currentPage = 1;
  const totalPages = Math.ceil(reviewsData.length / reviewsPerPage);
  let sortBy = 'newest'; // 🆕 Default sort
  const reviewsList = document.getElementById('reviews-list');
  const paginationNumbers = document.getElementById('pagination-numbers');
  const prevPageBtn = document.getElementById('prevPage');
  const nextPageBtn = document.getElementById('nextPage');
  const sortSelect = document.getElementById('sortReviews');
  const sortReviewsData = (data, sortType) => {
      switch(sortType) {
          case 'newest':
              return [...data].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
          case 'oldest':
              return [...data].sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
          case 'highest':
              return [...data].sort((a, b) => b.rating - a.rating);
          case 'lowest':
              return [...data].sort((a, b) => a.rating - b.rating);
          case 'helpful':
              // 🆕 Simulate helpful (you can add helpful_count column later)
              return [...data].sort((a, b) => (b.rating * 10 + Math.random() * 100) - (a.rating * 10 + Math.random() * 100));
          default:
              return data;
      }
  };

  const renderReviews = () => {
      const sortedReviews = sortReviewsData(reviewsData, sortBy);
      reviewsList.innerHTML = '';
      const startIndex = (currentPage - 1) * reviewsPerPage;
      const endIndex = startIndex + reviewsPerPage;
      const reviewsToDisplay = sortedReviews.slice(startIndex, endIndex);

      reviewsToDisplay.forEach(review => {
          const reviewElement = document.createElement('div');
          reviewElement.className = 'border-b border-gray-300 pb-5 mb-5';
          reviewElement.innerHTML = `
              <div class="flex items-center mb-2">
                  <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center mr-3">
                      <span class="text-rose-600 font-bold text-sm">${review.name.charAt(0)}</span>
                  </div>
                  <div>
                      <span class="font-semibold">${review.name}</span>
                      <span class="text-gray-500 text-sm ml-2">${new Date(review.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}</span>
                  </div>
              </div>
              <h3 class="text-xl font-bold mb-2">${review.title}</h3>
              <p class="text-gray-700 italic mb-3">"${review.review}"</p>
              ${review.image ? `<img src="/uploads/reviews/${review.image}" alt="Review image" class="w-20 h-20 object-cover rounded mb-3">` : ''}
              <div class="flex text-yellow-400 text-2xl">
                  ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
              </div>
          `;
          reviewsList.appendChild(reviewElement);
      });
  };

  // 🆕 SORTING EVENT LISTENER
  if (sortSelect) {
      sortSelect.addEventListener('change', (e) => {
          sortBy = e.target.value;
          currentPage = 1; // Reset to first page
          renderReviews();
          renderPaginationNumbers();
          updatePaginationButtons();
      });
  }

  // 🆕 UPDATED PAGINATION
  const updatePagination = () => {
      const sortedReviews = sortReviewsData(reviewsData, sortBy);
      const totalPages = Math.ceil(sortedReviews.length / reviewsPerPage);
      
      paginationNumbers.innerHTML = '';
      for (let i = 1; i <= totalPages; i++) {
          const pageButton = document.createElement('button');
          pageButton.textContent = i;
          pageButton.className = `pagination-button px-3 py-1 rounded-full font-medium border border-transparent hover:border-pink-800 transition duration-300 ${i === currentPage ? 'bg-pink-800 text-white' : ''}`;
          pageButton.addEventListener('click', () => {
              currentPage = i;
              renderReviews();
              updatePaginationButtons();
          });
          paginationNumbers.appendChild(pageButton);
      }
      
      prevPageBtn.disabled = currentPage === 1;
      nextPageBtn.disabled = currentPage === totalPages;
      
      document.querySelectorAll('#pagination-numbers .pagination-button').forEach(btn => {
          btn.classList.toggle('bg-pink-800', parseInt(btn.textContent) === currentPage);
          btn.classList.toggle('text-white', parseInt(btn.textContent) === currentPage);
      });
  };

  const updatePaginationButtons = () => {
      const sortedReviews = sortReviewsData(reviewsData, sortBy);
      const totalPages = Math.ceil(sortedReviews.length / reviewsPerPage);
      prevPageBtn.disabled = currentPage === 1;
      nextPageBtn.disabled = currentPage === totalPages;
  };

  // 🆕 EVENT LISTENERS
  if (prevPageBtn) {
    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderReviews();
            updatePaginationButtons();
        }
    });
  }
  if (nextPageBtn) {
    nextPageBtn.addEventListener('click', () => {
        const sortedReviews = sortReviewsData(reviewsData, sortBy);
        const totalPages = Math.ceil(sortedReviews.length / reviewsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderReviews();
            updatePaginationButtons();
        }
    });
  }
  // 🆕 INITIALIZE
  if (reviewsList) {
      renderReviews();
      updatePagination();
  }
  // Variables
  const slides = document.querySelectorAll('.testimonial-slide');
  const clientNavs = document.querySelectorAll('.client-nav');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  let currentIndex = 0;
  const totalSlides = slides.length;

  // Initialize
  updateSlide();

  // Event listeners
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateSlide();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateSlide();
    });
  }

  if (clientNavs) {
    clientNavs.forEach(nav => {
      nav.addEventListener('click', () => {
        currentIndex = parseInt(nav.getAttribute('data-index-client'));
        updateSlide();
      });
    });
  }
  // Functions
  function updateSlide() {
    // Update slides
    if (!slides || slides.length === 0) return;
    slides.forEach(slide => {
      slide.classList.remove('active');
    });
    slides[currentIndex].classList.add('active');

    // Update client navs
    if (!clientNavs || clientNavs.length === 0) return;
    clientNavs.forEach(nav => {
      console.log(nav.getAttribute('data-index-client'), currentIndex);
      const navIndex = parseInt(nav.getAttribute('data-index-client'));
      if (navIndex === currentIndex) {
        nav.classList.remove('opacity-50');
        nav.querySelector('.client-nav-c').classList.remove('border-gray-300');
        nav.querySelector('.client-nav-c').classList.add('border-rose-500');
        nav.querySelector('p').classList.remove('text-gray-500');
        nav.querySelector('p').classList.add('text-gray-700');
      } else {
        nav.classList.add('opacity-50');
        nav.querySelector('.client-nav-c').classList.remove('border-rose-500');
        nav.querySelector('.client-nav-c').classList.add('border-gray-300');
        nav.querySelector('p').classList.remove('text-gray-700');
        nav.querySelector('p').classList.add('text-gray-500');
      }
    });
  }

  // Auto-rotate slides every 5 seconds
  setInterval(() => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide();
  }, 5000);


    const sizeSelect = document.getElementById('size');
    const priceDisplay = document.getElementById('price-display');
    const currentPrice = document.getElementById('current-price');
    const originalPrice = document.getElementById('original-price');
    // const quantityInput = document.getElementById('quantity');
    const buyNowLink = document.getElementById('buy-now-link');
    // const buyNowCounter = document.getElementById('buyNowCounter');
    const addToCartButton = document.querySelector('.cart-item-btn');
    // const addToCartCounter = document.getElementById('addToCartCounter');
    // const incrementButton = document.getElementById('increment');
    // const decrementButton = document.getElementById('decrement');
    const currency = appCurrency;

    let selectedSizeId = sizeSelect ? sizeSelect.value : '0';
    let maxQuantity = sizeSelect ? sizeSelect.options[sizeSelect.selectedIndex].dataset.quantity : quantityInput.dataset.maxQuantity;

    // Update price display based on selected size
    function updatePriceDisplay() {
        const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price);
        maxQuantity = parseInt(selectedOption.dataset.quantity);
        selectedSizeId = selectedOption.value;

        // Update price display (assuming getPrice and getOriginalPrice handle discounts)
        const originalPriceValue = price; // Adjust if discounts are size-specific
        const currentPriceValue = price; // Adjust if discounts are size-specific

        if (currentPriceValue !== originalPriceValue) {
            priceDisplay.innerHTML = `
                <span class="text-red-600 mr-2" id="current-price">${currency} ${currentPriceValue.toFixed(2)}</span>
                <span class="text-gray-500 line-through text-xl sm:text-2xl" id="original-price">${currency} ${originalPriceValue.toFixed(2)}</span>
            `;
        } else {
            priceDisplay.innerHTML = `<span id="current-price">${currency} ${currentPriceValue.toFixed(2)}</span>`;
        }

        // Update Buy Now link with selected size
      buyNowLink.href = checkoutRoute
        .replace('/1/', `/${quantityInput.value}/`) // update quantity dynamically if needed
        .replace(/\/\d+$/, `/${selectedSizeId}`); // update size_id dynamically

        // Update Add to Cart button data
        addToCartButton.dataset.productPrice = currentPriceValue.toFixed(2);
        addToCartButton.dataset.sizeId = selectedSizeId;
    }

    // Handle size selection
    if (sizeSelect) {
        sizeSelect.addEventListener('change', updatePriceDisplay);
    }

    // Initialize price display
    // updatePriceDisplay();
});
  console.log("DOMContentLoaded - productDetail.js");


document.addEventListener("DOMContentLoaded", () => {
  // --- Tabs ---
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.getAttribute("data-tab");
      // hide all
      tabContents.forEach((c) => c.classList.add("hidden"));
      tabButtons.forEach((b) =>
        b.classList.remove("bg-[#ef380d]", "text-white")
      );
      // show target
      document.getElementById(`${target}-content`)?.classList.remove("hidden");
      btn.classList.add("bg-[#ef380d]", "text-white");
      if (target === "reviews") window.scrollTo({ top: btn.offsetTop, behavior: "smooth" });
    });
  });

  // --- Thumbnails ---
  const mainImg = document.querySelector(".lg\\:col-span-6 img");
  document.querySelectorAll(".thumbnail-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const src = btn.getAttribute("data-img");
      if (mainImg && src) mainImg.src = src;
    });
  });

  // --- Sizes ---
  const sizeButtons = document.querySelectorAll(".size-option");
  const hiddenSizeInput = document.getElementById("selected-size-id");
  sizeButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      sizeButtons.forEach((b) =>
        b.classList.remove("bg-[#ef380d]", "text-white", "border-[#ef380d]")
      );
      btn.classList.add("bg-[#ef380d]", "text-white", "border-[#ef380d]");
      hiddenSizeInput.value = btn.dataset.sizeId;
    });
  });

  // --- Quantity ---
  const qtyInput = document.getElementById("product-qty");
  document.getElementById("qty-increment")?.addEventListener("click", () => {
    qtyInput.value = parseInt(qtyInput.value || "1") + 1;
  });
  document.getElementById("qty-decrement")?.addEventListener("click", () => {
    const val = parseInt(qtyInput.value || "1");
    if (val > 1) qtyInput.value = val - 1;
  });

  // --- Featured Review Carousel ---
  const slides = document.querySelectorAll(".testimonial-slide");
  const clientNavs = document.querySelectorAll(".client-nav");
  let activeIndex = 0;

  function showSlide(index) {
    slides.forEach((s, i) => {
      if (i === index) s.classList.remove("hidden");
      else s.classList.add("hidden");
    });
    clientNavs.forEach((b, i) => {
      b.classList.toggle("border-[#ef380d]", i === index);
      b.classList.toggle("bg-[#ef380d]/5", i === index);
    });
    activeIndex = index;
  }

  clientNavs.forEach((btn, i) => {
    btn.addEventListener("click", () => showSlide(i));
  });

  // auto cycle every 8s if >1 slide
  if (slides.length > 1) {
    setInterval(() => {
      activeIndex = (activeIndex + 1) % slides.length;
      showSlide(activeIndex);
    }, 8000);
  }

  // --- "View All Reviews" link ---
  const reviewsTab = document.querySelector("[data-tab='reviews']");
  const viewAllReviewsLink = document.getElementById("view-all-reviews-link");
  viewAllReviewsLink?.addEventListener("click", (e) => {
    e.preventDefault();
    reviewsTab?.click();
    const reviewsSection = document.getElementById("reviews-content");
    if (reviewsSection)
      reviewsSection.scrollIntoView({ behavior: "smooth", block: "start" });
  });

  // --- "Leave A Review" button scroll ---
  const showReviewFormBtn = document.getElementById("show-review-form-btn");
  showReviewFormBtn?.addEventListener("click", () => {
    reviewsTab?.click();
    const form = document.getElementById("review-form");
    if (form)
      form.scrollIntoView({ behavior: "smooth", block: "center" });
  });

  // initial highlight for first tab
  document.getElementById("description-tab")?.click();
});
