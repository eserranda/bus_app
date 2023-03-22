@extends('layouts.master')
{{-- @section('submenu', 'show') --}}

@push('headcss')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.3/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Panjar Driver
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="/pimpinan/panjar-add" class="btn btn-primary   d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <style>
        .dataTables_wrapper {
            margin-top: 20px;
            margin-right: 20px;
            margin-bottom: 20px;
            margin-left: 20px;
        }
    </style>

    <div class="d-flex align-items-center mb-2 col-md-5">

        <button class="btn btn-primary btn-icon reload"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select mx-2" id="filter" aria-label="Default select example">
            <option selected disabled>Filter Data</option>
            <option value="2">Lunas/Belum tercatat LK.</option>
            <option value="0">Belum Lunas/Belum tercatat LK.</option>
            <option value="1">Belum Lunas/Sudah tercatat LK.</option>
            <option value="3">Arsip</option>
            <option value="all_data">Tampilkan Semua</option>
        </select>

    </div>

    @if (Session::has('success'))
        <script>
            swal({
                title: 'Succes!',
                icon: "success",
                text: 'Data berhasil diupdate',
                timer: 1000,
                buttons: false,
            });
        </script>
    @endif

    <div class="card mt-1">
        <div class="table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Panjar</th>
                        <th>Tanggal</th>
                        <th>Nama Driver</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th width="130px">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    @push('script')
        {{-- dataTable --}}
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script
            src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.3/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/datatables.min.js">
        </script>
        <script>
            $('.reload').click(function() {
                location.reload();
            });

            $(document).ready(function() {
                var dataTable = $('#data_table').DataTable({
                    dom: "<'row'<'col-lg-4 mb-1'l><'col-lg-5 mb-1 text-center'B><'col-lg-3'f>>" +
                        "<'row'<'col-sm-12 py-lg-2'tr>>" +
                        "<'row'<'col-sm-12 col-lg-5'i><'col-sm-12 col-lg-7'p>>",
                    responsive: true,
                    "aLengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    initComplete: function() {
                        $('.dataTables_wrapper .btn').css('margin', '1px');
                    },
                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('index.panjar.driver') }}",
                        data: function(d) {
                            d.filter = $('#filter').val();
                        }
                    },
                    buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            text: 'Excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },

                        {
                            extend: 'print',
                            text: 'Print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                    ],

                    columns: [{
                            data: 'DT_RowIndex',
                            name: '#',
                            searchable: false
                        },
                        {
                            data: 'kode_panjar',
                            name: 'kode_panjar'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'id_driver',
                            name: 'id_driver'
                        },
                        {
                            data: 'down_payment',
                            name: 'down_payment'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },

                        {
                            data: 'opsi',
                            name: 'opsi',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#filter').change(function() {
                    dataTable.draw();
                });

                $('#search').on('keyup change', function() {
                    dataTable.search($('#search').val()).draw();
                    $('#btnFilter').trigger('click'); // Trigger event click pada tombol filter
                });

            });


            function lunas(id, fullname) {
                swal({
                    title: "Pelunasan panjar",
                    text: "Ingin melunasi hutang panjar " + fullname,
                    icon: "info",
                    buttons: true,
                    buttons: ["Batal", "Ya"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'PUT',
                            url: '{{ route('panjar-repaymend') }}',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                swal({
                                    title: "Success!",
                                    text: 'Hutang Panjar Di Lunasi',
                                    icon: "success",
                                    buttons: false,
                                    timer: 1000
                                }).then(function() {
                                    $('#data_table').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                });
            }

            function deleteData(id, fullname) {
                swal({
                    title: "Hapus panjar " + fullname + " ?",
                    text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,

                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: "/pimpinan/panjar-delete/" + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                var table = $('#data_table').DataTable();
                                table.row('#' + response.id).remove().draw();
                                swal({
                                    title: 'Succes!',
                                    icon: "success",
                                    text: 'Data berhasil dihapus',
                                    timer: 1000,
                                    timerProgressBar: true,
                                    buttons: false,
                                })
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                    // else {
                    //     swal({
                    //         text: "Data batal dihapus!",
                    //         buttons: false,
                    //         timer: 500,
                    //     });
                    // }
                });
            }


            function financial_save(id) {
                swal({
                    title: "Pastikan data sudah benar!",
                    text: "Data yang sudah di input ke Laporan Keuangan tidak akan bisa di Ubah/Edit lagi   !",
                    icon: "info",
                    buttons: true,
                    buttons: ["Batal", "OK, Saya mengerti"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('panjar-financial-save') }}',
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
                                    $('#data_table').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });

                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
            }

            function financial_down_payment_save(id) {
                swal({
                    title: "Pastikan data sudah benar!",
                    text: "Data yang sudah di input ke Laporan Keuangan tidak akan bisa di Ubah/Edit lagi   !",
                    icon: "info",
                    buttons: true,
                    buttons: ["Batal", "OK, Saya mengerti"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('down-payment-financial-save') }}',
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
                                    $('#data_table').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });

                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
            }

            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endsection
