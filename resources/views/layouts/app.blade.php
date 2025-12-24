<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UMKM Manager') }} - @yield('title', 'Dashboard')</title>
    <meta name="description" content="Sistem Manajemen UMKM dan Produk Lokal">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-width: 280px;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #4f46e5;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 1rem;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.25rem;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar-nav-link.active {
            background: var(--sidebar-active);
            color: white;
        }

        .sidebar-nav-link i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-section-title {
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title {
            font-weight: 600;
            font-size: 1.5rem;
            color: #1e293b;
            margin: 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-card-label {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Table */
        .data-table {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .data-table .table {
            margin: 0;
        }

        .data-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            border: none;
            padding: 1rem;
        }

        .data-table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.625rem 1rem;
            border-color: #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shop"></i>
            </div>
            <span class="sidebar-brand-text">UMKM Manager</span>
        </a>

        <nav>
            <ul class="sidebar-nav">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="sidebar-section-title">Menu Utama</li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-section-title">Manajemen Data</li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('admin.umkm.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
                                <i class="bi bi-building"></i>
                                <span>Data UMKM</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i>
                                <span>Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="bi bi-tags"></i>
                                <span>Kategori</span>
                            </a>
                        </li>
                    @else
                        <li class="sidebar-section-title">Menu Utama</li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('umkm-panel.dashboard') }}"
                                class="sidebar-nav-link {{ request()->routeIs('umkm-panel.dashboard') || request()->routeIs('umkm.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-section-title">Kelola Produk</li>
                        <li class="sidebar-nav-item">
                            <a href="{{ route('umkm-panel.products.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('umkm-panel.products.*') ? 'active' : '' }}">
                                <i class="bi bi-box-seam"></i>
                                <span>Produk Saya</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-section-title">Lainnya</li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('home') }}" class="sidebar-nav-link">
                            <i class="bi bi-house"></i>
                            <span>Halaman Utama</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link d-lg-none me-2"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="user-menu">
                @auth
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block">
                                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                <small
                                    class="text-muted">{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Pemilik UMKM' }}</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>