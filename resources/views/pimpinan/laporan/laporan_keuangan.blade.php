@extends('layouts.master')
@section('title', 'Laporan Keuangan')
{{-- @section('submenu', 'show') --}}

@section('content')

    <div class="my-2">
        <button class="btn btn-info add">Add</button>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="table-responsive m-2">
            <table class="table data-table" id="table-data">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Keterangan</th>
                        <th>Debet </th>
                        <th>Credit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($DataKeuangan as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->kode_transaksi }}</td>
                            <td>{{ $row->keterangan }} </td>
                            <td>{{ $row->debet }}</td>
                            <td>{{ $row->credit }}</td>
                            <td>{{ $row->total_dana }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">Total:</th>
                        <th>{{ $TotalDebet }}</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align:right">Total Credit :</th>
                        <th>{{ $TotalCredit }}</th>
                    </tr>
                    <tr>
                        <th colspan="6" style="text-align:right">Saldo Per/Tgl {{ $DateToday }}:</th>
                        <th>{{ $Total }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#table-data').DataTable();
        });
    </script>
@endsection
