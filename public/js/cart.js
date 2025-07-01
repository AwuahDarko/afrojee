
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
if (cartItemsContainer) {
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
}


document.addEventListener('DOMContentLoaded', () => {
  console.log('------------------------------')
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartSidebarOverlay = document.getElementById('cart-sidebar-overlay');
    const openCartSidebarBtn = document.getElementById('open-cart-sidebar');
    const closeCartSidebarBtn = document.getElementById('close-cart-sidebar');
    const cartItemsList = document.getElementById('cart-items-list');
    const cartTotalElement = document.getElementById('cart-total');
    const cartCountElement = document.getElementById('cart-count');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const proceedToCheckoutBtn = document.getElementById('proceed-to-checkout-btn'); // New
    const checkoutForm = document.getElementById('checkout-form'); // New
    const cartDataInput = document.getElementById('cart-data-input'); // New
    // --- Cart Management Functions ---

    // Load cart from localStorage
    const getCart = () => {
        const cart = localStorage.getItem('shoppingCart');
        return cart ? JSON.parse(cart) : [];
    };

    // Save cart to localStorage
    const saveCart = (cart) => {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    };

    // Add item to cart
    const addItemToCart = (productId, name, price, image, quantity = 1) => {
        let cart = getCart();
        let itemFound = false;

        cart.forEach(item => {
            if (item.productId === productId) {
                item.quantity += quantity;
                itemFound = true;
            }
        });

        if (!itemFound) {
            cart.push({ productId, name, price, image, quantity });
        }

        saveCart(cart);
        renderCart();
        updateCartCount();
        openCartSidebar(); // Open sidebar when item is added
    };

    // Remove item from cart
    const removeItemFromCart = (productId) => {
        let cart = getCart();
        cart = cart.filter(item => item.productId !== productId);
        saveCart(cart);
        renderCart();
        updateCartCount();
    };

    // Change item quantity
    const changeItemQuantity = (productId, newQuantity) => {
        let cart = getCart();
        cart.forEach(item => {
            if (item.productId === productId) {
                item.quantity = newQuantity;
            }
        });
        // Remove item if quantity drops to 0 or less
        cart = cart.filter(item => item.quantity > 0);
        saveCart(cart);
        renderCart();
        updateCartCount();
    };

    // Render cart items in the sidebar
    const renderCart = () => {
        const cart = getCart();
        cartItemsList.innerHTML = ''; // Clear current items
        let total = 0;

        if (cart.length === 0) {
            emptyCartMessage.classList.remove('hidden');
        } else {
            emptyCartMessage.classList.add('hidden');
            console.log('Rendering cart items:', cart);
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'flex items-center gap-4 p-2 border rounded-lg shadow-sm bg-gray-50';
                cartItemElement.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-md">
                    <div class="flex-grow">
                        <h3 class="font-semibold text-gray-800">${item.name}</h3>
                        <p class="text-pink-800 font-bold">€${parseFloat(item.price).toFixed(2)}</p>
                        <div class="flex items-center mt-1">
                            <button class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}">-</button>
                            <span class="quantity-display mx-2 font-medium">${item.quantity}</span>
                            <button class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}">+</button>
                        </div>
                    </div>
                    <button class="delete-item text-gray-500 hover:text-red-600 transition duration-200" data-product-id="${item.productId}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                `;
                cartItemsList.appendChild(cartItemElement);
            });
        }
        cartTotalElement.textContent = `€${total.toFixed(2)}`;
    };

    // Update cart count in navigation
    const updateCartCount = () => {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCountElement.textContent = totalItems;
        if (totalItems > 0) {
            cartCountElement.classList.remove('hidden');
        } else {
            cartCountElement.classList.add('hidden');
        }
    };

    // --- Sidebar Toggle Functions ---

    const openCartSidebar = () => {
        cartSidebar.classList.remove('translate-x-full');
        cartSidebar.classList.add('translate-x-0');
        cartSidebarOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when sidebar is open
    };

    const closeCartSidebar = () => {
        cartSidebar.classList.add('translate-x-full');
        cartSidebar.classList.remove('translate-x-0');
        cartSidebarOverlay.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    };

    // --- Event Listeners ---

    // Listen for clicks on "Add to Cart" buttons
    document.querySelectorAll('.cart-item-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            const productId = button.dataset.productId;
            const productName = button.dataset.productName;
            const productPrice = button.dataset.productPrice.replace(',', '');
            const productImage = button.dataset.productImage;
            console.log(`Adding to cart: ${productName}, dataset: `, button.dataset);

            // For product detail page, get quantity from input, otherwise default to 1
            let quantity = 1;
            const quantityInput = document.getElementById('quantity');
            if (quantityInput && event.currentTarget.id === 'add-to-cart-button') {
                quantity = parseInt(quantityInput.value);
            }

            console.log(`Adding to cart: ${productName}, Quantity: ${quantity}, Price: ${productPrice}`);
            addItemToCart(productId, productName, productPrice, productImage, quantity);
        });
    });

    // Event delegation for quantity and delete buttons within the cart sidebar
    cartItemsList.addEventListener('click', (event) => {
        const target = event.target;

        // Handle quantity minus button
        if (target.classList.contains('quantity-minus')) {
            const productId = target.dataset.productId;
            let cart = getCart();
            const item = cart.find(i => i.productId === productId);
            if (item && item.quantity > 1) {
                changeItemQuantity(productId, item.quantity - 1);
            } else if (item && item.quantity === 1) {
                removeItemFromCart(productId); // Remove if quantity becomes 0
            }
        }
        // Handle quantity plus button
        else if (target.classList.contains('quantity-plus')) {
            const productId = target.dataset.productId;
            let cart = getCart();
            const item = cart.find(i => i.productId === productId);
            if (item) {
                changeItemQuantity(productId, item.quantity + 1);
            }
        }
        // Handle delete item button
        else if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
            const button = target.closest('.delete-item');
            const productId = button.dataset.productId;
            removeItemFromCart(productId);
        }
    });

        // New: Handle "Proceed to Checkout" button click
    proceedToCheckoutBtn.addEventListener('click', () => {
        const cart = getCart();
        if (cart.length > 0) {
            cartDataInput.value = JSON.stringify(cart); // Put cart data into hidden input
            checkoutForm.submit(); // Submit the form
            closeCartSidebar(); // Close sidebar after submission
        } else {
            alert('Your cart is empty. Please add items before proceeding to checkout.');
        }
    });

    // Sidebar toggle event listeners
    openCartSidebarBtn.addEventListener('click', openCartSidebar);
    closeCartSidebarBtn.addEventListener('click', closeCartSidebar);
    cartSidebarOverlay.addEventListener('click', closeCartSidebar);

    // Initial render of cart when page loads
    renderCart();
    updateCartCount();
});