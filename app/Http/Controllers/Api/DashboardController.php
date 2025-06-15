<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $categories=Category::all();
        $products=Product::all();
        $users=User::where('role', 'user')->get();
        return view('dashboard.Dashboard.index', compact('categories', 'products','users'));
    }
}
