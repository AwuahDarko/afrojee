<div id="search-modal" data-search-url="{{ route('web.product.search2') }}" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Modal Backdrop -->
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-75 transition-opacity duration-300 ease-in-out"></div>

    <!-- Modal Content (unchanged from Step 2) -->
    <div class="modal bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4 p-6 relative z-10">
        <form action="{{ route('web.product.search2') }}" method="GET" class="gsp-search-form">
            <div class="relative">
                <input
                    type="text"
                    name="q"
                    id="search-input"
                    placeholder="Search for products..."
                    class="w-full p-3 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-stone-700"
                    autocomplete="off"
                >
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
            </div>
            <div id="search-results" class="gsp-search-recommend-collection mt-4 max-h-96 overflow-y-auto hidden">
                <div class="gsp-search-recommend-collection-list space-y-4"></div>
            </div>
        </form>
        <button id="search-modal-close" class="absolute top-2 right-2 text-stone-500 hover:text-rose-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>