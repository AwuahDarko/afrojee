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
