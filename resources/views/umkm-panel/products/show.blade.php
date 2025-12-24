@extends('layouts.app')

@section('title', $product->nama)

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('umkm-panel.products.index') }}">Produk Saya</a></li>
                <li class="breadcrumb-item active">{{ $product->nama }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <div style="border-radius:12px;overflow:hidden;background:#f1f5f9;">
                            @if($product->photos->first())
                                <img src="{{ Storage::url($product->photos->first()->photo_path) }}"
                                    style="width:100%;height:250px;object-fit:cover;">
                            @else
                                <div style="height:250px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-box-seam text-muted" style="font-size:4rem;"></i>
                                </div>
                            @endif
                        </div>
                        @if($product->photos->count() > 1)
                            <div class="d-flex gap-2 mt-2">
                                @foreach($product->photos->skip(1) as $photo)
                                    <img src="{{ Storage::url($photo->photo_path) }}"
                                        style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="mb-2">
                            @foreach($product->categories as $category)
                                <span class="badge bg-primary">{{ $category->nama }}</span>
                            @endforeach
                        </div>
                        <h4 class="fw-semibold mb-3">{{ $product->nama }}</h4>
                        <div class="fs-4 fw-bold text-primary mb-3">{{ $product->formatted_harga }}</div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Stok</small>
                                <span class="fw-semibold">{{ $product->stok }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        @if($product->deskripsi)
                            <small class="text-muted d-block">Deskripsi</small>
                            <p class="mb-0">{{ $product->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card">
                <h6 class="fw-semibold mb-3">Aksi</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('umkm-panel.products.edit', $product) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Produk
                    </a>
                    <form action="{{ route('umkm-panel.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection