<x-app-layout>
    <x-slot name="header">
        <div class="heading-content">
            <div>
                <h1>Dashboard</h1>
                <p>Selamat datang di Sistem Informasi Perpustakaan.</p>
            </div>

            <div class="date-badge">
                <span>☼</span>
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="dashboard-container">

        {{-- Welcome Banner --}}
        <section class="welcome-banner">
            <div class="welcome-text">
                <span class="welcome-tag">LIBRARY MANAGEMENT SYSTEM</span>

                <h2>
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>

                <p>
                    Selamat datang kembali. Kelola data perpustakaan
                    dan pantau aktivitas peminjaman buku dengan mudah.
                </p>

                <a href="{{ route('books.index') }}" class="welcome-button">
                    Lihat Koleksi Buku <span>→</span>
                </a>
            </div>

            <div class="welcome-illustration">
                <div class="book-stack">
                    <div class="book book-one">READ</div>
                    <div class="book book-two">LEARN</div>
                    <div class="book book-three">GROW</div>
                </div>
                <div class="illustration-circle">✦</div>
            </div>
        </section>

        {{-- Statistics --}}
        <div class="section-heading">
            <div>
                <h3>Ringkasan Perpustakaan</h3>
                <p>Informasi statistik perpustakaan saat ini.</p>
            </div>
        </div>

        <section class="stats-grid">

            <div class="stat-card stat-purple">
                <div class="stat-top">
                    <span class="stat-icon">▣</span>
                    <span class="stat-label">KOLEKSI</span>
                </div>
                <h2>{{ $totalBooks }}</h2>
                <p>Total Judul Buku</p>
                <div class="stat-decoration">▣</div>
            </div>

            <div class="stat-card stat-blue">
                <div class="stat-top">
                    <span class="stat-icon">▤</span>
                    <span class="stat-label">PERSEDIAAN</span>
                </div>
                <h2>{{ $totalStock }}</h2>
                <p>Total Stok Buku</p>
                <div class="stat-decoration">▤</div>
            </div>

            <div class="stat-card stat-pink">
                <div class="stat-top">
                    <span class="stat-icon">♙</span>
                    <span class="stat-label">PENGGUNA</span>
                </div>
                <h2>{{ $totalMembers }}</h2>
                <p>Total Anggota</p>
                <div class="stat-decoration">♙</div>
            </div>

            <div class="stat-card stat-yellow">
                <div class="stat-top">
                    <span class="stat-icon">⇄</span>
                    <span class="stat-label">AKTIVITAS</span>
                </div>
                <h2>{{ $totalBorrowed }}</h2>
                <p>Buku Sedang Dipinjam</p>
                <div class="stat-decoration">⇄</div>
            </div>

        </section>

        {{-- Quick Access --}}
        <div class="section-heading quick-heading">
            <div>
                <h3>Akses Cepat</h3>
                <p>Pilih menu untuk mengelola perpustakaan.</p>
            </div>
        </div>

        <section class="quick-grid">

            <a href="{{ route('books.index') }}" class="quick-card">
                <div class="quick-icon quick-purple">📚</div>
                <div>
                    <strong>Data Buku</strong>
                    <p>Lihat dan kelola koleksi buku.</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>

            <a href="{{ route('categories.index') }}" class="quick-card">
                <div class="quick-icon quick-blue">📂</div>
                <div>
                    <strong>Kategori</strong>
                    <p>Kelola kategori koleksi buku.</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>

            <a href="{{ route('members.index') }}" class="quick-card">
                <div class="quick-icon quick-pink">👥</div>
                <div>
                    <strong>Data Anggota</strong>
                    <p>Lihat informasi anggota perpustakaan.</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>

            <a href="{{ route('borrowings.index') }}" class="quick-card">
                <div class="quick-icon quick-yellow">📖</div>
                <div>
                    <strong>Peminjaman</strong>
                    <p>Pantau transaksi peminjaman buku.</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>

        </section>

        <footer class="dashboard-footer">
            <span>© {{ date('Y') }} Readora </span>
            <span>Read More, Learn More ✦</span>
        </footer>

    </div>
</x-app-layout>
