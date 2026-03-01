@extends('dashboard.app')

@section('title', 'Manage Custom Orders')

@section('content')
    @include('Alert.alert')

    @php
        $pendingCount = $orders->where('status', 'pending')->count();
        $processingCount = $orders->where('status', 'processing')->count();
    @endphp

    <div class="container mx-auto px-4 py-8" x-data="{ statusFilter: 'all' }">
        <h1 class="text-2xl font-bold mb-6 text-gray-200">Manage Custom Orders</h1>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('custom-orders.index') }}" class="mb-6">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search orders..."
                class="w-full md:w-1/3 bg-slate-700 border border-slate-600 text-gray-200 placeholder-gray-400 px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
        </form>

        <!-- Filter Buttons -->
        <div class="flex gap-4 mb-6 flex-wrap">
            <button @click="statusFilter = 'all'"
                class="px-4 py-2 rounded-lg transition-colors relative"
                :class="statusFilter === 'all' ? 'bg-blue-600 text-white shadow-lg' : 'bg-slate-700 text-gray-300 hover:bg-slate-600'">
                All
            </button>

            <button @click="statusFilter = 'pending'"
                class="px-4 py-2 rounded-lg transition-colors relative"
                :class="statusFilter === 'pending' ? 'bg-yellow-600 text-white shadow-lg' : 'bg-slate-700 text-gray-300 hover:bg-slate-600'">
                Pending
                @if ($pendingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'processing'"
                class="px-4 py-2 rounded-lg transition-colors relative"
                :class="statusFilter === 'processing' ? 'bg-purple-600 text-white shadow-lg' : 'bg-slate-700 text-gray-300 hover:bg-slate-600'">
                Processing
                @if ($processingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $processingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'completed'"
                class="px-4 py-2 rounded-lg transition-colors"
                :class="statusFilter === 'completed' ? 'bg-green-600 text-white shadow-lg' : 'bg-slate-700 text-gray-300 hover:bg-slate-600'">
                Completed
            </button>

            <button @click="statusFilter = 'cancelled'"
                class="px-4 py-2 rounded-lg transition-colors"
                :class="statusFilter === 'cancelled' ? 'bg-red-600 text-white shadow-lg' : 'bg-slate-700 text-gray-300 hover:bg-slate-600'">
                Cancelled
            </button>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto bg-slate-800 rounded-lg shadow-xl border border-slate-700">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-slate-700/50">
                    <tr>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">#</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Customer Name</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Phone</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Email</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Order Details</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Delivery Address</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Status</th>
                        <th class="px-4 py-3 border border-slate-700 text-left text-sm font-semibold text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr x-show="statusFilter === 'all' || statusFilter === '{{ $order->status }}'" class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $order->customer_phone ?? '-' }}</td>
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $order->customer_email ?? '-' }}</td>
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $order->order_details }}</td>
                            <td class="px-4 py-3 border border-slate-700 text-gray-300">{{ $order->delivery_address ?? '-' }}</td>
                            <td class="px-4 py-3 border border-slate-700">
                                <span class="px-2 py-1 rounded text-xs font-medium capitalize
                                    @if($order->status == 'pending') bg-yellow-900/30 text-yellow-400 border border-yellow-700/50
                                    @elseif($order->status == 'processing') bg-purple-900/30 text-purple-400 border border-purple-700/50
                                    @elseif($order->status == 'completed') bg-green-900/30 text-green-400 border border-green-700/50
                                    @else bg-red-900/30 text-red-400 border border-red-700/50
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border border-slate-700">
                                <form action="{{ route('custom-orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
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
                            <td colspan="8" class="text-center py-8 text-gray-400">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 text-gray-300">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
