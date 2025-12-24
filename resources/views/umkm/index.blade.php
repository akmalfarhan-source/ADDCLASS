@extends('layouts.app')

@section('title', 'Data UMKM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Data UMKM</h4>
            <p class="text-muted mb-0">Kelola data UMKM yang terdaftar</p>
        </div>
        <a href="{{ route('admin.umkm.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah UMKM
        </a>
    </div>

    <!-- Filter -->
    <div class="stat-card mb-4">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, alamat, atau telepon..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="data-table">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>UMKM</th>
                        <th>Pemilik</th>
                        <th>Kontak</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($umkms as $umkm)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3"
                                        style="width:50px;height:50px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;overflow:hidden;">
                                        @if($umkm->logo)
                                            <img src="{{ Storage::url($umkm->logo) }}"
                                                style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            {{ strtoupper(substr($umkm->nama, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $umkm->nama }}</div>
                                        <small class="text-muted">{{ Str::limit($umkm->alamat, 40) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $umkm->user->name ?? '-' }}</td>
                            <td>
                                <div>{{ $umkm->telepon }}</div>
                                <small class="text-muted">{{ $umkm->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $umkm->products_count ?? $umkm->products->count() }}
                                    produk</span>
                            </td>
                            <td>
                                <span class="badge {{ $umkm->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $umkm->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.umkm.show', $umkm) }}" class="btn btn-outline-secondary"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.umkm.edit', $umkm) }}" class="btn btn-outline-primary"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.umkm.destroy', $umkm) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus UMKM ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-building display-4 d-block mb-3"></i>
                                Belum ada data UMKM
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($umkms->hasPages())
            <div class="p-3 border-top">
                {{ $umkms->links() }}
            </div>
        @endif
    </div>
@endsection