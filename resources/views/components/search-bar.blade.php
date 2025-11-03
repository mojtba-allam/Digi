@props([
    'placeholder' => 'Search products...',
    'route' => 'products.index'
])

<div class="relative" x-data="searchComponent()" x-init="init()">
    <form action="{{ route($route) }}" method="GET" class="relative">
        <input 
            type="text" 
            name="search"
            x-model="query"
            @input="search()"
            @focus="showSuggestions = true"
            @keydown.escape="showSuggestions = false"
            @keydown.arrow-down.prevent="highlightNext()"
            @keydown.arrow-up.prevent="highlightPrevious()"
            @keydown.enter.prevent="selectHighlighted()"
            placeholder="{{ $placeholder }}" 
            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            autocomplete="off"
        >
        <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </form>

    <!-- Search Suggestions Dropdown -->
    <div 
        x-show="showSuggestions && suggestions.length > 0"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        @click.away="showSuggestions = false"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"
    >
        <template x-for="(suggestion, index) in suggestions" :key="index">
            <div 
                @click="selectSuggestion(suggestion)"
                :class="{ 'bg-blue-50': highlightedIndex === index }"
                class="px-4 py-2 cursor-pointer hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
            >
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span x-text="suggestion" class="text-sm text-gray-900"></span>
                </div>
            </div>
        </template>
        
        <!-- View All Results -->
        <div class="px-4 py-2 border-t border-gray-200 bg-gray-50">
            <button 
                @click="viewAllResults()"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium"
            >
                View all results for "<span x-text="query"></span>"
            </button>
        </div>
    </div>
</div>

<script>
function searchComponent() {
    return {
        query: '',
        suggestions: [],
        showSuggestions: false,
        highlightedIndex: -1,
        searchTimeout: null,

        init() {
            // Get initial query from URL if present
            const urlParams = new URLSearchParams(window.location.search);
            this.query = urlParams.get('search') || '';
        },

        search() {
            clearTimeout(this.searchTimeout);
            
            if (this.query.length < 2) {
                this.suggestions = [];
                this.showSuggestions = false;
                return;
            }

            this.searchTimeout = setTimeout(() => {
                fetch(`{{ route('products.suggestions') }}?q=${encodeURIComponent(this.query)}`)
                    .then(response => response.json())
                    .then(data => {
                        this.suggestions = data;
                        this.showSuggestions = true;
                        this.highlightedIndex = -1;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        },

        selectSuggestion(suggestion) {
            this.query = suggestion;
            this.showSuggestions = false;
            this.viewAllResults();
        },

        highlightNext() {
            if (this.highlightedIndex < this.suggestions.length - 1) {
                this.highlightedIndex++;
            }
        },

        highlightPrevious() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
            }
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.highlightedIndex < this.suggestions.length) {
                this.selectSuggestion(this.suggestions[this.highlightedIndex]);
            } else {
                this.viewAllResults();
            }
        },

        viewAllResults() {
            if (this.query.trim()) {
                window.location.href = `{{ route('products.index') }}?search=${encodeURIComponent(this.query)}`;
            }
        }
    }
}
</script>