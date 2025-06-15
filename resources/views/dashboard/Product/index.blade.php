@extends('dashboard.app')

@section('title', 'Dashboard')

@section('content')
    @include('Alert.alert')

    <div x-data="productPage()" class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Product Management</h1>
            <button @click="openCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                + Create Product
            </button>
        </div>

        <!-- Product Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Weight</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Featured</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)

                        <tr>
                            <td class="px-4 py-2">
                                @if($product->image)
                                    <img src="/{{ $product->image }}" class="w-16 h-16 object-cover rounded"
                                        alt="{{ $product->name }}">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->category->name }}</td>
                            <td class="px-4 py-2">৳{{ $product->price }}</td>
                            <td class="px-4 py-2">{{ $product->weight ?? 'N/A' }}</td>
                            <td class="px-4 py-2">
                                @if($product->is_featured)
                                    <span class="text-green-600 font-semibold">Yes</span>
                                @else
                                    <span class="text-gray-500">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <button @click="openEditModal({{ $product->toJson() }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow">Update</button>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Create Product Modal -->
        <div x-show="showCreateModal"
            class="fixed inset-0 backdrop-blur-sm bg-opacity-40 z-50 flex items-center justify-center" x-transition>
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl" @click.away="closeCreateModal">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-semibold">Create Product</h2>
                    <button @click="closeCreateModal" class="text-gray-600 hover:text-red-600 text-2xl">&times;</button>
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
            class="fixed inset-0 backdrop-blur-sm bg-opacity-40 z-50 flex items-center justify-center" x-transition.opacity>
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl" @click.away="closeEditModal">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-semibold">Update Product</h2>
                    <button @click="closeEditModal" class="text-gray-600 hover:text-red-600 text-2xl">&times;</button>
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