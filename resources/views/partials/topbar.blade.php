<header class="pos-topbar">
    <div class="fw-semibold">@yield('title', 'Dashboard')</div>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('profile.password') }}" class="text-decoration-none text-muted small d-none d-md-inline">
            <i class="bi bi-key"></i> Ubah Password
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="text-end d-none d-md-block">
                <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                <div class="text-muted" style="font-size:.72rem">{{ strtoupper(auth()->user()->role) }}</div>
            </div>
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                 style="width:36px;height:36px">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-right"></i></button>
        </form>
    </div>
</header>