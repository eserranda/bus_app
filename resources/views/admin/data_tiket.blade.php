@extends('layouts.master')
@section('title', ' Data Tiket')
{{-- @section('submenu', 'show') --}}

@section('content')
    <div class="my-2">
        <a href="/admin/add-tiket" class="btn btn-info">Tambah</a>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Tiket</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kota Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tiketList as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->no_ticket }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->time }}</td>
                            <td>{{ $row->from_city }}</td>
                            <td>{{ $row->to_city }}</td>
                            <td>{{ $row->price }}</td>
                            <td>
                                <a class="btn-sm btn-info" href="/admin/tiket-info/{{ $row->id }}"><i
                                        class="fa-solid fa-circle-info"></i></a>
                                <a class="btn-sm btn-primary" href="/admin/tiket-edit/{{ $row->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn-sm btn-danger" href="/admin/tiket-delete/{{ $row->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
