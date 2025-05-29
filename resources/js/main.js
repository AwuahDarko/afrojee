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
  