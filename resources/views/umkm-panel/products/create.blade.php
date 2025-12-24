@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('umkm-panel.products.index') }}">Produk Saya</a></li>
                <li class="breadcrumb-item active">Tambah Produk</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('umkm-panel.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Informasi Produk</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="4">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga') }}" min="0" step="100" required>
                            </div>
                            @error('harga')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok', 0) }}" min="0" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Foto Produk</h5>
                    <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple
                        accept="image/*">
                    <small class="text-muted">Maksimal 5 foto. Format: JPG, PNG, GIF. Maks: 2MB per foto.</small>
                    @error('photos.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Kategori</h5>
                    @foreach($categories as $category)
                        <div class="form-check mb-2">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input"
                                id="cat{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->nama }}</label>
                        </div>
                    @endforeach
                    @error('categories')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Status</h5>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Produk Aktif</label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Simpan Produk
                    </button>
                    <a href="{{ route('umkm-panel.products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
@endsection