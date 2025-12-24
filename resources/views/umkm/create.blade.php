@extends('layouts.app')

@section('title', 'Tambah UMKM')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
                <li class="breadcrumb-item active">Tambah UMKM</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- UMKM Info -->
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Informasi UMKM</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama UMKM <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                                required>{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                value="{{ old('telepon') }}" required>
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email UMKM</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo UMKM</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                                    checked>
                                <label class="form-check-label" for="is_active">UMKM Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Owner Info -->
                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Informasi Pemilik UMKM</h5>
                    <p class="text-muted mb-4">Akun ini akan digunakan pemilik untuk login dan mengelola produk UMKM.</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name"
                                class="form-control @error('owner_name') is-invalid @enderror"
                                value="{{ old('owner_name') }}" required>
                            @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Login <span class="text-danger">*</span></label>
                            <input type="email" name="owner_email"
                                class="form-control @error('owner_email') is-invalid @enderror"
                                value="{{ old('owner_email') }}" required>
                            @error('owner_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="owner_password"
                                class="form-control @error('owner_password') is-invalid @enderror" required>
                            @error('owner_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Simpan UMKM
                    </button>
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection