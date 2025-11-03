<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white">
            Digi Admin
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
            </svg>
            Dashboard
        </a>

        <!-- Users Management -->
        <div x-data="{ open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Users
                </div>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" class="ml-6 mt-2 space-y-1">
                <a href="{{ route('admin.users.index') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.users.index') ? 'bg-gray-700 text-white' : '' }}">
                    All Users
                </a>
                <a href="{{ route('admin.users.create') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.users.create') ? 'bg-gray-700 text-white' : '' }}">
                    Add User
                </a>
                <a href="{{ route('admin.roles.index') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.roles.*') ? 'bg-gray-700 text-white' : '' }}">
                    Roles & Permissions
                </a>
            </div>
        </div>

        <!-- Products Management -->
        <div x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white">
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
                <a href="{{ route('admin.products.index') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.products.index') ? 'bg-gray-700 text-white' : '' }}">
                    All Products
                </a>
                <a href="{{ route('admin.products.create') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.products.create') ? 'bg-gray-700 text-white' : '' }}">
                    Add Product
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 text-white' : '' }}">
                    Categories
                </a>
                <a href="{{ route('admin.brands.index') }}" 
                   class="block px-4 py-2 text-sm text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.brands.*') ? 'bg-gray-700 text-white' : '' }}">
                    Brands
                </a>
            </div>
        </div>

        <!-- Orders Management -->
        <a href="{{ route('admin.orders.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Orders
        </a>

        <!-- Vendors Management -->
        <a href="{{ route('admin.vendors.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.vendors.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Vendors
        </a>

        <!-- Analytics -->
        <a href="{{ route('admin.analytics.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.analytics.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Analytics
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings.index') }}" 
           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Settings
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-300">Administrator</p>
            </div>
        </div>
    </div>
</div>