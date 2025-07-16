@extends('layouts.template')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: #5c2f0b;
        left: 20%; 
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

    .container {
        margin-top: 50px;
        max-width: 700px;
    }

    .card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1),
                    -10px -10px 20px rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .card h4 {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }

    .card p {
        font-size: 18px;
        color: #555;
        margin-bottom: 10px;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: #fff;
    }
</style>

<div class="container">
    <div class="card p-5 shadow">
        <p><strong>Kode Kategori :</strong> {{ $kategoris['kategori_kode'] }}</p>
        <p><strong>Nama Kategori :</strong> {{ $kategoris['kategori_nama'] }}</p>
        <a href="{{ url('/kategori') }}" class="btn btn-secondary mt-3">← Kembali</a>
    </div>
</div>
@endsection
