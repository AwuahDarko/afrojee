
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

