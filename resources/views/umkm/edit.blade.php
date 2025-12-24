@extends('layouts.app')

@section('title', 'Edit UMKM')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
                <li class="breadcrumb-item active">Edit UMKM</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.umkm.update', $umkm) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="stat-card mb-4">
                    <h5 class="fw-semibold mb-4">Informasi UMKM</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama UMKM <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $umkm->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                                required>{{ old('alamat', $umkm->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                value="{{ old('telepon', $umkm->telepon) }}" required>
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email UMKM</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $umkm->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo UMKM</label>
                            @if($umkm->logo)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($umkm->logo) }}" alt="Logo"
                                        style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $umkm->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">UMKM Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update UMKM
                    </button>
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="stat-card">
                <h5 class="fw-semibold mb-3">Pemilik UMKM</h5>
                @if($umkm->user)
                    <p class="mb-1"><strong>{{ $umkm->user->name }}</strong></p>
                    <p class="text-muted mb-0">{{ $umkm->user->email }}</p>
                @else
                    <p class="text-muted mb-0">Tidak ada pemilik terdaftar</p>
                @endif
            </div>
        </div>
    </div>
@endsection