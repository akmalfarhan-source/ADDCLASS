<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index()
    {
        // Get featured products (latest active products)
        $featuredProducts = Product::with(['umkm', 'photos', 'categories'])
            ->where('is_active', true)
            ->whereHas('umkm', function ($q) {
                $q->where('is_active', true);
            })
            ->latest()
            ->take(8)
            ->get();

        // Get all categories
        $categories = Category::withCount([
            'products' => function ($q) {
                $q->where('is_active', true);
            }
        ])->get();

        // Get featured UMKM
        $featuredUmkm = Umkm::where('is_active', true)
            ->withCount([
                'products' => function ($q) {
                    $q->where('is_active', true);
                }
            ])
            ->latest()
            ->take(6)
            ->get();

        // Statistics
        $stats = [
            'umkm_count' => Umkm::where('is_active', true)->count(),
            'product_count' => Product::where('is_active', true)->count(),
            'category_count' => Category::count(),
        ];

        return view('home', compact('featuredProducts', 'categories', 'featuredUmkm', 'stats'));
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('umkm.dashboard');
    }
}
