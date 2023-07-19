@extends('layouts.master')
@section('title', 'Tambah Data Karyawan')


@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/data-karyawan-save" class="row g-2 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap"
                        required>
                </div>

                {{-- <div class="col-md-6">
                    <label for="username" class="form-label">User Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        required>
                </div> --}}

                <div class="col-md-6">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" selected disabled>Pilih Gender</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                {{-- <div class="col-md-6">
                    <label for="phone" class="form-label">No Hp<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Hp"
                        required>
                </div> --}}

                <div class="col-md-6">
                    <label for="role" class="form-label">Jabatan<span class="text-danger">*</span></label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" selected disabled>Pilih Jabatan</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                </div>

                {{-- <div class="col-md-6">
                    <label for="entry_year" class="form-label">Tahun Masuk</label>
                    <input type="text" class="form-control" id="entry_year" name="entry_year" placeholder="Tahun Masuk">
                </div> --}}

                {{-- <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                </div> --}}


                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-floppy-disk"></i>
                        Simpan</button>
                    <a href="/pimpinan/data-karyawan" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>


@endsection
