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


});
