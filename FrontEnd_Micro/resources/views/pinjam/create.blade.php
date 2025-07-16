@extends('layouts.template')

@section('title', 'Tambah Peminjaman')

@section('content')
<style>
    .card-form {
        max-width: 600px;
        margin: 40px auto;
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        border-radius: 15px;
        padding: 30px;
        transition: 0.3s ease-in-out;
    }

    .card-form:hover {
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.4);
        transform: translateY(-5px);
    }

    .card-form h1 {
        font-size: 2.2rem;
        color: #8B4513;
        font-weight: bold;
        text-align: center;
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-success {
        background-color: #8B4513;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-success:hover {
        background-color: #A0522D;
        transform: scale(1.03);
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 10px 20px;
        margin-left: 10px;
    }
</style>

<div class="card-form">
    <h1>📘 Tambah Peminjaman</h1>
    <form action="{{ url('/pinjam') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="buku_id">Pilih Buku</label>
            <select name="buku_id" class="form-control">
                @foreach ($bukus as $buku)
                <option value="{{ $buku['buku_id'] }}">{{ $buku['judul'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
        </div>

        <div class="form-group">
            <label for="tanggal_kembali">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" required>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ url('/buku') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

