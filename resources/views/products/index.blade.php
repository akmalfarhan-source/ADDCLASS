@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Produk</h4>
            <p class="text-muted mb-0">Kelola produk dari UMKM</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Filter -->
    <div class="stat-card mb-4">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="umkm" class="form-select">
                    <option value="">Semua UMKM</option>
                    @foreach($umkms as $umkm)
                        <option value="{{ $umkm->id }}" {{ request('umkm') == $umkm->id ? 'selected' : '' }}>{{ $umkm->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card h-100 p-0 overflow-hidden">
                    <div
                        style="height:160px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        @if($product->photos->first())
                            <img src="{{ Storage::url($product->photos->first()->photo_path) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="bi bi-box-seam text-muted" style="font-size:3rem;"></i>
                        @endif
                    </div>
                    <div class="p-3">
                        @if($product->categories->first())
                            <small class="text-primary fw-semibold">{{ $product->categories->first()->nama }}</small>
                        @endif
                        <h6 class="fw-semibold mt-1 mb-1">{{ Str::limit($product->nama, 30) }}</h6>
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-shop me-1"></i>{{ $product->umkm->nama }}
                        </small>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-semibold">{{ $product->formatted_harga }}</span>
                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="d-flex gap-1 mt-3">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="stat-card text-center py-5">
                    <i class="bi bi-box-seam display-4 text-muted d-block mb-3"></i>
                    <p class="text-muted mb-0">Belum ada produk</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection