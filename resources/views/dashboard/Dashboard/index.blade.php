@extends('dashboard.app')

@section('title', 'Dashboard')

@section('content')
    @include('Alert.alert')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div
            class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-5 rounded-xl shadow hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm">Categories</h3>
                    <p class="text-3xl font-bold">{{ $categories->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 0 1 1-1h4l1 2h9a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4z" />
                </svg>
            </div>
        </div>
        <div
            class="bg-gradient-to-r from-green-400 to-emerald-600 text-white p-5 rounded-xl shadow hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm">Products</h3>
                    <p class="text-3xl font-bold">{{ $products->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M3 3h18v6H3z" />
                    <path d="M5 9v12h14V9" />
                </svg>
            </div>
        </div>
        <div
            class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-5 rounded-xl shadow hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm">Orders</h3>
                    <p class="text-3xl font-bold">{{ $orders->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
        </div>
        <div
            class="bg-gradient-to-r from-pink-500 to-rose-600 text-white p-5 rounded-xl shadow hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm">Users</h3>
                    <p class="text-3xl font-bold">{{ $users->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M16 14a4 4 0 1 0-8 0v4h8v-4z" />
                    <path d="M12 6a4 4 0 1 1 0 8 4 4 0 0 1 0-8z" />
                </svg>
            </div>
        </div>
        <div
            class="bg-gradient-to-r from-blue-500 to-green-600 text-white p-5 rounded-xl shadow hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm">Custom Orders</h3>
                    <p class="text-3xl font-bold">{{ $custom_orders->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M16 14a4 4 0 1 0-8 0v4h8v-4z" />
                    <path d="M12 6a4 4 0 1 1 0 8 4 4 0 0 1 0-8z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Recent Orders</h2>
        <table class="w-full text-left text-gray-700">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="py-2">Order ID</th>
                    <th class="py-2">Customer</th>
                    <th class="py-2">Amount</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2 font-medium">#{{ $order->id }}</td>
                        <td class="py-2">{{ $order->user->name ?? 'Unknown' }}</td>
                        <td class="py-2">৳{{ number_format($order->total_price, 2) }}</td>
                        <td class="py-2">
                            @php
                                $statusColor = match ($order->status) {
                                    'paid' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="{{ $statusColor }} text-xs px-2 py-1 rounded-full capitalize">{{ $order->status }}</span>
                        </td>
                        <td class="py-2">
                            @php
                                // Just demo width for progress bar, adjust based on actual data if available
                                $progressWidth = $order->status === 'paid' ? '100%' : ($order->status === 'pending' ? '60%' : '0%');
                                $progressColor = $order->status === 'paid' ? 'bg-green-500' : ($order->status === 'pending' ? 'bg-yellow-400' : 'bg-red-500');
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $progressColor }} h-2.5 rounded-full" style="width: {{ $progressWidth }}"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Products Table --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Products</h2>
        <table class="w-full text-left text-gray-700">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Category</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Stock Status</th>
                    <th class="py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2 font-medium">{{ $product->id }}</td>
                        <td class="py-2">{{ $product->name }}</td>
                        <td class="py-2">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="py-2">৳{{ number_format($product->price, 2) }}</td>
                        <td class="py-2">
                            @if ($product->in_stock)
                                <span class="text-green-600 font-semibold">In Stock</span>
                            @else
                                <span class="text-red-600 font-semibold">Out of Stock</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $product->created_at->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Users</h2>
        <table class="w-full text-left text-gray-700">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Registered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2 font-medium">{{ $user->id }}</td>
                        <td class="py-2">{{ $user->name }}</td>
                        <td class="py-2">{{ $user->email }}</td>
                        <td class="py-2">{{ $user->created_at->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection