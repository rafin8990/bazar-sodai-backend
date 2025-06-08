@extends('dashboard.app')

@section('title', 'Category')

@section('content')
    @include('Alert.alert')

    <div x-data="categoryManager()" class="relative max-w-4xl mx-auto p-6 bg-white rounded shadow">

        <h1 class="text-2xl font-bold mb-6">Categories</h1>

        {{-- Floating Add Category Button --}}
        <button @click="openAddModal()"
            class="my-5 bg-green-600 text-white px-4 py-2 rounded-full shadow-lg hover:bg-green-700 transition z-50"
            aria-label="Add Category">
            + Add Category
        </button>

        {{-- Categories Table --}}
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-green-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">SL</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Icon</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                    <tr class="hover:bg-green-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($category->icon)
                               <img src="{{ $category->icon }}" alt="Icon" class="w-10 h-10 object-contain">
                            @else
                                <span class="text-gray-400 italic">No icon</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <a href="#"
                                @click.prevent="openUpdateModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->icon ?? '') }}')"
                                class="text-blue-600 hover:underline"><i class="fa-solid fa-pen"></i></a>

                            <form action="{{ route('deleteCategory', $category->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Add Category Modal --}}
        <div x-show="showAddModal" x-transition
            class="fixed inset-0  bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-40"
            @keydown.escape.window="showAddModal = false" style="display: none;">
            <div class="bg-white rounded-lg max-w-md w-full p-6 relative">
                <!-- Close Button -->
                <button @click="showAddModal = false"
                    class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold"
                    aria-label="Close modal">
                    &times;
                </button>

                <h2 class="text-xl font-semibold mb-4">Add New Category</h2>

                <form action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block font-medium mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                        @error('name')
                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Icon Upload -->
                    <div>
                        <label for="icon" class="block font-medium mb-1">Icon Image (optional)</label>
                        <input type="file" id="icon" name="icon"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @error('icon')
                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 rounded border hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Update Category Modal --}}
        <div x-show="showUpdateModal" x-transition style="display: none;"
            class="fixed inset-0 bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-40"
            @keydown.escape.window="showUpdateModal = false">
            <div class="bg-white rounded-lg max-w-md w-full p-6 relative">
                <button @click="showUpdateModal = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900"
                    aria-label="Close modal">&times;</button>

                <h2 class="text-xl font-semibold mb-4">Update Category</h2>

                <form :action="updateAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="update-name" class="block font-medium mb-1">Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="update-name" name="name" x-model="updateName" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>

                    <div>
                        <label for="update-icon" class="block font-medium mb-1">Icon Image (optional)</label>
                        <input type="file" id="update-icon" name="icon"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showUpdateModal = false"
                            class="px-4 py-2 rounded border hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function categoryManager() {
            return {
                showAddModal: false,
                showUpdateModal: false,
                updateId: null,
                updateName: '',
                updateIcon: '',
                get updateAction() {
                    return `/categories/update/${this.updateId}`;
                },
                openAddModal() {
                    this.showAddModal = true;
                },
                openUpdateModal(id, name, icon) {
                    this.updateId = id;
                    this.updateName = name;
                    this.updateIcon = icon;
                    this.showUpdateModal = true;
                }
            };
        }
    </script>
@endsection