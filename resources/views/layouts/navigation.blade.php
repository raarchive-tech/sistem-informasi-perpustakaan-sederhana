<aside class="sidebar">

    {{-- Logo Readora --}}
    <a href="{{ route('dashboard') }}" class="brand">
        <img
            src="{{ asset('images/readora-logo.png') }}"
            alt="Readora"
        >
    </a>

    {{-- Label menu utama --}}
    <div class="sidebar-label">MENU UTAMA</div>

    {{-- Navigasi --}}
    <nav class="sidebar-menu">

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="menu-icon">⌂</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('categories.index') }}"
           class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <span class="menu-icon">▤</span>
            <span>Kategori Buku</span>
        </a>

        <a href="{{ route('books.index') }}"
           class="sidebar-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
            <span class="menu-icon">▣</span>
            <span>Data Buku</span>
        </a>

        <a href="{{ route('members.index') }}"
           class="sidebar-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <span class="menu-icon">♙</span>
            <span>Data Anggota</span>
        </a>

        <a href="{{ route('borrowings.index') }}"
           class="sidebar-link {{ request()->routeIs('borrowings.*') ? 'active' : '' }}">
            <span class="menu-icon">⇄</span>
            <span>Peminjaman</span>
        </a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('users.index') }}"
               class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="menu-icon">♧</span>
                <span>Manajemen User</span>
            </a>
        @endif

    </nav>

    {{-- Bagian bawah sidebar --}}
    <div class="sidebar-bottom">

        {{-- Gambar pengganti Keep Reading --}}
        <div class="sidebar-image">
            <img
                src="{{ asset('images/image.png') }}"
                alt="Ilustrasi Readora"
            >
        </div>

        {{-- Profil pengguna --}}
        <div class="sidebar-user">

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="user-info">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ ucfirst(auth()->user()->role) }}</small>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button" title="Logout">
                    ↪
                </button>
            </form>

        </div>
    </div>

</aside>
