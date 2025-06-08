<div x-data="{ open: false }" class="w-full">
    <button @click="open = !open" 
            class="flex items-center w-full px-4 py-2 text-left text-green-600 hover:bg-green-200 transition duration-200">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span class="flex-1">Categories</span>
        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-transition class="bg-green-200 text-sm">
        <a href="{{ route('viewCategories') }}" @click="openSidebar = false" class="block px-8 py-2 text-green-600 hover:bg-green-300">All Categories</a>
    </div>

</div>