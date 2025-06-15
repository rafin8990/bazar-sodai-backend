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
                    <p class="text-3xl font-bold">0</p>
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
    </div>

    <div class="bg-white rounded-lg shadow p-6">
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
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-2 font-medium">#1001</td>
                    <td class="py-2">John Doe</td>
                    <td class="py-2">$120.00</td>
                    <td class="py-2">
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Paid</span>
                    </td>
                    <td class="py-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-2 font-medium">#1002</td>
                    <td class="py-2">Jane Smith</td>
                    <td class="py-2">$80.50</td>
                    <td class="py-2">
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Pending</span>
                    </td>
                    <td class="py-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 60%"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection