@extends('layouts.master')

@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Persenan Gaji Driver
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="/pimpinan/persenan-gaji-add" class="btn btn-info ">Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mt-1">
        <div class="table-responsive">
            <table class="table">
                {{-- <caption>Data Bus</caption> --}}
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rute</th>
                        <th>Sopir Utama</th>
                        <th>Sopir Bantu</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listPersenan as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->from_city }} - {{ $row->to_city }}</td>
                            <td>{{ $row->sopir_utama }}%</td>
                            <td>{{ $row->sopir_bantu }}%</td>
                            <td>
                                {{-- <a class=" btn btn-sm btn-icon btn-info" href="/pimpinan/driver/persenan-info">
                                    <i class="fa-solid fa-circle-info"></i></a> --}}
                                <a class="btn btn-sm btn-icon btn-primary"
                                    href="/pimpinan/persenan-gaji-edit/{{ $row->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-sm btn-icon btn-danger"
                                    href="/pimpinan/driver/persenan-delete/{{ $row->id }}">
                                    <i class="fa-solid fa-trash-can"></i></a>
                                {{-- <a href="/pimpinan/ubah-persenan-gaji" class="btn btn-info mt-3">Ubah</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
