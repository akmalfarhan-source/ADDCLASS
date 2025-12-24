@extends('layouts.public')

@section('title', 'Daftar UMKM')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Daftarkan UMKM Anda</h2>
                    <p class="text-muted">Bergabunglah bersama kami untuk mempromosikan produk UMKM Anda</p>
                </div>

                <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Account Section -->
                        <div class="mb-4 pb-4 border-bottom">
                            <h5 class="fw-semibold mb-3">
                                <i class="bi bi-person-circle me-2 text-primary"></i>Informasi Akun
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autofocus
                                        placeholder="Masukkan nama lengkap Anda">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required placeholder="Minimal 8 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label">Konfirmasi Password <span
                                            class="text-danger">*</span></label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <!-- UMKM Section -->
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3">
                                <i class="bi bi-building me-2 text-primary"></i>Informasi UMKM
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="umkm_nama" class="form-label">Nama UMKM <span
                                            class="text-danger">*</span></label>
                                    <input id="umkm_nama" type="text"
                                        class="form-control @error('umkm_nama') is-invalid @enderror" name="umkm_nama"
                                        value="{{ old('umkm_nama') }}" required placeholder="Contoh: Toko Batik Nusantara">
                                    @error('umkm_nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="umkm_alamat" class="form-label">Alamat UMKM <span
                                            class="text-danger">*</span></label>
                                    <textarea id="umkm_alamat"
                                        class="form-control @error('umkm_alamat') is-invalid @enderror" name="umkm_alamat"
                                        rows="2" required
                                        placeholder="Alamat lengkap UMKM Anda">{{ old('umkm_alamat') }}</textarea>
                                    @error('umkm_alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="umkm_telepon" class="form-label">No. Telepon UMKM <span
                                            class="text-danger">*</span></label>
                                    <input id="umkm_telepon" type="text"
                                        class="form-control @error('umkm_telepon') is-invalid @enderror" name="umkm_telepon"
                                        value="{{ old('umkm_telepon') }}" required placeholder="08xxxxxxxxxx">
                                    @error('umkm_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="umkm_email" class="form-label">Email UMKM</label>
                                    <input id="umkm_email" type="email"
                                        class="form-control @error('umkm_email') is-invalid @enderror" name="umkm_email"
                                        value="{{ old('umkm_email') }}" placeholder="Email khusus UMKM (opsional)">
                                    @error('umkm_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="umkm_deskripsi" class="form-label">Deskripsi UMKM</label>
                                    <textarea id="umkm_deskripsi"
                                        class="form-control @error('umkm_deskripsi') is-invalid @enderror"
                                        name="umkm_deskripsi" rows="3"
                                        placeholder="Ceritakan tentang UMKM Anda, produk yang dijual, dll.">{{ old('umkm_deskripsi') }}</textarea>
                                    @error('umkm_deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                            </button>
                        </div>

                        <p class="text-center text-muted mt-4 mb-0">
                            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection