@extends('layouts.master')

@section('content')
    <div class="my-2">
        <a href="add-rute" class="btn btn-info">Tambah</a>
    </div>
    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card mt-1 col-lg-6">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rute</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruteList as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->city }}</td>
                            <td>
                                <a class="btn-sm btn-danger" href="/admin/rute-delete/{{ $row->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                                <a class="btn-sm btn-primary" href="/admin/rute-edit/{{ $row->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
