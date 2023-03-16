@extends('layouts.master')
@section('title', 'Edit Data Karyawan')


@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card ">
            <form action="/pimpinan/data-karyawan-update/{{ $ListData->id }}" class="row g-2 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="fullname" class="form-label">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                        value="{{ $ListData->fullname }}" placeholder="Nama Lengkap" required>
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label">User Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ $ListData->username }}" placeholder="Username" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $ListData->email }}"
                        placeholder="Email" required>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="{{ $ListData->gender }}">{{ $ListData->gender }}</option>
                        @if ($ListData->gender == 'Laki-laki')
                            <option value="Perempuan">Perempuan</option>
                        @else
                            <option value="Laki-laki">Laki-laki</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">No Hp<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" value="{{ $ListData->phone }}" name="phone"
                        placeholder="Nomor Hp" required>
                </div>

                <div class="col-md-6">
                    <label for="Posistion" class="form-label">Jabatan<span class="text-danger">*</span></label>
                    <select class="form-select" id="position" name="position" required>
                        <option value="{{ $ListData->position }}">
                            @if ($ListData->position == 'Admin')
                                Admin
                            @else
                                Pegawai
                            @endif
                        </option>
                        @if ($ListData->position == 'Admin')
                            <option value="Pegawai">Pegawai</option>
                        @else
                            <option value="Admin">Admin</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="entry_year" class="form-label">Tahun Masuk</label>
                    <input type="text" class="form-control" id="entry_year" value="{{ $ListData->entry_year }}"
                        name="entry_year" placeholder="Tahun Masuk">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status Pegawai</label>
                    <select class="form-select" id="status" name="status" required>
                        @if ($ListData->status == 1)
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        @else
                            <option value="0" selected>Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2"> {{ $ListData->address }}</textarea>
                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-floppy-disk"></i>
                        Update</button>
                    <a href="/pimpinan/data-karyawan" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>


@endsection
