@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">{{ $stats['total_umkm'] }}</div>
                        <div class="stat-card-label">Total UMKM</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">{{ $stats['active_umkm'] }}</div>
                        <div class="stat-card-label">UMKM Aktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">{{ $stats['total_products'] }}</div>
                        <div class="stat-card-label">Total Produk</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-card-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div>
                        <div class="stat-card-value">{{ $stats['total_categories'] }}</div>
                        <div class="stat-card-label">Kategori</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="stat-card">
                <h5 class="fw-semibold mb-4">Pertumbuhan Data (6 Bulan Terakhir)</h5>
                <canvas id="growthChart" height="100"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="stat-card h-100">
                <h5 class="fw-semibold mb-4">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.umkm.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah UMKM
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-warning">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="row g-4">
        <!-- Recent UMKM -->
        <div class="col-lg-6">
            <div class="data-table">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">UMKM Terbaru</h5>
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Pemilik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUmkm as $umkm)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $umkm->nama }}</div>
                                        <small class="text-muted">{{ Str::limit($umkm->alamat, 30) }}</small>
                                    </td>
                                    <td>{{ $umkm->user->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $umkm->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $umkm->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Belum ada data UMKM
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="col-lg-6">
            <div class="data-table">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Produk Terbaru</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>UMKM</th>
                                <th>Harga</th>
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
                                    <td>{{ $product->umkm->nama }}</td>
                                    <td class="text-primary fw-semibold">{{ $product->formatted_harga }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Belum ada data produk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('growthChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            label: 'UMKM',
                            data: @json($chartData['umkm']),
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Produk',
                            data: @json($chartData['products']),
                            borderColor: '#06b6d4',
                            backgroundColor: 'rgba(6, 182, 212, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush