<!DOCTYPE html>
<html lang="en" x-data="{ openSidebar: false }" @click.outside="openSidebar = false">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/d703802588.js" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="flex h-screen">
        <!-- Sidebar (Desktop) -->
        <aside class="bg-green-100 w-64 hidden md:block shadow-lg">
            <img src="{{ asset('/logo/logo.png') }}" alt="logo" class="w-32 mx-auto my-4">
            <nav class="px-4 space-y-2">
                <a href="/dashboard" class="block py-2 px-3 text-green-600 rounded hover:bg-indigo-100"
                    @click="openSidebar = false">Dashboard</a>
                <a href="{{ route('viewCategories') }}"
                    class="block py-2 px-3 text-green-600 rounded hover:bg-indigo-100"
                    @click="openSidebar = false">Categories</a>
                <a href="/dashboard/products" class="block py-2 px-3 text-green-600 rounded hover:bg-indigo-100"
                    @click="openSidebar = false">Products</a>
                <a href="/dashboard/custom-order" class="block py-2 px-3 text-green-600 rounded hover:bg-indigo-100"
                    @click="openSidebar = false">Custom Orders</a>
            </nav>
        </aside>

        <!-- Sidebar (Mobile Drawer) -->
        <div class="fixed inset-0 z-40 flex md:hidden" x-show="openSidebar" x-transition>
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-40" @click="openSidebar = false"></div>

            <!-- Drawer -->
            <aside class="relative bg-green-100 w-64 h-full shadow-xl z-50">
                <div class="flex items-center justify-between p-4 border-b">
                    <span class="text-xl font-bold text-green-600">Menu</span>
                    <button @click="openSidebar = false">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="p-4 space-y-2">
                    <a href="/dashboard" class="block py-2 px-3 rounded text-green-600 hover:bg-indigo-100"
                        @click="openSidebar = false">Dashboard</a>
                    <a href="{{ route('viewCategories') }}"
                        class="block py-2 px-3 rounded text-green-600 hover:bg-indigo-100"
                        @click="openSidebar = false">Categories</a>
                    <a href="/dashboard/products" class="block py-2 px-3 rounded text-green-600 hover:bg-indigo-100"
                        @click="openSidebar = false">Products</a>
                    <a href="/dashboard/custom-order" class="block py-2 px-3 text-green-600 rounded hover:bg-indigo-100"
                        @click="openSidebar = false">Custom Orders</a>
                </nav>
            </aside>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col w-full">
            <!-- Navbar -->
            <header class="bg-green-100 shadow-md px-6 py-4 flex justify-between items-center">
                <!-- Hamburger (Mobile) -->
                <button class="md:hidden" @click="openSidebar = true">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="text-lg font-semibold"></div>

                <!-- Avatar Dropdown -->
                <div class="relative">
                    <div class="flex items-center space-x-4 cursor-pointer" onclick="toggleDropdown()">
                        <span class="text-sm">Hello, Admin</span>
                        <img src="https://i.pravatar.cc/32" alt="Avatar" class="rounded-full w-8 h-8">
                    </div>

                    <!-- Dropdown menu -->
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-md py-2 hidden z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <form method="POST" action="{{ route('logoutfromDashboard') }}">
                            @csrf
                            <button type="submit"
                                class="block px-4 py-2 text-sm text-red-500 hover:underline cursor-pointer">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 bg-green-50 p-6 overflow-y-auto">
                @yield('content')
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