@extends('layouts.master')

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
                        Jadwal Tiket
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/add-rute" class="btn">
                                Tambah Rute
                            </a>
                        </span>

                        <a href="/admin/add-jadwal-tiket" class="btn btn-primary d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Jadwal
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
    <div class="d-flex align-items-center mb-2 col-md-12">
        <button class="btn btn-primary btn-icon reload"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select mx-2 " id="filter" aria-label="Default select example">
            <option selected disabled>Filter Data</option>
            <option value="0">Bulan ini</option>
            <option value="1">Minggu ini</option>
            <option value="all_data">Tampilkan Semua</option>
        </select>

        <input class="form-control me-3" type="date" id="start_date">
        <label class="me-3">Ke</label>
        <input class="form-control me-3" type="date" id="end_date">

        <button class="btn btn-info btn-icon border-0" id="btnFilter"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card mt-1">
        <div class="table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Keb.</th>
                        <th>Bus</th>
                        <th>Rute</th>
                        <th>Sopir</th>
                        <th>Sopir Bantu</th>
                        <th>Kondektur</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @push('script')
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
                    buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            text: 'Excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7]
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7]
                            }
                        },
                    ],

                    initComplete: function() {
                        $('.dataTables_wrapper .btn').css('margin', '1px');
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.jadwal.tiket') }}",
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
                            data: 'departure_date',
                            name: 'departure_date'
                        },
                        {
                            data: 'departure_code',
                            name: 'departure_code'
                        },
                        {
                            data: 'bus',
                            name: 'bus'
                        },
                        {
                            data: 'rute',
                            name: 'rute'
                        },

                        {
                            data: 'sopir_utama',
                            name: 'sopir_utama'
                        },

                        {
                            data: 'sopir_bantu',
                            name: 'sopir_bantu'
                        },
                        {
                            data: 'kondektur',
                            name: 'kondektur'
                        },

                        {
                            data: 'price',
                            name: 'price',
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

            function deleteData(id, date) {
                swal({
                    title: "Hapus jadwal tgl " + date,
                    text: "Data Keberangkatan Bus pada tanggal " + date +
                        " juga akan terhapus, pastikan belun ada Tiket yang terjual pada tanggal tersebut!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: "/admin/jadwal-tiket-delete/" + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
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
                                } else if (response.passenger) {
                                    swal({
                                        title: 'Jadwal tidak dapat dihapus!',
                                        icon: "warning",
                                        text: 'Terdapat tiket yang sudah terjual pada jadwal ini. Harap periksa Data Pembelian Tiket',
                                    })
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
