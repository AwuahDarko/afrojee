// Implementation of the makeActive function
const makeActive = (card) => {
  // First, set all cards to inactive state
  cards.forEach(c => {
    c.classList.remove('active');
    c.classList.add('inactive');
    c.classList.remove('flex-[3]');
    c.classList.add('flex-1');
    c.classList.add('max-w-[400px]');
    c.classList.remove('max-w-[500px]');

    // 🔁 Set default image on all other cards
    const img = c.querySelector('.product-image');
    if (img) {
      const defaultSrc = c.getAttribute('data-img-default');
      if (defaultSrc) img.src = defaultSrc;
    }
  });

  // Then, set the selected card to active state
  card.classList.add('active');
  card.classList.remove('inactive');
  card.classList.remove('flex-1');
  card.classList.add('flex-[3]');
  card.classList.remove('max-w-[400px]');
  card.classList.add('max-w-[600px]');

  // ✅ Change image to active
  const activeImg = card.querySelector('.product-image');
  if (activeImg) {
    const activeSrc = card.getAttribute('data-img-active');
    if (activeSrc) activeImg.src = activeSrc;
  }
};

// Update the event listeners to use the function
const cards = document.querySelectorAll('.product-card');

// Set first card as default active when the page loads
window.addEventListener('DOMContentLoaded', () => {
  makeActive(cards[0]);
});

// Add event listeners to each card
cards.forEach(card => {
  card.addEventListener('mouseenter', () => {
    makeActive(card);
  });
});

document.addEventListener('DOMContentLoaded', function () {

});

const swiper = new Swiper('.hero-swiper', {
  loop: true,
  effect: 'fade',
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  speed: 1000
});

document.addEventListener("DOMContentLoaded", () => {

});


document.addEventListener('DOMContentLoaded', () => {
  gsap.from(".hero-label", {
    opacity: 0,
    y: -30,
    duration: 1,
    delay: 0.3
  });

  gsap.from(".hero-heading span", {
    opacity: 0,
    y: 50,
    duration: 1,
    stagger: 0.2,
    delay: 0.6
  });

  gsap.from(".hero-cta", {
    opacity: 0,
    y: 30,
    duration: 1,
    delay: 1.2
  });

  gsap.from(".hero-testimonial", {
    opacity: 0,
    x: 50,
    duration: 1,
    delay: 1.5
  });


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

  // Tab Switching Logic
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Remove active class from all buttons and hide all content
      tabButtons.forEach(btn => btn.classList.remove('active'));
      tabContents.forEach(content => content.classList.add('hidden'));

      // Add active class to the clicked button
      button.classList.add('active');

      // Show the corresponding content
      const targetTab = button.dataset.tab;
      document.getElementById(`${targetTab}-content`).classList.remove('hidden');
    });
  });
  // // Tab Switching Logic
  // const tabButtons = document.querySelectorAll('.tab-button');
  // const tabContents = document.querySelectorAll('.tab-content');

  // tabButtons.forEach(button => {
  //   button.addEventListener('click', () => {
  //     // Remove active class from all buttons and hide all content
  //     tabButtons.forEach(btn => btn.classList.remove('active'));
  //     tabContents.forEach(content => content.classList.add('hidden'));

  //     // Add active class to the clicked button
  //     button.classList.add('active');

  //     // Show the corresponding content
  //     const targetTab = button.dataset.tab;
  //     document.getElementById(`${targetTab}-content`).classList.remove('hidden');
  //   });
  // });





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


  const cartItemsContainer = document.getElementById('cart-items-container');
  const cartSubtotalSpan = document.getElementById('cart-subtotal');
  const cartItemCountSpan = document.getElementById('cart-item-count');

  // Function to update the cart total and item count
  const updateCartSummary = () => {
    let total = 0;
    let itemCount = 0;

    document.querySelectorAll('.cart-item').forEach(itemElement => {
      // Check if the item is visible (not deleted)
      if (itemElement.style.display !== 'none') {
        const price = parseFloat(itemElement.dataset.price);
        const quantity = parseInt(itemElement.querySelector('.quantity-input').value);
        total += price * quantity;
        itemCount += quantity;
      }
    });

    cartSubtotalSpan.textContent = total.toFixed(2);
    cartItemCountSpan.textContent = itemCount;
  };

  // Event delegation for quantity and delete buttons
  cartItemsContainer.addEventListener('click', (event) => {
    const target = event.target;

    // Handle quantity minus button
    if (target.classList.contains('quantity-minus')) {
      const quantityInput = target.nextElementSibling;
      let currentValue = parseInt(quantityInput.value);
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateCartSummary();
      }
    }

    // Handle quantity plus button
    if (target.classList.contains('quantity-plus')) {
      const quantityInput = target.previousElementSibling;
      let currentValue = parseInt(quantityInput.value);
      quantityInput.value = currentValue + 1;
      updateCartSummary();
    }

    // Handle delete item button
    if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
      const itemToRemove = target.closest('.cart-item');
      if (itemToRemove) {
        // For a real application, you would remove this from a data structure
        // and then re-render or truly remove the element.
        // For this example, we'll just hide it.
        itemToRemove.style.display = 'none';
        updateCartSummary();
      }
    }
  });

  // Initial calculation on page load
  updateCartSummary();


  const filterButtons = document.querySelectorAll('.filter-btn');
  const products = document.querySelectorAll('.product-card');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');

      // Update active button style
      filterButtons.forEach(btn => btn.classList.remove('active-filter'));
      button.classList.add('active-filter');

      // Show/hide products
      products.forEach(product => {
        const category = product.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
    });
  });

});
