<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function ordersByCountry() {
     return Order::query()
      ->select(['countries.name', DB::raw('COUNT(orders.id) as count')])
      ->join('customers', 'orders.created_by','=','customers.id')
      ->join('countries', 'customers.country_code','=', 'countries.code')
      ->where('orders.status','paid')
      ->groupBy('countries.name')
      ->get();
    }

    public function latestCustomers() {

      return  Customer::query()
         ->select(['u.id','u.email', 'customers.first_name','customers.last_name'])
         ->join('users AS u', 'u.id' ,'=', 'customers.id')
         ->where('customers.status','yes')
         ->orderBy('u.created_at', 'desc')
         ->limit(10)
         ->get();


    }
}
