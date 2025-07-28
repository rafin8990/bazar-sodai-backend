<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_details' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'payment_type' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $totalPrice = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $totalPrice += $subtotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
                'image' => $product->image,
            ];
        }

        $order = Order::create([
            'user_id' => $user->id ?? null,
            'address_details' => $request->address_details,
            'mobile_no' => $request->mobile_no,
            'payment_type' => $request->payment_type,
            'total_price' => $totalPrice,
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'order_id' => $order->id,
            'total_price' => $totalPrice,
            'items' => $orderItems,
        ], 201);
    }

    public function getOrders(Request $request)
    {

        $user = $request->user();

        $orders = Order::with(['orderItems.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "order Places Successfully",
            'orders' => $orders
        ], 200);
    }

    public function allOrders(Request $request)
    {
        $orders = Order::with(['user', 'orderItems.product'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('dashboard.Order.index', compact('orders'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,processing,completed,cancelled',
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Order status updated successfully.');
}


}
