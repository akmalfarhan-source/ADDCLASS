@extends('layouts.public')

@section('title', $product->nama)

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.search') }}">Produk</a></li>
                <li class="breadcrumb-item active">{{ $product->nama }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <!-- Product Images -->
                <div class="bg-white rounded-4 overflow-hidden shadow-sm">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @forelse($product->photos as $index => $photo)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::url($photo->photo_path) }}" class="d-block w-100"
                                        style="height:400px;object-fit:cover;">
                                </div>
                            @empty
                                <div class="carousel-item active">
                                    <div
                                        style="height:400px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-box-seam text-muted" style="font-size:5rem;"></i>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @if($product->photos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                    @if($product->photos->count() > 1)
                        <div class="p-3 d-flex gap-2 overflow-auto">
                            @foreach($product->photos as $index => $photo)
                                <img src="{{ Storage::url($photo->photo_path) }}" class="rounded"
                                    style="width:60px;height:60px;object-fit:cover;cursor:pointer;{{ $index == 0 ? 'border:2px solid var(--primary);' : '' }}"
                                    onclick="document.querySelector('#productCarousel .carousel-item.active').classList.remove('active');document.querySelectorAll('#productCarousel .carousel-item')[{{ $index }}].classList.add('active');">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Product Info -->
                <div class="mb-3">
                    @foreach($product->categories as $category)
                        <a href="{{ route('products.search', ['category' => $category->slug]) }}"
                            class="badge bg-primary text-decoration-none me-1">{{ $category->nama }}</a>
                    @endforeach
                </div>

                <h1 class="fw-bold mb-3">{{ $product->nama }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="me-4">
                        <small class="text-muted">Harga</small>
                        <div class="fs-3 fw-bold text-primary">{{ $product->formatted_harga }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Stok</small>
                        <div class="fs-5 fw-semibold">{{ $product->stok }} tersedia</div>
                    </div>
                </div>

                @if($product->deskripsi)
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-2">Deskripsi</h6>
                        <p class="text-muted">{{ $product->deskripsi }}</p>
                    </div>
                @endif

                <!-- UMKM Info -->
                <div class="bg-light rounded-4 p-4">
                    <h6 class="fw-semibold mb-3">Dijual oleh</h6>
                    <div class="d-flex align-items-center">
                        <div
                            style="width:60px;height:60px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;overflow:hidden;margin-right:1rem;">
                            @if($product->umkm->logo)
                                <img src="{{ Storage::url($product->umkm->logo) }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr($product->umkm->nama, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">{{ $product->umkm->nama }}</h6>
                            <small class="text-muted"><i
                                    class="bi bi-geo-alt me-1"></i>{{ Str::limit($product->umkm->alamat, 40) }}</small>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Telepon</small>
                                <span>{{ $product->umkm->telepon }}</span>
                            </div>
                            @if($product->umkm->email)
                                <div class="col-6">
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $product->umkm->email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection