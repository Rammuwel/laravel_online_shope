<?php
namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class DashcoardController extends Controller
{
    public function index(){
        // Total orders
        $totalOrder = Order::where('status', '!=', 'cancelled')->count();

        // Total products
        $totalProduct = Product::count();

        // Total customers (excluding role ID 2)
        $totalCustomer = User::where('role', '!=', 2)->count();

        // Total revenue
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');

        // This month's revenue
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $thisMonthTotalRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $monthStartDate)
            ->whereDate('created_at', '<=', $todayDate)
            ->sum('grand_total');

        // Last month's revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthTotalRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $lastMonthStartDate)
            ->whereDate('created_at', '<=', $lastMonthEndDate)
            ->sum('grand_total');

        // Last 30 days' revenue
        $dateDay30 = Carbon::now()->subDays(30)->format('Y-m-d');
        $last30DayRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $dateDay30)
            ->whereDate('created_at', '<=', $todayDate)
            ->sum('grand_total');

       
        return view('admin.dashboard',[
            'totalOrder' => $totalOrder,
            'totalProduct' => $totalProduct,
            'totalCustomer' => $totalCustomer,
            'totalRevenue'  => $totalRevenue,
            'thisMonthTotalRevenue' => $thisMonthTotalRevenue,
            'lastMonthTotalRevenue' => $lastMonthTotalRevenue,
            'last30DayRevenue'       => $last30DayRevenue
        ]);
    }
}
