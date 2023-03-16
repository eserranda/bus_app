@extends('layouts.master')
@section('title', 'Data Driver')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="driver-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="fullname" placeholder="Nama" required>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Driver<span class="text-danger">*</span></label>
                    <select class="form-select" id="driver_type" name="driver_type" required>
                        <option value="Utama">Sopir Utama</option>
                        <option value="Bantu">Sopir Bantu</option>
                        <option value="Kondektur">Kondektur</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Nomor Hp<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Hp"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="entry_year" class="form-label">Tahun masuk</label>
                    <input type="number" class="form-control" id="entry_year" name="entry_year" placeholder="Tahun">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                </div>

                <div class="col-md-6">
                    <label for="formFile" class="form-label">Foto</label>
                    <input class="form-control" type="file" name="images" id="formFile">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus"></i> Tambah</button>
                    <a href="/admin/data-driver" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>

@endsection
