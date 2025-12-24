@extends('layouts.public')

@section('title', 'Cari Produk')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Filter -->
            <div class="col-lg-3 mb-4">
                <div class="bg-white rounded-4 p-4 shadow-sm sticky-top" style="top:100px;">
                    <h5 class="fw-semibold mb-4">Filter</h5>
                    <form method="GET">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pencarian</label>
                            <input type="text" name="q" class="form-control" placeholder="Cari produk..."
                                value="{{ request('q') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kategori</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input type="radio" name="category" value="{{ $category->slug }}" class="form-check-input"
                                        id="cat{{ $category->id }}" {{ request('category') == $category->slug ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">Terapkan Filter</button>
                        <a href="{{ route('products.search') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </form>
                </div>
            </div>

            <!-- Products -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">
                            @if(request('q'))
                                Hasil pencarian "{{ request('q') }}"
                            @elseif(request('category'))
                                Kategori:
                                {{ $categories->firstWhere('slug', request('category'))->nama ?? request('category') }}
                            @else
                                Semua Produk
                            @endif
                        </h4>
                        <p class="text-muted mb-0">{{ $products->total() }} produk ditemukan</p>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card">
                                <div class="product-image">
                                    @if($product->photos->first())
                                        <img src="{{ Storage::url($product->photos->first()->photo_path) }}"
                                            alt="{{ $product->nama }}">
                                    @else
                                        <i class="bi bi-box-seam"></i>
                                    @endif
                                </div>
                                <div class="product-body">
                                    @if($product->categories->first())
                                        <span class="product-category">{{ $product->categories->first()->nama }}</span>
                                    @endif
                                    <h5 class="product-title">{{ $product->nama }}</h5>
                                    <p class="product-umkm">
                                        <i class="bi bi-shop me-1"></i>{{ $product->umkm->nama }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="product-price">{{ $product->formatted_harga }}</span>
                                        <a href="{{ route('products.show.public', $product) }}" class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="bg-white rounded-4 p-5 text-center shadow-sm">
                                <i class="bi bi-search display-1 text-muted mb-3 d-block"></i>
                                <h5>Produk tidak ditemukan</h5>
                                <p class="text-muted mb-3">Coba ubah kata kunci atau filter pencarian Anda</p>
                                <a href="{{ route('products.search') }}" class="btn btn-primary">Lihat Semua Produk</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection