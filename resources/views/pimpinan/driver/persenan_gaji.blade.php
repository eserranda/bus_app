@extends('layouts.master')
@section('title', 'Persenan Gaji')
{{-- @section('submenu', 'show') --}}

@section('content')
    <div class="my-2">
        <a href="persenan-gaji-add" class="btn btn-info">Tambah</a>
    </div>

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
                                <a class="btn-sm btn-info" href="/pimpinan/driver/persenan-info"><i
                                        class="fa-solid fa-circle-info"></i></a>
                                <a class="btn-sm btn-primary" href="/pimpinan/persenan-gaji-edit/{{ $row->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn-sm btn-danger" href="/pimpinan/driver/persenan-delete/{{ $row->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                                {{-- <a href="/pimpinan/ubah-persenan-gaji" class="btn btn-info mt-3">Ubah</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
