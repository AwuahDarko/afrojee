window.addEventListener("DOMContentLoaded", () => {
    // Language Switcher Dropdown Toggle
    const languageSwitcherBtn = document.getElementById('language-switcher-btn');
    const languageDropdown = document.getElementById('language-dropdown');

    if (languageSwitcherBtn && languageDropdown) {
        languageSwitcherBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            languageDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!languageSwitcherBtn.contains(e.target) && !languageDropdown.contains(e.target)) {
                languageDropdown.classList.add('hidden');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        languageDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // Search Toggle and functionality
    const searchToggle = document.getElementById('search-toggle');
    const searchModal = document.getElementById('search-modal');

    if (searchToggle && searchModal) {
        const searchUrl = searchModal.dataset.searchUrl;
        const searchModalClose = document.getElementById('search-modal-close');
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');

        searchToggle.addEventListener('click', () => {
            searchModal.classList.toggle('hidden');
            searchModal.classList.toggle('show');
            document.querySelector('.modal-backdrop').classList.toggle('show');
            document.getElementById('search-input').focus();
        });

        if (searchModalClose) {
            searchModalClose.addEventListener('click', () => {
                searchModal.classList.add('hidden');
                searchModal.classList.remove('show');
                document.querySelector('.modal-backdrop').classList.remove('show');
            });
        }

        document.addEventListener('click', (e) => {
            if (!searchModal.contains(e.target) && !searchToggle.contains(e.target)) {
                searchModal.classList.add('hidden');
                searchModal.classList.remove('show');
                document.querySelector('.modal-backdrop').classList.remove('show');
            }
        });

        // Predictive Search
        if (searchInput && searchResults) {
            searchInput.addEventListener('input', debounce(async () => {
                const query = searchInput.value.trim();
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    searchResults.querySelector('.gsp-search-recommend-collection-list').innerHTML = '';
                    return;
                }

                try {
                    const response = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    displaySearchResults(data);
                } catch (error) {
                    console.error('Search error:', error);
                }
            }, 300));
        }

        // Debounce to limit API calls
        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Render Search Results
        function displaySearchResults(products) {
            const resultsContainer = searchResults.querySelector('.gsp-search-recommend-collection-list');
            resultsContainer.innerHTML = '';

            if (products.length === 0) {
                resultsContainer.innerHTML = '<p class="text-stone-500 p-4">No products found.</p>';
                searchResults.classList.remove('hidden');
                return;
            }

            products.forEach(product => {
                console.log('Product ---------->', product);
                resultsContainer.innerHTML += `
                <div class="gsp-search-recommend-collection-item">
                    <div class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-md">
                        <a href="/products/details/${product.slug}" class="flex-shrink-0">
                            <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.name}" class="w-16 h-16 object-cover rounded-md">
                        </a>
                        <div>
                            <h3 class="text-sm font-medium text-stone-700">
                                <a href="/products/details/${product.slug}" class="hover:text-rose-500">${product.name}</a>
                            </h3>
                            <div class="text-sm">
                                ${product.compare_at_price ? `
                                    <span class="line-through text-stone-500">${product.compare_at_price}</span>
                                    <span class="font-semibold text-rose-500">${product.price}</span>
                                ` : `
                                    <span class="font-semibold text-stone-700">${product.price}</span>
                                `}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            });
            searchResults.classList.remove('hidden');
        }
    }

    // FAQ Buttons
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