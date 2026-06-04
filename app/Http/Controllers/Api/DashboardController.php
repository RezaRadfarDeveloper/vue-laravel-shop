<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalCustomers() {
      return  User::where('is_admin', false)->count();
       
    }

    public function activeProducts() {
       return  Product::count();
    }

    public function paidOrders() {
       return Order::where('status','paid')->count();
    }

    public function totalIncome() {
       return  Order::where('status','paid')->sum('total_price');
    }
}
