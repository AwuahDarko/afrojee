// document.addEventListener('DOMContentLoaded', () => {
//     const fullCartItemsList = document.getElementById('full-cart-items-list');
//     const fullCartTotalElement = document.getElementById('full-cart-total');
//     const fullEmptyCartMessage = document.getElementById('full-empty-cart-message');

//     console.log('Cart page script loaded');

//     // Re-use the cart management functions from cart.js (or copy them here if cart.js isn't loaded on this page)
//     const getCart = () => {
//         const cart = localStorage.getItem('shoppingCart');
//         return cart ? JSON.parse(cart) : [];
//     };

//     const saveCart = (cart) => {
//         localStorage.setItem('shoppingCart', JSON.stringify(cart));
//     };

//     const removeItemFromCart = (productId) => {
//         let cart = getCart();
//         cart = cart.filter(item => item.productId !== productId);
//         saveCart(cart);
//         renderFullCart(); // Re-render this page's cart
//     };

//     const changeItemQuantity = (productId, newQuantity) => {
//         let cart = getCart();
//         cart.forEach(item => {
//             if (item.productId === productId) {
//                 item.quantity = newQuantity;
//             }
//         });
//         cart = cart.filter(item => item.quantity > 0);
//         saveCart(cart);
//         renderFullCart(); // Re-render this page's cart
//     };

//     // Render cart items on the full cart page
//     const renderFullCart = () => {
//         const cart = getCart();
//         fullCartItemsList.innerHTML = ''; // Clear current items
//         let total = 0;

//         if (cart.length === 0) {
//             fullEmptyCartMessage.classList.remove('hidden');
//         } else {
//             fullEmptyCartMessage.classList.add('hidden');
//             cart.forEach(item => {
//                 const itemTotal = item.price * item.quantity;
//                 total += itemTotal;

//                 const cartItemElement = document.createElement('div');
//                 cartItemElement.className = 'flex items-center gap-4 p-4 border-b last:border-b-0'; // Add border to items
//                 cartItemElement.innerHTML = `
//                     <img src="${item.image}" alt="${item.name}" class="w-24 h-24 object-cover rounded-md flex-shrink-0">
//                     <div class="flex-grow">
//                         <h3 class="font-semibold text-lg text-gray-800">${item.name}</h3>
//                         <p class="text-pink-800 font-bold text-xl">$${item.price.toFixed(2)}</p>
//                         <div class="flex items-center mt-2">
//                             <button class="quantity-minus px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}">-</button>
//                             <span class="quantity-display mx-4 text-lg font-medium">${item.quantity}</span>
//                             <button class="quantity-plus px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}">+</button>
//                         </div>
//                     </div>
//                     <div class="text-right flex flex-col items-end">
//                         <p class="text-xl font-bold text-gray-700 mb-2">$${itemTotal.toFixed(2)}</p>
//                         <button class="delete-item text-red-500 hover:text-red-700 transition duration-200" data-product-id="${item.productId}">
//                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
//                             <span class="ml-1 hidden md:inline">Remove</span>
//                         </button>
//                     </div>
//                 `;
//                 fullCartItemsList.appendChild(cartItemElement);
//             });
//         }
//         fullCartTotalElement.textContent = `$${total.toFixed(2)}`;
//     };

//     // Event delegation for quantity and delete buttons within the full cart page
//     fullCartItemsList.addEventListener('click', (event) => {
//         const target = event.target;

//         if (target.classList.contains('quantity-minus')) {
//             const productId = target.dataset.productId;
//             let cart = getCart();
//             const item = cart.find(i => i.productId === productId);
//             if (item && item.quantity > 1) {
//                 changeItemQuantity(productId, item.quantity - 1);
//             } else if (item && item.quantity === 1) {
//                 removeItemFromCart(productId);
//             }
//         }
//         else if (target.classList.contains('quantity-plus')) {
//             const productId = target.dataset.productId;
//             let cart = getCart();
//             const item = cart.find(i => i.productId === productId);
//             if (item) {
//                 changeItemQuantity(productId, item.quantity + 1);
//             }
//         }
//         else if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
//             const button = target.closest('.delete-item');
//             const productId = button.dataset.productId;
//             removeItemFromCart(productId);
//         }
//     });

//     // Initial render of cart when full cart page loads
//     renderFullCart();
// });

