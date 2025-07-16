@extends('layouts.template')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    .mb-3 {
        color: #5c2f0b;
        font-weight: 600;
        font-size: 20px
    }

    .custom-table {
        background: #fff;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 1rem;
        overflow: hidden;
    }

    .custom-table th {
        background: linear-gradient(45deg, #5c2f0b);
        color: white;
        font-weight: 600;
        padding: 12px;
        text-align: center;
    }

    .custom-table td {
        padding: 10px;
        text-align: center;
        color: #333;
    }

    .custom-table tbody tr:nth-child(even) {
        background: #f9f3ed;
    }

    .custom-table tbody tr:hover {
        background: #f1e7db;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .badge.bg-primary {
        background-color: #5c2f0b;
        color: #fff;
    }

    .badge.bg-success {
        background-color: #a0522d;
        color: #fff;
    }
</style>

<div class="container py-4">

    <div class="card-3d">
        <h4 class="mb-3">Pengguna Baru</h4>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentUsers as $user)
                        <tr>
                            <td>{{ $user['nama'] }}</td>
                            <td>{{ $user['username'] }}</td>
                            <td>
                                <span class="badge bg-{{ $user['level_id'] == 1 ? 'primary' : 'success' }}">
                                    {{ $user['level_id'] == 1 ? 'Admin' : 'User' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Tidak ada data pengguna</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-3d">
        <h4 class="mb-3">Peminjaman Terbaru</h4>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPinjam as $pinjam)
                        <tr>
                            <td>{{ $pinjam['nama_user'] ?? '-' }}</td>
                            <td>{{ $pinjam['judul_buku'] ?? '-' }}</td>
                            <td>{{ $pinjam['tanggal_pinjam'] ?? '-' }}</td>
                            <td>{{ $pinjam['tangga_kembali'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">Tidak ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
