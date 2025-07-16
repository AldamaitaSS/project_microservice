@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="card-header">
        {{-- <h3 class="card-title">{{ $page->title }}</h3> --}}
        {{-- <div class="card-tools">
            <a href="{{ url('/pinjam/create') }}" class="btn btn-primary mb-3">+ Tambah Peminjaman</a>
        </div> --}}
    </div>
    {{-- <h1>Daftar Buku</h1> --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
    @forelse($riwayat as $item)
        <tr>
            <td>{{ $item['judul'] }}</td>
            <td>{{ $item['tanggal_pinjam'] }}</td>
            <td>{{ $item['tanggal_kembali'] ?? '-' }}</td>
            <td>{{ $item['status'] }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">Belum ada riwayat peminjaman.</td>
        </tr>
    @endforelse
</tbody>
    </table>
    </table>
    {{-- PAGINATION DUMMY --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $riwayat->links() }}
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
    background: linear-gradient(145deg, #8B4513, #5c2f0b);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: bold;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(139, 69, 19, 0.3);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(145deg, #5c2f0b, #3e2007);
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
    border: 1px solid #5c2f0b;
    color: #5c2f0b;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #5c2f0b;
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
