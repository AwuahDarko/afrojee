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
  const faqButtons = document.querySelectorAll('.faq-button');

  // Open the first FAQ by default
  if (faqButtons.length > 0) {
    const firstButton = faqButtons[0];
    const firstContent = firstButton.nextElementSibling;
    firstButton.setAttribute('aria-expanded', 'true');
    firstContent.classList.add('active');
    firstContent.classList.remove('hidden');
  }

  faqButtons.forEach(button => {
    button.addEventListener('click', () => {
      const isExpanded = button.getAttribute('aria-expanded') === 'true';
      const content = button.nextElementSibling;

      // Close all FAQ items
      faqButtons.forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
        const otherContent = btn.nextElementSibling;
        otherContent.classList.add('hidden');
        otherContent.classList.remove('active');
      });

      // If the clicked item was collapsed, open it
      if (!isExpanded) {
        button.setAttribute('aria-expanded', 'true');
        content.classList.remove('hidden');
        content.classList.add('active');
      }
    });
  });
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
});