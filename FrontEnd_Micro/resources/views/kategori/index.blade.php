@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card-header">
        <div class="card-tools">
            <a href="{{ url('/kategori/create') }}" class="btn btn-primary">+ Tambah Kategori</a>
        </div>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori['kategori_kode'] }}</td>
                    <td>{{ $kategori['kategori_nama'] }}</td>
                    <td>
                        <a href="{{ url('/kategori/' . $kategori['kategori_id']) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ url('/kategori/' . $kategori['kategori_id'] . '/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('/kategori/' . $kategori['kategori_id']) }}" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-url="{{ url('/kategori/' . $kategori['kategori_id']) }}">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PAGINATION DUMMY --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $kategoris->links() }}
    </div>
</div>

<style>
.container-fluid {
    background-color: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    /* transition: all 0.3s ease-in-out; */
}

.card-header h4 {
    font-weight: bold;
    color: #5c2f0b;
}

.table tbody tr {
    transition: all 0.2s ease-in-out;
    border-bottom: 1px solid #ccc;
    min-height: 50px;
}

.table tbody tr:last-child {
    border-bottom: none;
}

.table {
    background-color: #ffffff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.table th, .table td {
    text-align: center;
    vertical-align: middle !important;
    padding: 15px;
}

.table thead th {
    background-color: #5c2f0b;
    color: white;
    font-size: 1rem;
    border: none;
}

.btn-info {
    background-color: #17a2b8;
    color: #fff;
    border: none;
    padding: 8px 14px;
    font-weight: 500;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-primary {
    background: linear-gradient(145deg, #5c2f0b);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: bold;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(139, 69, 19, 0.3);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(145deg, #5c2f0b);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(139, 69, 19, 0.5);
}

.btn-warning, .btn-danger {
    border: none;
    font-weight: 500;
    border-radius: 10px;
    padding: 8px 14px;
    transition: all 0.2s ease;
}

.btn-warning {
    background-color: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
}

.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.pagination .page-link {
    padding: 8px 14px;
    background-color: #fff;
    border: 1px solid #8B4513;
    color: #8B4513;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #8B4513;
    color: #fff;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-delete").forEach(function(button) {
        button.addEventListener("click", function () {
            let form = this.closest("form");
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data kategori akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
