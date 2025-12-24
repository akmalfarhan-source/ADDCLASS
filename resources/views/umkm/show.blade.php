@extends('layouts.app')

@section('title', 'Detail UMKM')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
                <li class="breadcrumb-item active">{{ $umkm->nama }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- UMKM Info -->
            <div class="stat-card mb-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex align-items-center">
                        <div
                            style="width:80px;height:80px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius:16px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.5rem;font-weight:600;overflow:hidden;margin-right:1rem;">
                            @if($umkm->logo)
                                <img src="{{ Storage::url($umkm->logo) }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr($umkm->nama, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <h4 class="fw-semibold mb-1">{{ $umkm->nama }}</h4>
                            <span class="badge {{ $umkm->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $umkm->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.umkm.edit', $umkm) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Alamat</label>
                        <p class="mb-0">{{ $umkm->alamat }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Telepon</label>
                        <p class="mb-0">{{ $umkm->telepon }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Email</label>
                        <p class="mb-0">{{ $umkm->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Pemilik</label>
                        <p class="mb-0">{{ $umkm->user->name ?? '-' }}</p>
                    </div>
                    @if($umkm->deskripsi)
                        <div class="col-12">
                            <label class="form-label text-muted small">Deskripsi</label>
                            <p class="mb-0">{{ $umkm->deskripsi }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Products -->
            <div class="data-table">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Produk ({{ $umkm->products->count() }})</h5>
                    <a href="{{ route('admin.products.create') }}?umkm={{ $umkm->id }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus me-1"></i>Tambah Produk
                    </a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($umkm->products as $product)
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
                                            <a href="{{ route('admin.products.show', $product) }}"
                                                class="fw-semibold text-decoration-none">{{ $product->nama }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($product->categories as $category)
                                            <span class="badge bg-light text-dark">{{ $category->nama }}</span>
                                        @endforeach
                                    </td>
                                    <td class="fw-semibold text-primary">{{ $product->formatted_harga }}</td>
                                    <td>{{ $product->stok }}</td>
                                    <td>
                                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card mb-4">
                <h6 class="fw-semibold mb-3">Statistik</h6>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Total Produk</span>
                    <span class="fw-semibold">{{ $umkm->products->count() }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Produk Aktif</span>
                    <span class="fw-semibold">{{ $umkm->products->where('is_active', true)->count() }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Total Stok</span>
                    <span class="fw-semibold">{{ $umkm->products->sum('stok') }}</span>
                </div>
            </div>

            <div class="stat-card">
                <h6 class="fw-semibold mb-3">Aksi</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.umkm.edit', $umkm) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i>Edit UMKM
                    </a>
                    <form action="{{ route('admin.umkm.destroy', $umkm) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus UMKM ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Hapus UMKM
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection