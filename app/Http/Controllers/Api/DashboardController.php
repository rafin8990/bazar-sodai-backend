<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $categories = Category::all();
        $products = Product::paginate(10);         // paginate products
        $users = User::where('role', 'user')->paginate(10);  // paginate users
        $orders = Order::paginate(10);             // paginate orders
        $custom_orders = CustomOrder::all();
        return view('dashboard.Dashboard.index', compact('categories', 'products', 'users', 'orders', 'custom_orders'));
    }
}