document.addEventListener('DOMContentLoaded', () => {
    const fullCartItemsList = document.getElementById('full-cart-items-list');
    const fullCartTotalElement = document.getElementById('full-cart-total');
    const fullEmptyCartMessage = document.getElementById('full-empty-cart-message');
    const cartItemCountElement = document.getElementById('cart-item-count'); // Element to display total items

    console.log('Cart page script loaded');

    // Re-use the cart management functions from cart.js (or copy them here if cart.js isn't loaded on this page)
    const getCart = () => {
        const cart = localStorage.getItem('shoppingCart');
        return cart ? JSON.parse(cart) : [];
    };

    const saveCart = (cart) => {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    };

    const removeItemFromCart = (productId) => {
        let cart = getCart();
        cart = cart.filter(item => item.productId !== productId);
        saveCart(cart);
        renderFullCart(); // Re-render this page's cart
        // Also update the sidebar cart count if cart.js is loaded
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
    };

    const changeItemQuantity = (productId, newQuantity) => {
        let cart = getCart();
        cart.forEach(item => {
            if (item.productId === productId) {
                item.quantity = newQuantity;
            }
        });
        cart = cart.filter(item => item.quantity > 0);
        saveCart(cart);
        renderFullCart(); // Re-render this page's cart
        // Also update the sidebar cart count if cart.js is loaded
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
    };

    // Render cart items on the full cart page
    const renderFullCart = () => {
        const cart = getCart();
        fullCartItemsList.innerHTML = ''; // Clear current items
        let total = 0;
        let totalItemsInCart = 0;

        if (cart.length === 0) {
            fullEmptyCartMessage.classList.remove('hidden');
            // Ensure cart item list area doesn't have default styling if empty
            fullCartItemsList.classList.remove('p-4', 'shadow-sm'); // Remove padding/shadow for empty state
        } else {
            fullEmptyCartMessage.classList.add('hidden');
            fullCartItemsList.classList.add('p-4', 'shadow-sm'); // Add padding/shadow when there are items
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                totalItemsInCart += item.quantity; // Sum up total items

                const cartItemElement = document.createElement('div');
                // Use responsive classes for better mobile layout, and a consistent border
                cartItemElement.className = 'flex flex-col sm:flex-row items-center p-4 sm:p-8 border-b border-gray-300 last:border-b-0';
                cartItemElement.innerHTML = `
                        <img src="${item.image}" alt="${item.name}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-lg mb-4 sm:mb-0 sm:mr-4 object-cover">
                        <div class="flex-grow w-full">
                            <h3 class="font-semibold text-lg sm:text-xl mb-2 sm:mb-0">${item.name}</h3>
                            <div class="flex flex-col sm:flex-row sm:items-center text-gray-600 mt-2 sm:mt-0">
                                <p class="text-pink-800 font-bold text-xl sm:text-2xl mr-4 sm:border-r-2 sm:pr-5 mb-2 sm:mb-0">
                                    <span class="inline-block mb-1 -mr-1">
                                        <svg width="12" height="15" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.72 16.915q-1.58 0-2.76-.58-1.16-.58-2.12-1.74l1.76-1.78q.62.82 1.4 1.32.8.48 1.86.48 1.08 0 1.7-.44t.62-1.24q0-.64-.36-1.04t-.96-.68a9.5 9.5 0 0 0-1.28-.5q-.7-.24-1.4-.54t-1.3-.74a3.5 3.5 0 0 1-.94-1.16q-.34-.72-.34-1.8 0-1.28.6-2.18.62-.9 1.68-1.38 1.08-.48 2.44-.48 1.32 0 2.44.54t1.86 1.4l-1.78 1.78q-.6-.68-1.24-1.04-.62-.36-1.34-.36-.98 0-1.52.38-.54.36-.54 1.12 0 .58.36.94t.94.62q.6.26 1.3.5.72.24 1.42.54.72.3 1.3.78.6.48.96 1.24.36.74.36 1.84 0 1.96-1.38 3.08-1.36 1.12-3.74 1.12m-.48-1.24h1.9v3.04h-1.9zm1.9-11.9h-1.9V.635h1.9z" fill="#99395C"/>
                                    </svg>
                                </span>
                                ${item.price.toFixed(2)}
                            </p>
                            <span class="mr-2 font-bold mb-2 sm:mb-0">Quantity</span>
                            <div class="flex items-center">
                                <button class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200" data-product-id="${item.productId}">-</button>
                                <input type="text" value="${item.quantity}" class="quantity-input w-10 text-center mx-2 border-none focus:outline-none bg-transparent font-bold" readonly data-product-id="${item.productId}" />
                                <button class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 mr-auto" data-product-id="${item.productId}">+</button>
                            </div>
                            <button class="delete-item px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 ml-auto mt-4 sm:mt-0" data-product-id="${item.productId}">
                                <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.702 5.43h14m-9 3v8m4-8v8m-4-15h4a1 1 0 0 1 1 1v3h-6v-3a1 1 0 0 1 1-1m-4 4h12v13a1 1 0 0 1-1 1h-10a1 1 0 0 1-1-1z" stroke="#C63636" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                fullCartItemsList.appendChild(cartItemElement);
            });
        }
        fullCartTotalElement.textContent = `${total.toFixed(2)}`;
        cartItemCountElement.textContent = totalItemsInCart; // Update total items count
    };

    // Event delegation for quantity and delete buttons within the full cart page
    fullCartItemsList.addEventListener('click', (event) => {
        const target = event.target;

        if (target.classList.contains('quantity-minus')) {
            const productId = target.dataset.productId;
            let cart = getCart();
            const item = cart.find(i => i.productId === productId);
            if (item && item.quantity > 1) {
                changeItemQuantity(productId, item.quantity - 1);
            } else if (item && item.quantity === 1) {
                removeItemFromCart(productId);
            }
        }
        else if (target.classList.contains('quantity-plus')) {
            const productId = target.dataset.productId;
            let cart = getCart();
            const item = cart.find(i => i.productId === productId);
            if (item) {
                changeItemQuantity(productId, item.quantity + 1);
            }
        }
        else if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
            const button = target.closest('.delete-item');
            const productId = button.dataset.productId;
            removeItemFromCart(productId);
        }
    });

    // Initial render of cart when full cart page loads
    renderFullCart();
});