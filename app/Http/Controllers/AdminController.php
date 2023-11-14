<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function homeAdmin()
    {
        $data = [];
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');
        //This month
        $startThisMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $thisMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startThisMonth)
            ->whereDate('created_at', '<=', $currentDate)->sum('grand_total');
        //Last month
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startLastMonth)
            ->whereDate('created_at', '<=', $endLastMonth)->sum('grand_total');

        //Latest 30 days
        $latest30Day = Carbon::now()->subDay(30)->format('Y-m-d');
        $last30DaysRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $latest30Day)
            ->whereDate('created_at', '<=', $currentDate)->sum('grand_total');

        $data['totalOrders'] = $totalOrders;
        $data['totalProducts'] = $totalProducts;
        $data['totalCustomers'] = $totalCustomers;
        $data['totalRevenue'] = $totalRevenue;
        $data['thisMonthRevenue'] = $thisMonthRevenue;
        $data['lastMonthRevenue'] = $lastMonthRevenue;
        $data['last30DaysRevenue'] = $last30DaysRevenue;
        return view('admin-home', $data);
    }
}
