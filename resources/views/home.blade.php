@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="hero-title">Temukan Produk Terbaik dari UMKM Lokal</h1>
                    <p class="hero-subtitle">Dukung ekonomi lokal dengan berbelanja langsung dari UMKM di sekitar Anda.
                        Temukan berbagai produk berkualitas dengan harga terjangkau.</p>

                    <form action="{{ route('products.search') }}" method="GET" class="search-box">
                        <input type="text" name="q" placeholder="Cari produk, kategori, atau UMKM..." class="form-control">
                        <button type="submit">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['umkm_count'] ?? 0 }}</div>
                        <div class="stat-label">UMKM Terdaftar</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['product_count'] ?? 0 }}</div>
                        <div class="stat-label">Produk Tersedia</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['category_count'] ?? 0 }}</div>
                        <div class="stat-label">Kategori</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if($categories->count() > 0)
        <section class="py-5 mt-5">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="section-title">Kategori Produk</h2>
                    <p class="section-subtitle">Jelajahi berbagai kategori produk dari UMKM</p>
                </div>
                <div class="text-center">
                    @foreach($categories as $category)
                        <a href="{{ route('products.search', ['category' => $category->slug]) }}" class="category-pill">
                            {{ $category->nama }} ({{ $category->products_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <section class="py-5 bg-white">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="section-title">Produk Terbaru</h2>
                        <p class="section-subtitle mb-0">Produk terbaru dari UMKM pilihan</p>
                    </div>
                    <a href="{{ route('products.search') }}" class="btn btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($featuredProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card">
                                <div class="product-image">
                                    @if($product->photos->first())
                                        <img src="{{ Storage::url($product->photos->first()->photo_path) }}" alt="{{ $product->nama }}">
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
                                        <a href="{{ route('products.show.public', $product) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured UMKM -->
    @if($featuredUmkm->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="section-title">UMKM Terpopuler</h2>
                    <p class="section-subtitle">UMKM dengan produk terbanyak</p>
                </div>
                <div class="row g-4">
                    @foreach($featuredUmkm as $umkm)
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="umkm-card">
                                <div class="umkm-logo">
                                    @if($umkm->logo)
                                        <img src="{{ Storage::url($umkm->logo) }}" alt="{{ $umkm->nama }}">
                                    @else
                                        {{ strtoupper(substr($umkm->nama, 0, 2)) }}
                                    @endif
                                </div>
                                <h6 class="umkm-name">{{ $umkm->nama }}</h6>
                                <p class="umkm-products">{{ $umkm->products_count }} produk</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-5" style="background: var(--gradient);">
        <div class="container text-center text-white py-4">
            <h2 class="fw-bold mb-3">Punya UMKM? Daftarkan Sekarang!</h2>
            <p class="mb-4 opacity-75">Promosikan produk Anda ke lebih banyak pelanggan dengan bergabung bersama kami.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </section>
@endsection