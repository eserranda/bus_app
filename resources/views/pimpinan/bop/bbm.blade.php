@extends('layouts.master')
@section('title', 'Data Pembelian BBM')
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
        {{-- <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}
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
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table" id="data_table">
                <div class="d-flex m-2">
                    <a href="/pimpinan/bbm-add" class="btn btn-info btn-sm">Tambah</a>
                    <a href="/pimpinan/bbm-add-multiple" class="btn btn-warning btn-sm mx-2">Tambah Banyak</a>
                </div>
                <thead>
                    <tr class="item-center">

                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Bus</th>
                        <th>Jumlah Liter</th>
                        <th>Harga</th>
                        <th width="120px">Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <script>
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
                    url: "{{ route('index.bbm') }}",
                    data: function(d) {
                        d.filter = $('#filter').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
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
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'kode_transaksi',
                        name: 'kode_trandsaksi'
                    },
                    {
                        data: 'id_bus',
                        name: 'id_bus'
                    },
                    {
                        data: 'jumlah_liter',
                        name: 'jumlah_liter'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    },
                ]
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

        function deleteData(id, kode) {
            swal({
                title: "Hapus data " + kode + " ?",
                text: "Data ini belum tersimpan di Laporan Keuangan, Apakah tetap ingin melanjutkan penghapusan??",
                icon: "error",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "/pimpinan/bbm-delete/" + id,
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
            });
        }


        function financial_save(id) {
            swal({
                title: "Pastikan data sudah benar!",
                text: "Data yang sudah di input ke Laporan Keuangan tidak bisa di Ubah/Edit kembali !",
                icon: "info",
                buttons: true,
                buttons: ["Batal", "OKE, Saya mengerti"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('bbm-financial-save') }}',
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

                }
            });
        }

        $('.reload').click(function() {
            location.reload();
        });
    </script>
@endsection
