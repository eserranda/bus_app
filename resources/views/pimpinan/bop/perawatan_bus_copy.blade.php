@extends('layouts.master')
@section('title', 'BOP Perawatan Armada Bus')
{{-- @section('submenu', 'show') --}}

@section('content')


    <div class="d-flex my-2">
        <a href="/pimpinan/perawatan-armada-add" class="btn btn-info btn-sm">Tambah</a>
        <a href="/pimpinan/perawatan-armada-add-multiple" class="btn btn-warning btn-sm mx-2">Tambah Banyak</a>
        <button class="btn-sm border-0 btn-primary reload"> <i class="fa-solid fa-rotate"></i></button>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
        }
    </style>

    <div class="card">
        <div class="table-responsive m-2">
            <table class="table data_table" id="data_table">

                <thead>
                    <tr class="item-center">
                        {{-- <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                        </th> --}}
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- isi tabel -->



                    {{-- <td width="30px">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    </td> --}}
                    {{-- @foreach ($ListData as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->kode_transaksi }}</td>
                            <td>{{ $row->jenis_pengeluaran }}</td>
                            <td>{{ $row->harga }}</td>
                            <td>
                                @if ($row->status == false)
                                    <a class="btn btn-light text-danger btn-sm"
                                        onclick="deleteData('{{ $row->id }}', $(this).closest('tr').find('td:eq(2)').text())">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                    <a class="btn btn-light text-dark btn-sm"
                                        href="/pimpinan/perawatan-armada-edit/{{ $row->id }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <a class="btn btn-light text-primary btn-sm financial-save" data-toggle="tooltip"
                                        title="Input ke laporan Keuangan" onclick="financial_save('{{ $row->id }}')">
                                        <i class="fa-solid fa-file-medical"></i>
                                    </a>
                                @endif

                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data_perwatan_bus') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: '#',
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'kode_transaksi',
                        name: 'kode_transaksi'
                    },
                    {
                        data: 'jenis_pengeluaran',
                        name: 'jenis_pengeluaran'
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        searchable: true
                    },
                    {
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    },

                ],
                language: {
                    searchPlaceholder: 'Cari Data',
                },
            });
        });



        function deleteData(id, kode_transaksi) {
            swal({
                title: "Hapus data " + kode_transaksi + " ?",
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "/pimpinan/perawatan-armada-delete/" + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            swal({
                                title: 'Succes!',
                                icon: "success",
                                text: 'Data berhasil dihapus',
                                timer: 1000,
                                timerProgressBar: true,
                                buttons: false,
                            }).then(function() {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
                // else {
                // swal({
                // text: "Data batal dihapus!",
                // buttons: false,
                // });
                // }
            });
        }


        function financial_save(id) {
            swal({
                title: "Pastikan data sudah benar!",
                text: "Data yang sudah di input ke Laporan Keuangan tidak akan bisa di Ubah/Edit lagi !",
                icon: "info",
                buttons: true,
                buttons: ["Batal", "OK, Saya mengerti"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('financial-save') }}',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            swal({
                                title: "Success!",
                                text: 'Data berhasil ditambahkan ke Laporan Keuangan',
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then(function() {
                                window.location.reload();
                            });
                        },

                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
                // else {
                // swal("Your imaginary file is safe!");
                // }
            });
        }

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('.reload').click(function() {
            window.location.reload();
        });
    </script>

@endsection
