@extends('layouts.template')

@section('content')
<style>
    /* Pop-style Title */
    .card-3d {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
    <div class="card-3d w-100" style="max-width: 600px;">
        <form method="POST" action="{{ url('/kategori/' . $kategoris['kategori_id']) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="judul">Kode Kategori</label>
                <input type="text" id="kategori_kode" name="kategori_kode" class="form-control" value="{{ $kategoris['kategori_kode'] }}" required>
            </div>

            <div class="form-group">
                <label for="penulis">Nama Kategori</label>
                <input type="text" id="Kategori_nama" name="kategori_nama" class="form-control" value="{{ $kategoris['kategori_nama'] }}" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"> Simpan</button>
                <a href="{{ url('/kategori') }}" class="btn btn-secondary"> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
