@extends('dashboard.app')

@section('title', 'Manage Custom Orders')

@section('content')
    @include('Alert.alert')

    @php
        $pendingCount = $orders->where('status', 'pending')->count();
        $processingCount = $orders->where('status', 'processing')->count();
    @endphp

    <div class="container mx-auto px-4 py-8" x-data="{ statusFilter: 'all' }">
        <h1 class="text-2xl font-bold mb-6">Manage Custom Orders</h1>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('custom-orders.index') }}" class="mb-6">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search orders..."
                class="w-full md:w-1/3 px-4 py-2 border rounded shadow-sm"
            >
        </form>

        <!-- Filter Buttons -->
        <div class="flex gap-4 mb-6">
            <button @click="statusFilter = 'all'"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                :class="{ 'bg-blue-500 text-white': statusFilter === 'all' }">All</button>

            <button @click="statusFilter = 'pending'"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 relative"
                :class="{ 'bg-yellow-500 text-white': statusFilter === 'pending' }">
                Pending
                @if ($pendingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'processing'"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 relative"
                :class="{ 'bg-purple-500 text-white': statusFilter === 'processing' }">
                Processing
                @if ($processingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $processingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'completed'"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                :class="{ 'bg-green-500 text-white': statusFilter === 'completed' }">Completed</button>

            <button @click="statusFilter = 'cancelled'"
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                :class="{ 'bg-red-500 text-white': statusFilter === 'cancelled' }">Cancelled</button>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Customer Name</th>
                        <th class="px-4 py-2 border">Phone</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Order Details</th>
                        <th class="px-4 py-2 border">Delivery Address</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr x-show="statusFilter === 'all' || statusFilter === '{{ $order->status }}'">
                            <td class="px-4 py-2 border">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td class="px-4 py-2 border">{{ $order->customer_name }}</td>
                            <td class="px-4 py-2 border">{{ $order->customer_phone ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $order->customer_email ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $order->order_details }}</td>
                            <td class="px-4 py-2 border">{{ $order->delivery_address ?? '-' }}</td>
                            <td class="px-4 py-2 border capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-2 border">
                                <form action="{{ route('custom-orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
