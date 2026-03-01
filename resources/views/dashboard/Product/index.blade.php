@extends('dashboard.app')

@section('title', 'Dashboard')

@section('content')
    @include('Alert.alert')

    <div x-data="productPage()" class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-200">Product Management</h1>
            <button @click="openCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg hover:shadow-xl transition-colors flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Create Product</span>
            </button>
        </div>

        <!-- Category Filter -->
        <div class="mb-4 flex items-center gap-4">
            <label for="categoryFilter" class="font-semibold text-gray-300">Filter by Category:</label>
            <select id="categoryFilter" name="category_id" 
                    onchange="window.location.href='?category_id='+this.value" 
                    class="bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">-- All Categories --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Product Table -->
        <div class="overflow-x-auto bg-slate-800 rounded-lg shadow-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-700/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Image</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Weight</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Featured</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3">
                                @if($product->image)
                                    <img src="/{{ $product->image }}" class="w-16 h-16 object-cover rounded border border-slate-600"
                                        alt="{{ $product->name }}">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->category->name }}</td>
                            <td class="px-4 py-3 text-gray-300">৳{{ $product->price }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $product->weight ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                @if($product->is_featured)
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-green-900/30 text-green-400 border border-green-700/50">Yes</span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-slate-700/50 text-gray-400 border border-slate-600">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <button @click="openEditModal({{ $product->toJson() }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm shadow transition-colors flex items-center gap-1">
                                    <i class="fas fa-edit text-xs"></i>
                                    <span>Update</span>
                                </button>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm shadow transition-colors flex items-center gap-1"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash text-xs"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-gray-300">
            {{ $products->links() }}
        </div>

        <!-- Create Product Modal -->
        <div x-show="showCreateModal"
            class="fixed inset-0 backdrop-blur-sm bg-black bg-opacity-60 z-50 flex items-center justify-center" x-transition @click.self="closeCreateModal">
            <div class="bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl border border-slate-700" @click.away="closeCreateModal">
                <div class="flex justify-between items-center p-4 border-b border-slate-700">
                    <h2 class="text-xl font-semibold text-gray-200">Create Product</h2>
                    <button @click="closeCreateModal" class="text-gray-400 hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-4">
                    @csrf
                    @include('component.productForm')
                </form>
            </div>
        </div>

        <!-- Update Product Modal -->
        <div x-show="showEditModal"
            class="fixed inset-0 backdrop-blur-sm bg-black bg-opacity-60 z-50 flex items-center justify-center" x-transition.opacity @click.self="closeEditModal">
            <div class="bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl border border-slate-700" @click.away="closeEditModal">
                <div class="flex justify-between items-center p-4 border-b border-slate-700">
                    <h2 class="text-xl font-semibold text-gray-200">Update Product</h2>
                    <button @click="closeEditModal" class="text-gray-400 hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form :action="`/products/${formData.id}`" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    @include('component.productForm')
                </form>
            </div>
        </div>
    </div>

    <script>
        function productPage() {
            return {
                showCreateModal: false,
                showEditModal: false,
                formData: {
                    id: '',
                    name: '',
                    description: '',
                    price: '',
                    original_price: '',
                    category_id: '',
                    weight: '',
                    image: '',
                    in_stock: false,
                    is_top_selling: false,
                    is_new_arrival: false,
                    is_featured: false,
                    nutritional_info: ''
                },

                openCreateModal() {
                    this.resetForm();
                    this.showCreateModal = true;
                },

                closeCreateModal() {
                    this.showCreateModal = false;
                },

                openEditModal(product) {
                    this.formData = {
                        id: product.id || '',
                        name: product.name || '',
                        description: product.description || '',
                        price: product.price || '',
                        original_price: product.original_price || '',
                        category_id: product.category_id || '',
                        weight: product.weight || '',
                        image: product.image || '',
                        in_stock: product.in_stock == 1,
                        is_top_selling: product.is_top_selling == 1,
                        is_new_arrival: product.is_new_arrival == 1,
                        is_featured: product.is_featured == 1,
                        nutritional_info: product.nutritional_info || ''
                    };

                    this.showEditModal = true;
                },

                closeEditModal() {
                    this.showEditModal = false;
                },

                resetForm() {
                    this.formData = {
                        id: '',
                        name: '',
                        description: '',
                        price: '',
                        original_price: '',
                        category_id: '',
                        weight: '',
                        image: '',
                        in_stock: false,
                        is_top_selling: false,
                        is_new_arrival: false,
                        is_featured: false,
                        nutritional_info: ''
                    };
                }
            }
        }
    </script>

@endsection
