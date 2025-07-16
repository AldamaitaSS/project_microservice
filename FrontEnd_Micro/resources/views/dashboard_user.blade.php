@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
<style>
    body {
        background: #f8f9fb;
    }

    .dashboard-header {
        font-size: 2.2rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 2rem;
        text-align: center;
    }

    .search-box {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .search-box form {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 15px;
        padding: 10px 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .search-box input[type="text"] {
        border: none;
        outline: none;
        padding: 10px 15px;
        border-radius: 10px;
        width: 280px;
        font-size: 1rem;
    }

    .search-box button {
        background: linear-gradient(135deg, #d1c4ba);
        border: none;
        color: #5c2f0b;
        padding: 10px 20px;
        margin-left: 10px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(248, 251, 255, 0.4);
        transition: all 0.3s ease;
    }

    .search-box button:hover {
        transform: scale(1.05);
    }

    .custom-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .custom-table th {
        background: #5c2f0b;
        color: white;
        text-align: center;
        font-weight: 600;
    }

    .custom-table td, .custom-table th {
        padding: 15px;
        vertical-align: middle;
        text-align: center;
    }

    .custom-table tbody tr:hover {
        background-color: #f1f7ff;
        
    }

    .alert-warning {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        font-weight: 500;
        border-radius: 10px;
        padding: 12px 20px;
        text-align: center;
    }
</style>

<div class="container py-5">
    {{-- <div class="dashboard-header">📚 Pencarian Buku</div> --}}

    <div class="search-box">
        <form method="get" action="{{ route('dashboard') }}">
            <input type="text" name="q" placeholder="🔍 Cari judul buku..." value="{{ request('q') }}">
            <button type="submit">Cari</button>
        </form>
    </div>

    @if (!empty($buku) && count($buku) > 0)
        <div class="table-responsive">
            <table class="table table-bordered custom-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <td>{{ $item['judul'] }}</td>
                            <td>{{ $item['stok'] }}</td>
                            <td>
                                <form action="{{ url('/pinjam') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $item['buku_id'] }}">
                                <input type="hidden" name="tanggal_pinjam" value="{{ now()->toDateString() }}">
                                <input type="hidden" name="tangga_kembali" value="{{ now()->addDays(7)->toDateString() }}">
                                <button class="btn btn-sm btn-success" {{ $item['stok'] == 0 ? 'disabled' : '' }}>📖 Pinjam</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(request('q'))
        <div class="alert alert-warning">
            ⚠️ Buku tidak ditemukan untuk kata kunci: <strong>{{ request('q') }}</strong>
        </div>
    @endif
</div>
@endsection
