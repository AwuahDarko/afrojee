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
    buyNowCounter.textContent = currentValue;
    addToCartCounter.textContent = currentValue;
    const nav = document.getElementById('buy-now-link')
    const link = nav.getAttribute('href')
    const arr = link.split('/')
    arr[arr.length - 2] = currentValue  // Adjust for quantity in URL
    const newlink = arr.join('/')
    
    nav.setAttribute('href', newlink)
  };

  decrementButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
      updateCounters();
    }
  });

  incrementButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
    updateCounters();
  });

  // Initialize counters on page load
  updateCounters();


  // Reviews Pagination Logic
  const reviews = [
    {
      name: "Maya, 23",
      title: "Thee growth hair & scalp oil",
      text: "This body butter is a game-changer! My skin feels so soft and hydrated, and the scent is absolutely divine. A little goes a long way, so it's great value for money. Highly recommend!",
      rating: 4, // out of 5
      avatar: "https://placehold.co/30x30/99395C/FFFFFF?text=M"
    },
    {
      name: "John D., 30",
      title: "Amazing Product!",
      text: "I've tried many body butters, but this one is by far the best. It absorbs quickly and leaves my skin feeling incredibly smooth. The scent is subtle and pleasant. Will definitely repurchase!",
      rating: 5,
      avatar: "https://placehold.co/30x30/99395C/FFFFFF?text=J"
    },
    {
      name: "Sarah L., 28",
      title: "Great for Dry Skin",
      text: "My skin gets very dry, especially in winter. This body butter has been a lifesaver. It provides deep hydration without feeling greasy. Highly recommend for anyone with dry or sensitive skin.",
      rating: 5,
      avatar: "https://placehold.co/30x30/99395C/FFFFFF?text=S"
    },
    {
      name: "Emily R., 35",
      title: "Lovely Scent",
      text: "The scent is absolutely lovely and not overpowering. It makes my skin feel so soft and moisturized all day. I use it daily after my shower. Very happy with this purchase!",
      rating: 4,
      avatar: "https://placehold.co/30x30/99395C/FFFFFF?text=E"
    },
    {
      name: "David K., 42",
      title: "Good Value",
      text: "A little goes a long way with this body butter. It's very effective and lasts a long time, making it great value for money. My skin feels healthier since I started using it.",
      rating: 4,
      avatar: "https://placehold.co/30x30/99395C/FFFFFF?text=D"
    }
  ];

  const reviewsPerPage = 3; // Display one review per page
  let currentPage = 1;
  const totalPages = Math.ceil(reviews.length / reviewsPerPage);

  const reviewsList = document.getElementById('reviews-list');
  const paginationNumbers = document.getElementById('pagination-numbers');
  const prevPageBtn = document.getElementById('prevPage');
  const nextPageBtn = document.getElementById('nextPage');

  // Function to render reviews for the current page
  const renderReviews = () => {
    reviewsList.innerHTML = ''; // Clear existing reviews
    const startIndex = (currentPage - 1) * reviewsPerPage;
    const endIndex = startIndex + reviewsPerPage;
    const reviewsToDisplay = reviews.slice(startIndex, endIndex);

    reviewsToDisplay.forEach(review => {
      const reviewElement = document.createElement('div');
      reviewElement.className = 'border-b border-gray-300 pb-5 mb-5'; // Added mb-5 for spacing between reviews
      reviewElement.innerHTML = `
                    <div class="flex items-center mb-2">
                        <img src="${review.avatar}" alt="User Avatar" class="rounded-full mr-2"/>
                        <span class="font-semibold">${review.name}</span>
                    </div>
                    <h2 class="text-xl font-bold mb-4">${review.title}</h2>
                    <p class="text-gray-700 italic mb-2">"${review.text}"</p>
                    <div class="flex text-yellow-400 text-3xl">
                        <span>${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</span>
                    </div>
                `;
      reviewsList.appendChild(reviewElement);
    });
  };


  // Function to render pagination numbers
  const renderPaginationNumbers = () => {
    paginationNumbers.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement('button');
      pageButton.textContent = i;
      pageButton.className = `pagination-button px-3 py-1 rounded-full font-medium border border-transparent hover:border-pink-800 transition duration-300 ${i === currentPage ? 'active' : ''}`;
      pageButton.addEventListener('click', () => {
        currentPage = i;
        renderReviews();
        updatePaginationButtons();
      });
      paginationNumbers.appendChild(pageButton);
    }
  };

  // Function to update pagination button states (disabled/active)
  const updatePaginationButtons = () => {
    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = currentPage === totalPages;

    // Update active class for page numbers
    document.querySelectorAll('#pagination-numbers .pagination-button').forEach(btn => {
      if (parseInt(btn.textContent) === currentPage) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });
  };

  // Event Listeners for Previous/Next buttons
  prevPageBtn.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      renderReviews();
      updatePaginationButtons();
    }
  });

  nextPageBtn.addEventListener('click', () => {
    if (currentPage < totalPages) {
      currentPage++;
      renderReviews();
      updatePaginationButtons();
    }
  });

  // Initial render
  renderReviews();
  renderPaginationNumbers();
  updatePaginationButtons();

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
  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlide();
  });

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide();
  });

  clientNavs.forEach(nav => {
    nav.addEventListener('click', () => {
      currentIndex = parseInt(nav.getAttribute('data-index-client'));
      updateSlide();
    });
  });

  // Functions
  function updateSlide() {
    // Update slides
    slides.forEach(slide => {
      slide.classList.remove('active');
    });
    slides[currentIndex].classList.add('active');

    // Update client navs
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

    // // Quantity controls
    // incrementButton.addEventListener('click', function () {
    //     let quantity = parseInt(quantityInput.value);
    //     if (quantity < maxQuantity) {
    //         quantityInput.value = quantity + 1;
    //         buyNowCounter.textContent = quantityInput.value;
    //         addToCartCounter.textContent = quantityInput.value;
    //         buyNowLink.href = buyNowLink.href.replace(/quantity=\d+/, `quantity=${quantityInput.value}`);
    //     }
    // });

    // decrementButton.addEventListener('click', function () {
    //     let quantity = parseInt(quantityInput.value);
    //     if (quantity > 1) {
    //         quantityInput.value = quantity - 1;
    //         buyNowCounter.textContent = quantityInput.value;
    //         addToCartCounter.textContent = quantityInput.value;
    //         buyNowLink.href = buyNowLink.href.replace(/quantity=\d+/, `quantity=${quantityInput.value}`);
    //     }
    // });

    // // Tab functionality (unchanged)
    // const tabButtons = document.querySelectorAll('.tab-button');
    // const tabContents = document.querySelectorAll('.tab-content');

    // tabButtons.forEach(button => {
    //     button.addEventListener('click', () => {
    //         tabButtons.forEach(btn => btn.classList.remove('active'));
    //         tabContents.forEach(content => content.classList.add('hidden'));

    //         button.classList.add('active');
    //         const tabId = button.dataset.tab;
    //         document.getElementById(`${tabId}-content`).classList.remove('hidden');
    //     });
    // });

    
    // Add to Cart functionality (UNCOMMENTED and UPDATED: Include size_id in cart item)
    // addToCartButton.addEventListener('click', function () {
    //     const product = {
    //         productId: this.dataset.productId,
    //         name: this.dataset.productName,
    //         price: parseFloat(this.dataset.productPrice),
    //         image: this.dataset.productImage,
    //         quantity: parseInt(quantityInput.value),
    //         sizeId: this.dataset.sizeId  // NEW: Include sizeId
    //     };

    //     // Example: Store in localStorage or send to server
    //     let cart = JSON.parse(localStorage.getItem('cart')) || [];
    //     const existingItem = cart.find(item => item.productId === product.productId && item.sizeId === product.sizeId);
    //     if (existingItem) {
    //         existingItem.quantity += product.quantity;
    //     } else {
    //         cart.push(product);
    //     }
    //     localStorage.setItem('cart', JSON.stringify(cart));
    //     alert('Product added to cart!');
    // });

    // Initialize price display
    updatePriceDisplay();
});