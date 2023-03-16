@extends('layouts.master')
@section('title', 'BOP Perawatan Armada Bus')
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

    <div class="d-flex align-items-center mb-2 col-md-12 col-sm-12">
        <button class="btn btn-primary reload mx-2"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select" id="filter" aria-label="Default select example">
            <option selected disabled>Filter Data</option>
            <option value="0">Belum tercatat LK.</option>
            <option value="1">Arsip</option>
            <option value="all_data">Tampilkan Semua Data</option>
        </select>

        <input class="form-control mx-3" type="date" id="start_date">
        <label class="me-3">Ke</label>
        <input class="form-control me-3" type="date" id="end_date">

        <button class="btn btn-info border-0" id="btnFilter"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    @if (Session::has('status'))
        <script>
            swal({
                title: 'Succes!',
                icon: "success",
                text: 'Data berhasil disimpan',
                timer: 1000,
                timerProgressBar: true,
                buttons: false,
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            swal({
                title: 'Error!',
                icon: "error",
                text: 'Terjadi Kesalahan saat menginput data',
                timerProgressBar: true,
            });
        </script>
    @endif

    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            margin-left: 20px;
        }
    </style>

    <div class="card">

        <div class="d-flex my-2 m-2">
            <a href="/pimpinan/perawatan-armada-add" class="btn btn-info btn-sm">Tambah</a>
            <a href="/pimpinan/perawatan-armada-add-multiple" class="btn btn-warning btn-sm mx-2">Tambah Banyak</a>
            <button class="btn-sm border-0 btn-primary reload"> <i class="fa-solid fa-rotate"></i></button>
        </div>

        <div class="table-responsive">
            <table class="table data_table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th style="width: 120px">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            var dataTable = $('#data_table').DataTable({
                dom: "<'row'<'col-lg-4 mb-1'l><'col-lg-5 mb-1 text-center'B><'col-lg-3'f>>" +
                    "<'row'<'col-sm-12 py-lg-2'tr>>" +
                    "<'row'<'col-sm-12 col-lg-5'i><'col-sm-12 col-lg-7'p>>",
                responsive: true,
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

                initComplete: function() {
                    $('.dataTables_wrapper .btn').css('margin', '1px');
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_perwatan_bus') }}",
                    data: function(d) {
                        d.filter = $('#filter').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },

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

            function checkInput() {
                if ($('#start_date').val() === '' || $('#end_date').val() === '') {
                    $('#btnFilter').prop('disabled', true);
                    $('#btnFilter').addClass('bg-secondary');
                } else {
                    $('#btnFilter').prop('disabled', false);
                    $('#btnFilter').removeClass('bg-secondary');
                }
            }
            checkInput(); // mengecek input kosong pada awal halaman dimuat
            $('#start_date, #end_date').on('input', function() {
                checkInput(); // mengecek input kosong pada event listener
            });

            $('#filter').change(function() {
                dataTable.draw();
                if ($(this).val() != null) {
                    $('#start_date').prop('disabled', true);
                    $('#end_date').prop('disabled', true);
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#btnFilter').prop('disabled', true);
                    $('#btnFilter').addClass('bg-secondary');
                } else {
                    $('#start_date').prop('disabled', false);
                    $('#end_date').prop('disabled', false);
                    $('#btnFilter').prop('disabled', false);
                }
            });


            $('#btnFilter').click(function() {
                dataTable.draw();
            });

            $('#search').on('keyup change', function() {
                dataTable.search($('#search').val()).draw();
                $('#btnFilter').trigger('click'); // Trigger event click pada tombol filter
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
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    });
                }
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
                                $('#data_table').DataTable().ajax.reload();
                            });
                        },

                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    });
                }
            });
        }


        $('.reload').click(function() {
            // $('#data_table').DataTable().ajax.reload();
            location.reload();
        });
    </script>

@endsection
