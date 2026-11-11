<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS App') — {{ \App\Models\Setting::get('store_name', 'POS App') }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans (Modern & Clean) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            /* Warna Utama */
            --pos-primary: #4f46e5; /* Indigo modern */
            --pos-primary-light: #e0e7ff;
            --pos-primary-dark: #3730a3;
            --pos-gray-50: #f9fafb;
            --pos-gray-100: #f3f4f6;
            --pos-gray-200: #e5e7eb;
            --pos-gray-600: #4b5563;
            --pos-gray-900: #111827;
            
            --bs-primary: var(--pos-primary);
            --bs-primary-rgb: 79, 70, 229;
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        * { box-sizing: border-box; }
        body {
            background-color: var(--pos-gray-50);
            font-family: var(--bs-body-font-family);
            font-size: 0.9rem;
            color: var(--pos-gray-900);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* ================== ANIMASI ================== */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Animasi cuma dipake di konten utama */
        .animate-content {
            animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Efek Card muncul berurutan */
        .card {
            opacity: 0;
            animation: slideUpFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .card:nth-child(1) { animation-delay: 0.05s; }
        .card:nth-child(2) { animation-delay: 0.1s; }
        .card:nth-child(3) { animation-delay: 0.15s; }
        .card:nth-child(4) { animation-delay: 0.2s; }

        /* ================== LAYOUT UTAMA ================== */
        .app-shell { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid var(--pos-gray-200);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1040;
            transition: all 0.3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--pos-gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.02em;
        }
        .sidebar-brand i {
            color: var(--pos-primary);
            font-size: 1.5rem;
            background: var(--pos-primary-light);
            padding: 0.4rem;
            border-radius: 0.5rem;
        }
        
        .sidebar-nav { padding: 0 1rem 1rem 1rem; }
        .sidebar-nav .nav-link {
            color: var(--pos-gray-600);
            padding: 0.7rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover {
            background: var(--pos-gray-100);
            color: var(--pos-gray-900);
            transform: translateX(3px);
        }
        .sidebar-nav .nav-link.active {
            background: var(--pos-primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .sidebar-nav .nav-link.active i { color: #ffffff; }
        .sidebar-nav .nav-link i { font-size: 1.1rem; width: 1.25rem; }
        
        .sidebar-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            padding: 1.5rem 1rem 0.5rem 1rem;
            font-weight: 700;
        }

        /* MAIN AREA */
        .main-area { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        /* TOPBAR (Glassmorphism effect) */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--pos-gray-200);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .topbar-title { font-weight: 800; font-size: 1.1rem; margin: 0; color: var(--pos-gray-900); letter-spacing: -0.01em; }
        
        .user-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--pos-gray-600);
            background: var(--pos-gray-100);
            padding: 0.4rem 0.8rem;
            border-radius: 50rem;
        }
        .role-badge {
            font-size: 0.65rem;
            padding: 0.25rem 0.6rem;
            border-radius: 50rem;
            background: var(--pos-primary-light);
            color: var(--pos-primary);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .content { padding: 2rem; flex: 1; }

        /* ================== KOMPONEN UI ================== */
        /* Card */
        .card {
            border: 1px solid var(--pos-gray-200);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            background: #fff;
            transition: box-shadow 0.3s ease;
        }
        .card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025); }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--pos-gray-200);
            font-weight: 700;
            padding: 1.25rem 1.5rem;
            border-radius: 1rem 1rem 0 0 !important;
        }
        .card-body { padding: 1.5rem; }

        /* Button */
        .btn {
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }
        .btn-primary {
            --bs-btn-bg: var(--pos-primary);
            --bs-btn-border-color: var(--pos-primary);
            --bs-btn-hover-bg: var(--pos-primary-dark);
            --bs-btn-hover-border-color: var(--pos-primary-dark);
            --bs-btn-active-bg: var(--pos-primary-dark);
            --bs-btn-active-border-color: var(--pos-primary-dark);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.3); }
        .btn-outline-primary {
            --bs-btn-color: var(--pos-primary);
            --bs-btn-border-color: var(--pos-primary);
            --bs-btn-hover-bg: var(--pos-primary);
            --bs-btn-hover-border-color: var(--pos-primary);
        }

        /* Table */
        .table > :not(caption) > * > * { padding: 1rem 1.25rem; vertical-align: middle; border-bottom-color: var(--pos-gray-200); }
        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--pos-gray-600);
            font-weight: 700;
            background: var(--pos-gray-50);
            border-bottom: 2px solid var(--pos-gray-200);
        }
        .table-hover tbody tr { transition: all 0.2s; }
        .table-hover tbody tr:hover { background-color: var(--pos-gray-50); transform: scale(1.002); }
        .text-money { text-align: right; font-variant-numeric: tabular-nums; }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid var(--pos-gray-200);
            padding: 0.6rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--pos-primary);
            box-shadow: 0 0 0 4px var(--pos-primary-light);
        }
        .form-label { font-weight: 600; font-size: 0.85rem; color: var(--pos-gray-900); }

        /* Stat Cards (Dashboard & Laporan) */
        .stat-card { padding: 1.5rem; border-radius: 1rem; }
        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--pos-gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--pos-gray-900);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 0.75rem;
            background: var(--pos-primary-light);
            color: var(--pos-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Empty State */
        .empty-state { text-align: center; padding: 4rem 1rem; color: var(--pos-gray-600); }
        .empty-state i { font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -280px; }
            .sidebar.open { left: 0; box-shadow: 0 0 40px rgba(0,0,0,0.1); }
            .content { padding: 1.25rem; }
            .topbar { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-box-seam-fill"></i>
            <span>{{ \App\Models\Setting::get('store_name', 'POS App') }}</span>
        </div>

        <nav class="sidebar-nav nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="sidebar-section">Master Data</div>

            @if(auth()->user()->role === 'admin')
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <i class="bi bi-tags-fill"></i> Kategori
                </a>
            @endif

            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box-fill"></i> Produk
            </a>

            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-people-fill"></i> Pelanggan
            </a>

            @if(auth()->user()->role === 'admin')
                <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <i class="bi bi-truck"></i> Supplier
                </a>
            @endif

            <div class="sidebar-section">Transaksi</div>

            @if(auth()->user()->role === 'admin')
                <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                    <i class="bi bi-arrow-down-square-fill"></i> Stok Masuk
                </a>
            @endif

            <a class="nav-link {{ request()->routeIs('sales.create') ? 'active' : '' }}" href="{{ route('sales.create') }}">
                <i class="bi bi-cart-plus-fill"></i> Kasir
            </a>

            <a class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <i class="bi bi-receipt"></i> Riwayat Penjualan
            </a>

            @if(auth()->user()->role === 'admin')
                <div class="sidebar-section">Lainnya</div>

                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="bi bi-bar-chart-line-fill"></i> Laporan
                </a>

                  <a class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                    <i class="bi bi-journal-text"></i> Log Aktivitas
                </a>

                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear"></i> Manajemen User
                </a>

                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear-fill"></i> Pengaturan
                </a>
            @endif
        </nav>
    </aside>

    {{-- ================= MAIN ================= --}}
    <div class="main-area">

        <header class="topbar">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="bi bi-list"></i>
            </button>

            <h1 class="topbar-title">@yield('title', 'Dashboard')</h1>

            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="user-chip">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span>{{ auth()->user()->name }}</span>
                    <span class="role-badge">{{ auth()->user()->role }}</span>
                </div>
                
                <a href="{{ route('profile.password') }}" class="text-decoration-none small text-muted ms-2" title="Ubah Password">
                    <i class="bi bi-key-fill me-1"></i> Ubah Password
                </a>

                <form method="POST" action="{{ route('logout') }}" class="ms-2">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline ms-1">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="content animate-content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>