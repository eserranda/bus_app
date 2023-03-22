@extends('layouts.master')

@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Tambah Data Rute
                    </h2>
                </div>
                <!-- Page title actions -->
            </div>
        </div>
    </div>
@endsection

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
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus mx-1"></i>
                        Tambah</button>
                    <a href="/admin/data-rute" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left mx-1"></i>
                        Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
