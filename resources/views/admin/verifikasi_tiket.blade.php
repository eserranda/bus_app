@extends('layouts.master')
@section('title', 'Verifikasi Tiket')

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
                        <th>Nomor Tiket</th>
                        <th>Nama</th>
                        <th>Rute</th>
                        <th>Bus</th>
                        <th>Nomor Kursi</th>
                        <th>Tgl Berangkat</th>
                        <th>Total Harga</th>
                        <th>Pembayaran</th>
                        <th>Ket.</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>INV250223-001</td>
                        <td>Eliaser Randa</td>
                        <td>Makassar - Toraja</td>
                        <td>Sleeper</td>
                        <td>12,13</td>
                        <td>25-02-2023</td>
                        <td>Rp500.000</td>
                        <td>Bank Tranfer</td>
                        <td>Lunas</td>
                        <td><button class="btn btn-info">Detail</button></td>
                    </tr>
                    {{-- @foreach ($busList as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->type }}</td>
                            <td>{{ $row->plat }}</td>
                            <td>{{ $row->bus_seats }}</td>
                            <td>{{ $row->description }}</td>
                            <td>
                                <a class="btn-sm btn-info" href="/admin/bus-info/{{ $row->id }}"><i
                                        class="fa-solid fa-circle-info"></i></a>
                                <a class="btn-sm btn-primary" href="/admin/bus-edit/{{ $row->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn-sm btn-danger" href="/admin/bus-delete/{{ $row->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

@endsection
