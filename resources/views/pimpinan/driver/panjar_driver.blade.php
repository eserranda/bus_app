@extends('layouts.master')
@section('title', 'Panjar Driver')
{{-- @section('submenu', 'show') --}}

@section('content')

    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            margin-left: 20px;
        }
    </style>

    <div class="d-flex align-items-center mb-2 col-md-5">
        <a href="panjar-add" class="btn btn-info ">Tambah</a>
        <button class="btn btn-primary reload mx-2"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select" id="filter" aria-label="Default select example">
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
                        extend: 'pdf',
                        text: 'PDF',
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

@endsection
