@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Detail Ruangan</h5>
                    <a href="{{ route('detail_ruangan.index') }}" class="btn btn-primary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('detail_ruangan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_ruangan" class="form-label">Nama Ruangan</label>
                            <select name="id_ruangan" class="form-select" required>
                                <option value="">Pilih Ruangan</option>
                                @foreach ($ruangan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Barang dalam Ruangan</label>
                            <table class="table table-bordered table-hover" id="barang-table">
                                <thead class="table-primary text-dark text-center">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="barang-row">
                                        <td>
                                            <select name="id_barang[]" class="form-select barang-select" required>
                                                <option value="">Pilih Barang</option>
                                                @foreach ($barang as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah_pinjam[]" class="form-control text-center" min="1" required>
                                        </td>
                                        <td>
                                            <input type="text" name="kondisi[]" class="form-control" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-barang"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <button type="button" class="btn btn-success btn-sm" id="add-barang"><i class="fas fa-plus"></i> Tambah Barang</button>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('add-barang').addEventListener('click', function () {
        let table = document.getElementById('barang-table').getElementsByTagName('tbody')[0];
        let newRow = document.querySelector('.barang-row').cloneNode(true);
        newRow.querySelectorAll("input, select").forEach(el => el.value = "");
        table.appendChild(newRow);
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-barang')) {
            let row = event.target.closest('tr');
            if (document.querySelectorAll('.barang-row').length > 1) {
                row.remove();
            } else {
                alert('Minimal satu barang harus ada!');
            }
        }
    });
});
</script>
@endsection
