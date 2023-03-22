@extends('layouts.master')


@section('content')
    <div class="my-2">
        <a href="add-bus" class="btn btn-info">Tambah</a>
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
                        <th>Jenis Bus</th>
                        <th>Nomor Plat</th>
                        <th>Jumlah Kursi</th>
                        <th>Keterangan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($busList as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->type }}</td>
                            <td>{{ $row->plat }}</td>
                            <td>{{ $row->bus_seats }}</td>
                            <td>{{ $row->description }}</td>
                            <td>
                                <a class="btn btn-icon btn-sm  btn-info" href="/admin/bus-info/{{ $row->id }}">
                                    <i class="fa-solid fa-circle-info"></i></a>
                                <a class="btn btn-icon btn-sm  btn-primary" href="/admin/bus-edit/{{ $row->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-icon btn-sm  btn-danger" href="/admin/bus-delete/{{ $row->id }}">
                                    <i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
