<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        $orders = CustomOrder::when($search, function ($query, $search) {
            $query->where('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_email', 'like', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%")
                ->orWhere('order_details', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.custom_order.index', compact('orders', 'search'));
    }
    public function createOrder(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'order_details' => 'required|string',
            'delivery_address' => 'nullable|string|max:500',
            'status' => 'nullable|in:pending,processing,completed,cancelled',
        ]);

        // Create the custom order
        $order = CustomOrder::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'order_details' => $validated['order_details'],
            'delivery_address' => $validated['delivery_address'] ?? null,
            'status' => $validated['status'] ?? 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => $order,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = CustomOrder::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
