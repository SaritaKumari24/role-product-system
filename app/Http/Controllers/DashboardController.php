<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the admin / manager dashboard.
     */
    public function index(): View
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $activeProducts = Product::where('status', 'active')->count();

        $roleCounts = [
            'admin' => User::role('admin')->count(),
            'manager' => User::role('manager')->count(),
            'customer' => User::role('customer')->count(),
        ];

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'activeProducts',
            'roleCounts',
            'recentProducts',
            'recentUsers'
        ));
    }
}

