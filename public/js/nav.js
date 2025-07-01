window.addEventListener("DOMContentLoaded", () => {
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    mobileMenuButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    // Mobile products dropdown toggle
    const mobileProductsButton = document.getElementById("mobile-products-button");
    const mobileProductsDropdown = document.getElementById(
        "mobile-products-dropdown"
    );

    mobileProductsButton.addEventListener("click", () => {
        mobileProductsDropdown.classList.toggle("hidden");
    });



    const faqButtons = document.querySelectorAll('.faq-button');
    if (faqButtons) {
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

    }

});
