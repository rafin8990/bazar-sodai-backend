@extends('dashboard.app')

@section('title', 'Category')

@section('content')
    @include('Alert.alert')

    <div x-data="categoryManager()" class="relative max-w-4xl mx-auto p-6 bg-slate-800 rounded-lg shadow-xl border border-slate-700">

        <h1 class="text-2xl font-bold mb-6 text-gray-200">Categories</h1>

        {{-- Floating Add Category Button --}}
        <button @click="openAddModal()"
            class="my-5 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition z-50 flex items-center gap-2"
            aria-label="Add Category">
            <i class="fas fa-plus"></i>
            <span>Add Category</span>
        </button>

        {{-- Categories Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-slate-700">
                <thead>
                    <tr class="bg-slate-700/50">
                        <th class="border border-slate-700 px-4 py-3 text-left text-gray-300 font-semibold">SL</th>
                        <th class="border border-slate-700 px-4 py-3 text-left text-gray-300 font-semibold">Serial No</th>
                        <th class="border border-slate-700 px-4 py-3 text-left text-gray-300 font-semibold">Name</th>
                        <th class="border border-slate-700 px-4 py-3 text-left text-gray-300 font-semibold">Icon</th>
                        <th class="border border-slate-700 px-4 py-3 text-left text-gray-300 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="border border-slate-700 px-4 py-3 text-gray-300">{{ $index + 1 }}</td>
                            <td class="border border-slate-700 px-4 py-3 text-gray-300">{{ $category->serial_no ?? '-' }}</td>
                            <td class="border border-slate-700 px-4 py-3 text-gray-300">{{ $category->name }}</td>
                            <td class="border border-slate-700 px-4 py-3">
                                @if($category->icon)
                                   <img src="{{ $category->icon }}" alt="Icon" class="w-10 h-10 object-contain rounded border border-slate-600">
                                @else
                                    <span class="text-gray-400 italic">No icon</span>
                                @endif
                            </td>
                            <td class="border border-slate-700 px-4 py-3 flex gap-3">
                                <button
                                    @click.prevent="openUpdateModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->icon ?? '') }}', {{ $category->serial_no ?? 'null' }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('deleteCategory', $category->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center gap-1">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-slate-700 px-4 py-8 text-center text-gray-400">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add Category Modal --}}
        <div x-show="showAddModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-40"
            @keydown.escape.window="showAddModal = false" @click.self="showAddModal = false" style="display: none;">
            <div class="bg-slate-800 rounded-xl max-w-md w-full p-6 relative border border-slate-700 shadow-2xl">
                <!-- Close Button -->
                <button @click="showAddModal = false"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-200 text-xl font-bold transition-colors"
                    aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>

                <h2 class="text-xl font-semibold mb-4 text-gray-200">Add New Category</h2>

                <form action="{{ route('createCategory') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Serial No -->
                    <div>
                        <label for="serial_no" class="block font-medium mb-2 text-gray-300">Serial No <span class="text-gray-400 text-xs">(optional)</span></label>
                        <input type="number" id="serial_no" name="serial_no" value="{{ old('serial_no') }}"
                            class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter serial number">
                        @error('serial_no')
                            <p class="text-red-400 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block font-medium mb-2 text-gray-300">Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        @error('name')
                            <p class="text-red-400 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Icon Upload -->
                    <div>
                        <label for="icon" class="block font-medium mb-2 text-gray-300">Icon Image (optional)</label>
                        <input type="file" id="icon" name="icon"
                            class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer">
                        @error('icon')
                            <p class="text-red-400 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Update Category Modal --}}
        <div x-show="showUpdateModal" x-transition style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-40"
            @keydown.escape.window="showUpdateModal = false" @click.self="showUpdateModal = false">
            <div class="bg-slate-800 rounded-xl max-w-md w-full p-6 relative border border-slate-700 shadow-2xl">
                <button @click="showUpdateModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-200 transition-colors"
                    aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>

                <h2 class="text-xl font-semibold mb-4 text-gray-200">Update Category</h2>

                <form :action="updateAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="update-serial_no" class="block font-medium mb-2 text-gray-300">Serial No <span class="text-gray-400 text-xs">(optional)</span></label>
                        <input type="number" id="update-serial_no" name="serial_no" x-model="updateSerialNo"
                            class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter serial number" />
                    </div>

                    <div>
                        <label for="update-name" class="block font-medium mb-2 text-gray-300">Name <span
                                class="text-red-400">*</span></label>
                        <input type="text" id="update-name" name="name" x-model="updateName" required
                            class="w-full bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <div>
                        <label for="update-icon" class="block font-medium mb-2 text-gray-300">Icon Image (optional)</label>
                        <input type="file" id="update-icon" name="icon"
                            class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer" />
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showUpdateModal = false"
                            class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
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
                updateSerialNo: null,
                get updateAction() {
                    return `/categories/update/${this.updateId}`;
                },
                openAddModal() {
                    this.showAddModal = true;
                },
                openUpdateModal(id, name, icon, serialNo) {
                    this.updateId = id;
                    this.updateName = name;
                    this.updateIcon = icon;
                    this.updateSerialNo = serialNo !== null ? serialNo : '';
                    this.showUpdateModal = true;
                }
            };
        }
    </script>
@endsection