<!DOCTYPE html>
<html lang="en" x-data="{ openSidebar: false }" @click.outside="openSidebar = false">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/d703802588.js" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-900 text-gray-200">

    <div class="flex h-screen">
        <!-- Sidebar (Desktop) -->
        <aside class="bg-gradient-to-b from-slate-800 to-slate-900 w-64 hidden md:block shadow-2xl border-r border-slate-700">
            <div class="flex flex-col h-full">
                <!-- Logo Section -->
                <div class="p-6 border-b border-slate-700/50">
                    <img src="{{ asset('/public/Logo/logo.png') }}" alt="logo" class="w-36 mx-auto drop-shadow-lg brightness-110">
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="/dashboard" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="/dashboard/sliders" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-images w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Sliders</span>
                    </a>
                    <a href="{{ route('advertise.index') }}"
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-bullhorn w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Advertise</span>
                    </a>
                    <a href="{{ route('viewCategories') }}"
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-folder w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Categories</span>
                    </a>
                    <a href="/dashboard/products" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-box w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Products</span>
                    </a>
                    <a href="/dashboard/custom-order" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-clipboard-list w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Custom Orders</span>
                    </a>
                    <a href="/dashboard/orders" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-shopping-cart w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                    <a href="/dashboard/review" 
                        class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                        @click="openSidebar = false">
                        <i class="fas fa-star w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                        <span class="font-medium">Reviews</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Sidebar (Mobile Drawer) -->
        <div class="fixed inset-0 z-40 flex md:hidden" x-show="openSidebar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="openSidebar = false"></div>

            <!-- Drawer -->
            <aside class="relative bg-gradient-to-b from-slate-800 to-slate-900 w-64 h-full shadow-2xl z-50 border-r border-slate-700">
                <div class="flex flex-col h-full">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-700/50">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('/public/Logo/logo.png') }}" alt="logo" class="w-10 h-10 drop-shadow-lg brightness-110">
                            <span class="text-xl font-bold text-gray-200">Menu</span>
                        </div>
                        <button @click="openSidebar = false" class="p-2 rounded-lg hover:bg-slate-700/50 transition-colors">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                        <a href="/dashboard" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="/dashboard/sliders" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-images w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Sliders</span>
                        </a>
                        <a href="{{ route('advertise.index') }}"
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-bullhorn w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Advertise</span>
                        </a>
                        <a href="{{ route('viewCategories') }}"
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-folder w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Categories</span>
                        </a>
                        <a href="/dashboard/products" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-box w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Products</span>
                        </a>
                        <a href="/dashboard/custom-order" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-clipboard-list w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Custom Orders</span>
                        </a>
                        <a href="/dashboard/orders" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-shopping-cart w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Orders</span>
                        </a>
                        <a href="/dashboard/review" 
                            class="flex items-center gap-3 py-3 px-4 text-gray-300 rounded-lg transition-all duration-200 hover:bg-slate-700/50 hover:text-white hover:shadow-md group"
                            @click="openSidebar = false">
                            <i class="fas fa-star w-5 text-center group-hover:scale-110 transition-transform text-gray-400 group-hover:text-blue-400"></i>
                            <span class="font-medium">Reviews</span>
                        </a>
                    </nav>
                </div>
            </aside>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col w-full overflow-hidden">
            <!-- Navbar -->
            <header class="bg-slate-800 shadow-xl border-b border-slate-700 px-6 py-4 flex justify-between items-center">
                <!-- Left Section -->
                <div class="flex items-center gap-4">
                    <!-- Hamburger (Mobile) -->
                    <button class="md:hidden p-2 rounded-lg hover:bg-slate-700 transition-colors" @click="openSidebar = true">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <!-- Page Title (Optional - can be dynamic) -->
                    <div class="hidden md:flex items-center gap-2">
                        <div class="h-8 w-1 bg-gradient-to-b from-blue-500 to-blue-600 rounded-full"></div>
                        <h1 class="text-xl font-semibold text-gray-200">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-4">
                    <!-- Notifications (Optional) -->
                    <button class="relative p-2 rounded-lg hover:bg-slate-700 transition-colors group">
                        <i class="fas fa-bell text-gray-400 group-hover:text-blue-400 transition-colors"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Avatar Dropdown -->
                    <div class="relative">
                        <div class="flex items-center gap-3 cursor-pointer group" onclick="toggleDropdown()">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-200">Admin</p>
                                <p class="text-xs text-gray-400">Administrator</p>
                            </div>
                            <div class="relative">
                                <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-full w-10 h-10 ring-2 ring-blue-500 ring-offset-2 ring-offset-slate-800 group-hover:ring-blue-400 transition-all">
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-blue-500 border-2 border-slate-800 rounded-full"></span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-blue-400 transition-colors"></i>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="dropdownMenu"
                            class="absolute right-0 mt-3 w-56 bg-slate-800 rounded-xl shadow-2xl py-2 hidden z-50 border border-slate-700 overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-700 bg-gradient-to-r from-slate-700/50 to-transparent">
                                <p class="text-sm font-semibold text-gray-200">Admin User</p>
                                <p class="text-xs text-gray-400">admin@example.com</p>
                            </div>
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition-colors">
                                <i class="fas fa-user-circle w-5 text-gray-500"></i>
                                <span>Profile</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition-colors">
                                <i class="fas fa-cog w-5 text-gray-500"></i>
                                <span>Settings</span>
                            </a>
                            <div class="border-t border-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logoutfromDashboard') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-400 hover:bg-red-900/20 transition-colors cursor-pointer">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 bg-gradient-to-br from-slate-900 to-slate-800 p-6 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function (e) {
            const dropdown = document.getElementById('dropdownMenu');
            const avatar = dropdown.previousElementSibling;
            if (!avatar.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>