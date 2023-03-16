@extends('layouts.master')
@section('title', 'Edit Driver')
@section('submenu', 'show')

@section('content')
    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/driver-update/{{ $dataDriver->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="fullname" placeholder="Nama"
                        value="{{ $dataDriver->fullname }}" required>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="{{ $dataDriver->gender }}">{{ $dataDriver->gender }}</option>
                        @if ($dataDriver->gender == 'Laki-laki')
                            <option value="Perempuan">Perempuan</option>
                        @else
                            <option value="Laki-laki">Laki-laki</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Driver<span class="text-danger">*</span></label>
                    <select class="form-select" id="driver" name="driver_type" required>
                        <option value="{{ $dataDriver->driver_type }}" selected>{{ $dataDriver->driver_type }}</option>
                        @if ($dataDriver->driver_type == 'Utama')
                            <option value="Bantu">Bantu</option>
                            <option value="Kondektur">Kondektur</option>
                        @elseif($dataDriver->driver_type == 'Bantu')
                            <option value="Utama">Utama</option>
                            <option value="Kondektur">Kondektur</option>
                        @elseif($dataDriver->driver_type == 'Kondektur')
                            <option value="Utama">Utama</option>
                            <option value="Bantu">Bantu</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Nomor Hp<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Hp"
                        value="{{ $dataDriver->phone }}" required>
                </div>

                <div class="col-md-6">
                    <label for="entry_year" class="form-label">Tahun masuk</label>
                    <input type="number" class="form-control" id="entry_year" name="entry_year" placeholder="Tahun"
                        value="{{ $dataDriver->entry_year }}">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status Driver</label>
                    <select class="form-select" id="status" name="status" required>
                        @if ($dataDriver->status == 1)
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        @else
                            <option value="0" selected>Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        @endif
                    </select>

                </div>

                <div class="col-md-6">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2">{{ $dataDriver->address }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="formFile" class="form-label">Foto</label>
                    <input class="form-control" type="file" name="images" id="formFile">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-floppy-disk"></i>
                        Update</button>
                    <a href="/pimpinan/data-driver" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>
                </div>
            </form>
        </div>
    </div>

@endsection
