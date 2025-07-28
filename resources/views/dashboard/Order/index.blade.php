@extends('dashboard.app')

@section('title', 'All Orders')

@section('content')
    @include('Alert.alert')

    @php
        $pendingCount = $orders->where('status', 'pending')->count();
        $processingCount = $orders->where('status', 'processing')->count();
    @endphp

    <div class="container mx-auto px-4 py-8" x-data="{ statusFilter: 'all' }">
        <h1 class="text-2xl font-bold mb-6">All Orders</h1>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-3 mb-6">
            <button @click="statusFilter = 'all'"
                class="px-4 py-2 rounded bg-blue-100 hover:bg-blue-300"
                :class="{ 'bg-blue-500 text-white': statusFilter === 'all' }">All</button>

            <button @click="statusFilter = 'pending'"
                class="px-4 py-2 rounded bg-yellow-100 relative hover:bg-yellow-300"
                :class="{ 'bg-yellow-500 text-white': statusFilter === 'pending' }">
                Pending
                @if ($pendingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'processing'"
                class="px-4 py-2 rounded bg-purple-100 relative hover:bg-purple-300"
                :class="{ 'bg-purple-500 text-white': statusFilter === 'processing' }">
                Processing
                @if ($processingCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ $processingCount }}
                    </span>
                @endif
            </button>

            <button @click="statusFilter = 'completed'"
                class="px-4 py-2 rounded bg-green-100 hover:bg-green-300"
                :class="{ 'bg-green-500 text-white': statusFilter === 'completed' }">Completed</button>

            <button @click="statusFilter = 'cancelled'"
                class="px-4 py-2 rounded bg-red-100 hover:bg-red-300"
                :class="{ 'bg-red-500 text-white': statusFilter === 'cancelled' }">Cancelled</button>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-300 shadow-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Customer</th>
                        <th class="px-4 py-2 border">Phone</th>
                        <th class="px-4 py-2 border">Products</th>
                        <th class="px-4 py-2 border">Total Price</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr x-show="statusFilter === 'all' || statusFilter === '{{ $order->status }}'">
                            <td class="px-4 py-2 border">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td class="px-4 py-2 border">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-4 py-2 border">{{ $order->mobile_no ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                <ul class="list-disc ml-4 text-sm text-gray-700">
                                    @foreach ($order->orderItems as $item)
                                        <li>
                                            {{ $item->product->name ?? 'N/A' }} ({{ $item->product->weight }}) × {{ $item->quantity }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 border font-semibold">{{ $order->total_price }}৳</td>
                            <td class="px-4 py-2 border capitalize text-sm font-medium">
                                <span class="px-2 py-1 rounded text-white
                                    @if($order->status == 'pending') bg-yellow-500
                                    @elseif($order->status == 'processing') bg-purple-500
                                    @elseif($order->status == 'completed') bg-green-500
                                    @elseif($order->status == 'cancelled') bg-red-500
                                    @endif
                                ">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">
                                <form action="{{ route('order.status.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="border text-sm rounded px-2 py-1">
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
                            <td colspan="7" class="text-center py-6 text-gray-500">No orders available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
