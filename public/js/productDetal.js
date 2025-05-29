
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