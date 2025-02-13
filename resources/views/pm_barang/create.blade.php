@extends('layouts.admin')
@section('content')
<h4 class="mb-0 text-uppercase pb-3">Peminjaman Barang</h4>
<hr>
<div class="col-12 col-xl-12">
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Data Peminjam</h5>

            <div id="error-message" class="alert alert-warning" style="display: none;"></div>
            <form class="row g-3" method="POST" action="{{ route('pm_barang.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-5">
                    <label class="form-label">Kode Peminjaman</label>
                    <input type="text" class="form-control" value="{{ $kodePeminjaman }}" disabled>
                    <input type="hidden" name="code_peminjaman" value="{{ $kodePeminjaman }}">
                </div>

                <div class="col-md-7">
                    <label class="form-label">Nama Peminjam</label>
                    <select name="id_anggota" class="form-control">
                        @foreach ($anggota as $data)
                            <option value="{{ $data->id }}">{{ $data->nama_peminjam }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Jenis Kegiatan</label>
                    <input type="text" class="form-control" name="jenis_kegiatan" placeholder="Jenis kegiatan" required>
                </div>

                <hr>
                <h5>Detail Peminjaman Barang</h5>

                <div id="list-barang">
                    <div class="row mb-2 barang-entry">
                        <div class="col-md-8">
                            <select class="form-select barang-select" name="id_barang[]" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="jumlah_pinjam[]" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-barang">Hapus</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-barang" class="btn btn-secondary">Tambah Barang</button>

                <hr>

                <div class="col-md-6">
                    <label class="form-label">Nama Ruangan</label>
                    <select name="id_ruangan" class="form-control">
                        @foreach ($ruangan as $data)
                            <option value="{{ $data->id }}">{{ $data->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" name="tanggal_peminjaman" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Waktu Peminjaman</label>
                    <input type="time" class="form-control" name="waktu_peminjaman" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Dokumentasi</label>
                    <input type="file" class="form-control" name="cover">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let listBarang = document.getElementById("list-barang");
                    let addBarangButton = document.getElementById("add-barang");
                    let errorDiv = document.getElementById("error-message");

                    function initializeSelect2() {
                        $(".barang-select").select2({
                            theme: "bootstrap-5",
                            width: "100%",
                            placeholder: "Pilih Barang",
                            allowClear: true,
                        });
                    }

                    function addBarangEntry() {
                        let newEntry = document.createElement("div");
                        newEntry.classList.add("row", "mb-2", "barang-entry");
                        newEntry.innerHTML = `
                            <div class="col-md-8">
                                <select class="form-select barang-select" name="id_barang[]" required>
                                    ${getBarangOptions()}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="jumlah_pinjam[]" value="1" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-barang">Hapus</button>
                            </div>
                        `;

                        listBarang.appendChild(newEntry);
                        initializeSelect2();

                        newEntry.querySelector(".remove-barang").addEventListener("click", function () {
                            newEntry.remove();
                        });
                    }

                    function getBarangOptions() {
                        return document.querySelector(".barang-select").innerHTML;
                    }

                    function isBarangDuplicate(value, currentSelect) {
                        return [...document.querySelectorAll(".barang-select")].some(
                            (select) => select !== currentSelect && select.value === value
                        );
                    }

                    document.addEventListener("change", function (event) {
                        if (event.target.classList.contains("barang-select")) {
                            let selectedValue = event.target.value;
                            if (isBarangDuplicate(selectedValue, event.target)) {
                                alert("Barang sudah dipilih! Silakan pilih barang lain.");
                                event.target.value = "";
                            }
                        }
                    });

                    addBarangButton.addEventListener("click", addBarangEntry);

                    initializeSelect2();
                });
            </script>

        </div>
    </div>
</div>
@endsection
