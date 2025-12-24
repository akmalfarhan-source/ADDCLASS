@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('umkm-panel.products.index') }}">Produk Saya</a></li>
                <li class="breadcrumb-item active">Edit Produk</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('umkm-panel.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Informasi Produk</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $product->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga', $product->harga) }}" min="0" step="100" required>
                            </div>
                            @error('harga')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok', $product->stok) }}" min="0" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Foto Produk</h5>
                    @if($product->photos->count() > 0)
                        <div class="row g-3 mb-3">
                            @foreach($product->photos as $photo)
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($photo->photo_path) }}" class="w-100 rounded"
                                            style="height:120px;object-fit:cover;">
                                        <div class="form-check position-absolute" style="top:5px;left:5px;">
                                            <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"
                                                class="form-check-input" id="del{{ $photo->id }}">
                                            <label class="form-check-label small text-white bg-danger px-1 rounded"
                                                for="del{{ $photo->id }}">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple
                        accept="image/*">
                    <small class="text-muted">Tambah foto baru. Maks 5 total.</small>
                    @error('photos.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Kategori</h5>
                    @php $productCategories = $product->categories->pluck('id')->toArray(); @endphp
                    @foreach($categories as $category)
                        <div class="form-check mb-2">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input"
                                id="cat{{ $category->id }}" {{ in_array($category->id, old('categories', $productCategories)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->nama }}</label>
                        </div>
                    @endforeach
                    @error('categories')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Status</h5>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $product->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Produk Aktif</label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Produk
                    </button>
                    <a href="{{ route('umkm-panel.products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
@endsection