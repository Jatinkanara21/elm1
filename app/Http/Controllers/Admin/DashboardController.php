<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where("status", "delivered")->sum("total");
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $recentOrders = Order::with("user")->latest()->take(5)->get();

        return view("admin.dashboard", compact("totalOrders", "totalRevenue", "totalUsers", "totalProducts", "recentOrders"));
    }
}
