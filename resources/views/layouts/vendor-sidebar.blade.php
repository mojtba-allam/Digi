<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-blue-800">
        <a href="{{ route('vendor.dashboard') }}" class="text-2xl font-bold text-white">
            Digi Vendor
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('vendor.dashboard') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('vendor.dashboard') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
            </svg>
            Dashboard
        </a>

        <!-- Products Management -->
        <div x-data="{ open: {{ request()->routeIs('vendor.products.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" class="ml-6 mt-2 space-y-1">
                <a href="{{ route('vendor.products.index') }}" 
                   class="block px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white {{ request()->routeIs('vendor.products.index') ? 'bg-blue-700 text-white' : '' }}">
                    My Products
                </a>
                <a href="{{ route('vendor.products.create') }}" 
                   class="block px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white {{ request()->routeIs('vendor.products.create') ? 'bg-blue-700 text-white' : '' }}">
                    Add Product
                </a>
                <a href="{{ route('vendor.inventory.index') }}" 
                   class="block px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white {{ request()->routeIs('vendor.inventory.*') ? 'bg-blue-700 text-white' : '' }}">
                    Inventory
                </a>
            </div>
        </div>

        <!-- Orders Management -->
        <a href="{{ route('vendor.orders.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('vendor.orders.*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Orders
        </a>

        <!-- Commission & Payouts -->
        <div x-data="{ open: {{ request()->routeIs('vendor.commission.*') || request()->routeIs('vendor.payouts.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Earnings
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" class="ml-6 mt-2 space-y-1">
                <a href="{{ route('vendor.commission.index') }}" 
                   class="block px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white {{ request()->routeIs('vendor.commission.*') ? 'bg-blue-700 text-white' : '' }}">
                    Commission
                </a>
                <a href="{{ route('vendor.payouts.index') }}" 
                   class="block px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 hover:text-white {{ request()->routeIs('vendor.payouts.*') ? 'bg-blue-700 text-white' : '' }}">
                    Payouts
                </a>
            </div>
        </div>

        <!-- Analytics -->
        <a href="{{ route('vendor.analytics.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('vendor.analytics.*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Analytics
        </a>

        <!-- Profile -->
        <a href="{{ route('vendor.profile.show') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('vendor.profile.*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profile
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-blue-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-200">Vendor</p>
            </div>
        </div>
    </div>
</div>