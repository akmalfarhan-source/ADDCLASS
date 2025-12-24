@extends('layouts.public')

@section('title', 'Masuk')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Masuk ke Akun</h2>
                    <p class="text-muted">Kelola UMKM dan produk Anda</p>
                </div>

                <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="email@contoh.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <p class="text-center mb-0">
                                <a href="{{ route('password.request') }}" class="text-muted">Lupa Password?</a>
                            </p>
                        @endif
                    </form>
                </div>

                <p class="text-center mt-4">
                    Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar UMKM</a>
                </p>
            </div>
        </div>
    </div>
@endsection