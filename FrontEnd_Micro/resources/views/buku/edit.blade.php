@extends('layouts.template')

@section('content')
<style>
    /* Pop-style Title */
    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: #8B4513;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        display: inline-block;
        background: linear-gradient(145deg, #fff, #f0f0f0);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.2);
        padding: 15px 40px;
        border-radius: 15px;
        animation: popTitle 0.6s ease-out;
    }

    @keyframes popTitle {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .card-3d {
        background: #fff;
        margin-top: 50px;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 30px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card-3d:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    label {
        font-weight: bold;
        color: #444;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 14px;
        font-size: 15px;
        transition: 0.3s ease;
    }

    .form-control:focus {
        border-color: #5c2f0b;
        box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.15);
    }

    .btn-primary {
        background-color: #5c2f0b;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #5c2f0b;
        transform: scale(1.05);
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 25px;
    }
</style>

<div class="container d-flex flex-column align-items-center justify-content-center">
    {{-- <div class="page-title">📘 Edit Buku</div> --}}

    <div class="card-3d w-100" style="max-width: 600px;">
        <form method="POST" action="{{ url('/buku/' . $buku['buku_id']) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ $buku['judul'] }}" required>
            </div>

            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="form-control" value="{{ $buku['penulis'] }}" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" class="form-control" value="{{ $buku['stok'] }}" required>
            </div>
            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori['kategori_id'] }}" {{ $kategori['kategori_id'] == $buku['kategori_id'] ? 'selected' : '' }}>
                            {{ $kategori['kategori_nama'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('/buku') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
