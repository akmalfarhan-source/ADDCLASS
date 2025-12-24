<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['umkm', 'categories', 'photos']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter by UMKM
        if ($request->filled('umkm')) {
            $query->where('umkm_id', $request->umkm);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        $umkms = Umkm::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'umkms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $umkms = Umkm::where('is_active', true)->get();

        return view('products.create', compact('categories', 'umkms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'umkm_id' => 'required|exists:umkm,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_photo' => 'nullable|integer|min:0',
        ]);

        $product = Product::create([
            'umkm_id' => $validated['umkm_id'],
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Attach categories
        if (!empty($validated['categories'])) {
            $product->categories()->attach($validated['categories']);
        }

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('products/photos', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_path' => $path,
                    'is_primary' => $index === (int) $request->input('primary_photo', 0),
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['umkm', 'categories', 'photos']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'photos']);
        $categories = Category::all();
        $umkms = Umkm::where('is_active', true)->get();

        return view('products.edit', compact('product', 'categories', 'umkms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'umkm_id' => 'required|exists:umkm,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:product_photos,id',
            'primary_photo_id' => 'nullable|exists:product_photos,id',
        ]);

        $product->update([
            'umkm_id' => $validated['umkm_id'],
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Sync categories
        $product->categories()->sync($validated['categories'] ?? []);

        // Delete photos if requested
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = ProductPhoto::find($photoId);
                if ($photo && $photo->product_id === $product->id) {
                    Storage::disk('public')->delete($photo->photo_path);
                    $photo->delete();
                }
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('products/photos', 'public');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'photo_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Set primary photo
        if ($request->filled('primary_photo_id')) {
            $product->photos()->update(['is_primary' => false]);
            $product->photos()->where('id', $request->primary_photo_id)->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all photos
        foreach ($product->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Search products (public)
     */
    public function search(Request $request)
    {
        $query = Product::with(['umkm', 'categories', 'photos'])
            ->where('is_active', true)
            ->whereHas('umkm', function ($q) {
                $q->where('is_active', true);
            });

        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('umkm', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('categories', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by UMKM
        if ($request->filled('umkm')) {
            $query->where('umkm_id', $request->umkm);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('products.search', compact('products', 'categories'));
    }
}
