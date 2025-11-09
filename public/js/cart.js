document.addEventListener('DOMContentLoaded', () => {
    console.log('Cart system initialized');

    const cartSidebar = document.getElementById('cart-sidebar');
    const cartSidebarOverlay = document.getElementById('cart-sidebar-overlay');
    const openCartSidebarBtn = document.getElementById('open-cart-sidebar');
    const closeCartSidebarBtn = document.getElementById('close-cart-sidebar');
    const cartItemsList = document.getElementById('cart-items-list');
    const cartTotalElement = document.getElementById('cart-total');
    const cartCountElement = document.getElementById('cart-count');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const proceedToCheckoutBtn = document.getElementById('proceed-to-checkout-btn');
    const checkoutForm = document.getElementById('checkout-form');
    const cartDataInput = document.getElementById('cart-data-input');

    // --- Helpers ---
    const getCart = () => JSON.parse(localStorage.getItem('shoppingCart')) || [];
    const saveCart = (cart) => localStorage.setItem('shoppingCart', JSON.stringify(cart));

    // --- Cart Core Functions ---
    const addItemToCart = (productId, name, price, image, quantity = 1, sizeId = 0, sizeName = '') => {
        let cart = getCart();

        // Check if same product & same size already exist
        const existingItem = cart.find(item => item.productId === productId && item.sizeId === sizeId);

        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({ productId, name, price, image, quantity, sizeId, sizeName });
        }

        saveCart(cart);
        renderCart();
        updateCartCount();
        openCartSidebar();
    };

    const removeItemFromCart = (productId, sizeId) => {
        let cart = getCart();
        cart = cart.filter(item => !(item.productId === productId && item.sizeId === sizeId));
        saveCart(cart);
        renderCart();
        updateCartCount();
    };

    const changeItemQuantity = (productId, sizeId, newQuantity) => {
        let cart = getCart();
        cart.forEach(item => {
            if (item.productId === productId && item.sizeId === sizeId) {
                item.quantity = newQuantity;
            }
        });
        cart = cart.filter(item => item.quantity > 0);
        saveCart(cart);
        renderCart();
        updateCartCount();
    };

    // --- Render Cart ---
    const renderCart = () => {
        const cart = getCart();
        cartItemsList.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            emptyCartMessage.classList.remove('hidden');
        } else {
            emptyCartMessage.classList.add('hidden');

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'flex items-center gap-4 p-2 border rounded-lg shadow-sm bg-gray-50';
                cartItemElement.innerHTML = `
                    <img ddddddddddd src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-md">
                    <div class="flex-grow">
                        <h3 class="font-semibold text-gray-800">${item.name}</h3>
                        ${item.sizeName ? `<p class="text-sm text-gray-500">Size: ${item.sizeName}</p>` : ''}
                        <p class="text-pink-800 font-bold">${appCurrency || '€'} ${parseFloat(item.price).toFixed(2)}</p>
                        <div class="flex items-center mt-1">
                            <button class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}" data-size-id="${item.sizeId}">-</button>
                            <span class="quantity-display mx-2 font-medium">${item.quantity}</span>
                            <button class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}" data-size-id="${item.sizeId}">+</button>
                        </div>
                    </div>
                    <button class="delete-item text-gray-500 hover:text-red-600 transition duration-200" data-product-id="${item.productId}" data-size-id="${item.sizeId}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                `;
                cartItemsList.appendChild(cartItemElement);
            });
        }

        cartTotalElement.textContent = ` ${total.toFixed(2)} ${appCurrency || '€'}`;
    };

    const updateCartCount = () => {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0) || 0;
        if(!cartCountElement) return;
        cartCountElement.textContent = totalItems;
        cartCountElement.classList.toggle('hidden', totalItems === 0);
    };

    // --- Sidebar Functions ---
    const openCartSidebar = () => {
        cartSidebar.classList.remove('translate-x-full');
        cartSidebar.classList.add('translate-x-0');
        cartSidebarOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeCartSidebar = () => {
        cartSidebar.classList.add('translate-x-full');
        cartSidebarOverlay.classList.add('hidden');
        document.body.style.overflow = '';
    };

    // --- Event Listeners ---
    document.querySelectorAll('.cart-item-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            console.log('button ---------->', button)
            const productId = button.dataset.productId;
            const productName = button.dataset.productName;
            const productPrice = parseFloat(button.dataset.productPrice.replace(',', ''));
            const productImage = button.dataset.productImage;

            const sizeId = button.dataset.sizeId ? parseInt(button.dataset.sizeId) : 0;
            const sizeName = button.dataset.sizeName || '';

            let quantity = 1;
            const quantityInput = document.getElementById('quantity');
            if (quantityInput && event.currentTarget.id === 'add-to-cart-button') {
                quantity = parseInt(quantityInput.value);
            }

            addItemToCart(productId, productName, productPrice, productImage, quantity, sizeId, sizeName);
        });
    });

    // Handle quantity changes and deletes in cart sidebar
    cartItemsList.addEventListener('click', (event) => {
        const target = event.target;
        const productId = target.dataset.productId;
        const sizeId = parseInt(target.dataset.sizeId);

        if (target.classList.contains('quantity-minus')) {
            const cart = getCart();
            const item = cart.find(i => i.productId === productId && i.sizeId === sizeId);
            if (item && item.quantity > 1) {
                changeItemQuantity(productId, sizeId, item.quantity - 1);
            } else {
                removeItemFromCart(productId, sizeId);
            }
        }

        if (target.classList.contains('quantity-plus')) {
            const cart = getCart();
            const item = cart.find(i => i.productId === productId && i.sizeId === sizeId);
            if (item) {
                changeItemQuantity(productId, sizeId, item.quantity + 1);
            }
        }

        if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
            const button = target.closest('.delete-item');
            removeItemFromCart(button.dataset.productId, parseInt(button.dataset.sizeId));
        }
    });

    // Proceed to checkout
    proceedToCheckoutBtn.addEventListener('click', () => {
        const cart = getCart();
        if (cart.length > 0) {
            cartDataInput.value = JSON.stringify(cart);
            checkoutForm.submit();
            closeCartSidebar();
        } else {
            alert('Your cart is empty. Please add items before proceeding to checkout.');
        }
    });

    // Sidebar toggles
    if(openCartSidebarBtn){
        openCartSidebarBtn.addEventListener('click', openCartSidebar);
    }
    if(closeCartSidebarBtn){
        closeCartSidebarBtn.addEventListener('click', closeCartSidebar);
    }
    if(cartSidebarOverlay){
        cartSidebarOverlay.addEventListener('click', closeCartSidebar);
    }

    // Init
    renderCart();
    updateCartCount();
});
