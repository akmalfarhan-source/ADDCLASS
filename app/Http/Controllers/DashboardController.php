<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function admin()
    {
        $stats = [
            'total_umkm' => Umkm::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'active_umkm' => Umkm::where('is_active', true)->count(),
            'active_products' => Product::where('is_active', true)->count(),
        ];

        // Get recent UMKM
        $recentUmkm = Umkm::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get recent products
        $recentProducts = Product::with(['umkm', 'photos'])
            ->latest()
            ->take(5)
            ->get();

        // Data for chart - UMKM per month (last 6 months)
        $chartData = $this->getChartData();

        return view('dashboard.admin', compact('stats', 'recentUmkm', 'recentProducts', 'chartData'));
    }

    /**
     * Show UMKM owner dashboard
     */
    public function umkm()
    {
        $user = auth()->user();
        $umkm = $user->umkm;

        if (!$umkm) {
            return view('dashboard.umkm', [
                'umkm' => null,
                'stats' => null,
                'recentProducts' => collect(),
            ]);
        }

        $stats = [
            'total_products' => $umkm->products()->count(),
            'active_products' => $umkm->products()->where('is_active', true)->count(),
            'total_stok' => $umkm->products()->sum('stok'),
        ];

        $recentProducts = $umkm->products()
            ->with('photos', 'categories')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.umkm', compact('umkm', 'stats', 'recentProducts'));
    }

    /**
     * Get chart data for admin dashboard
     */
    private function getChartData(): array
    {
        $months = [];
        $umkmCounts = [];
        $productCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');

            $umkmCounts[] = Umkm::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $productCounts[] = Product::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'labels' => $months,
            'umkm' => $umkmCounts,
            'products' => $productCounts,
        ];
    }
}
