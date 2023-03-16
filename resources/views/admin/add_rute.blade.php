@extends('layouts.master')
@section('title', 'Add Rute')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-6 col-md-6">
        <div class="card">
            <form action="rute-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Nama Kota"
                        required>
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
