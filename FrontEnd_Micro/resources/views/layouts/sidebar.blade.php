<style>
    /* Sidebar utama */
    .sidebar {
        /* background: linear-gradient(135deg, #5c2f0b, #A0522D); */
        background: linear-gradient(135deg, #d1c4ba);
        height: 100vh;
        width: 250px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        padding: 20px 15px;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
        z-index: 100;
    }

    /* Header Logo */
    .logo-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header-text h4 {
        font-size: 20px;
        font-weight: bold;
        color: #5c2f0b;
        margin: 0;
    }

    .header-text span {
        font-size: 14px;
        color: #5c2f0b;
    }

    /* User Panel */
    .user-panel {
        text-align: center;
        margin-bottom: 25px;
    }

    .user-panel .profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #5c2f0b;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        /* transition: transform 0.3s ease; */
    }

    .user-panel .profile-img:hover {
        transform: scale(1.05);
    }

    .user-panel .info {
        margin-top: 10px;
        font-weight: bold;
        color: #5c2f0b;
    }

    /* Nav Link Styling */
    .nav-sidebar .nav-item {
        margin-bottom: 10px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 500;
        color: #5c2f0b !important;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .nav-link i {
        margin-right: 10px;
        font-size: 18px;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #5c2f0b;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: #D2B48C !important;
        color: #5c2f0b !important;
        font-weight: bold;
        box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.2);
    }

    /* Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
    }
</style>

<div class="sidebar">
    <!-- Logo Header -->
    <div class="logo-header">
        <div class="header-text">
            <h4>Pinjamlah Buku</h4>
            <span>Disini!</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
            <!-- Dashboard -->
              
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ ($activeMenu ?? '') == 'dashboard' ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>

            <!-- Menu Khusus Admin -->
            @if(session('level_id') == 1)
                <li class="nav-item">
                    <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu ?? '') == 'kategori' ? 'active' : '' }}">
                        <i class="fas fa-tags nav-icon"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/buku') }}" class="nav-link {{ ($activeMenu ?? '') == 'buku' ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Daftar Buku</p>
                    </a>
                </li>
                <!-- Peminjaman -->
                <li class="nav-item">
                    <a href="{{ url('/pinjam') }}" class="nav-link {{ ($activeMenu ?? '') == 'pinjam' ? 'active' : '' }}">
                        <i class="fas fa-book-reader nav-icon"></i>
                        <p>peminjaman</p>
                    </a>
                </li>
            @endif

            {{-- @php
                dd(session()->all());
            @endphp --}}
            <!-- Riwayat -->
            @if(session('level_id') == 2)
                <li class="nav-item">
                    <a href="{{ url('/riwayat') }}" class="nav-link {{ ($activeMenu ?? '') == 'riwayat' ? 'active' : '' }}">
                        <i class="fas fa-history nav-icon"></i>
                        <p>Riwayat</p>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
