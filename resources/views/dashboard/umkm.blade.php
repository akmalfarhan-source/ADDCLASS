@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
    @if(!$umkm)
        <!-- No UMKM Registered -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-building text-muted" style="font-size: 5rem;"></i>
            </div>
            <h3>UMKM Belum Terdaftar</h3>
            <p class="text-muted mb-4">Akun Anda belum terhubung dengan UMKM manapun.<br>Silakan hubungi administrator untuk
                mendaftarkan UMKM Anda.</p>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-card-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <div class="stat-card-value">{{ $stats['total_products'] }}</div>
                            <div class="stat-card-label">Total Produk</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-card-icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-card-value">{{ $stats['active_products'] }}</div>
                            <div class="stat-card-label">Produk Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="stat-card-icon bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-archive"></i>
                        </div>
                        <div>
                            <div class="stat-card-value">{{ $stats['total_stok'] }}</div>
                            <div class="stat-card-label">Total Stok</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UMKM Info & Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="stat-card">
                    <h5 class="fw-semibold mb-4">Informasi UMKM</h5>
                    <div class="row">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div
                                style="width:100px;height:100px;margin:0 auto;border-radius:50%;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;overflow:hidden;">
                                @if($umkm->logo)
                                    <img src="{{ Storage::url($umkm->logo) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    {{ strtoupper(substr($umkm->nama, 0, 2)) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h4 class="fw-semibold">{{ $umkm->nama }}</h4>
                            <p class="text-muted mb-2"><i class="bi bi-geo-alt me-2"></i>{{ $umkm->alamat }}</p>
                            <p class="text-muted mb-2"><i class="bi bi-telephone me-2"></i>{{ $umkm->telepon }}</p>
                            @if($umkm->email)
                                <p class="text-muted mb-2"><i class="bi bi-envelope me-2"></i>{{ $umkm->email }}</p>
                            @endif
                            <span class="badge {{ $umkm->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $umkm->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stat-card h-100">
                    <h5 class="fw-semibold mb-4">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('umkm-panel.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                        </a>
                        <a href="{{ route('umkm-panel.products.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-seam me-2"></i>Kelola Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="data-table">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">Produk Terbaru</h5>
                <a href="{{ route('umkm-panel.products.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3"
                                            style="width:40px;height:40px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                            @if($product->photos->first())
                                                <img src="{{ Storage::url($product->photos->first()->photo_path) }}"
                                                    style="width:100%;height:100%;object-fit:cover;">
                                            @else
                                                <i class="bi bi-box text-muted"></i>
                                            @endif
                                        </div>
                                        <div class="fw-semibold">{{ $product->nama }}</div>
                                    </div>
                                </td>
                                <td>
                                    @foreach($product->categories as $category)
                                        <span class="badge bg-light text-dark">{{ $category->nama }}</span>
                                    @endforeach
                                </td>
                                <td class="text-primary fw-semibold">{{ $product->formatted_harga }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('umkm-panel.products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada produk. <a href="{{ route('umkm-panel.products.create') }}">Tambah produk pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection