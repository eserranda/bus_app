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
                    <h2 class="page-title">
                        Gaji Driver
                    </h2>
                </div>

                <!-- Page title actions -->
                {{-- action --}}

            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- <div class="my-2">
        <a href="/admin/add-tiket" class="btn btn-info">Tambah</a>
    </div> --}}
    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            margin-left: 20px;
        }
    </style>
    <div class="d-flex align-items-center mb-2 col-md-12">
        <button class="btn btn-primary btn-icon reload"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select mx-2 " id="filter" aria-label="Default select example">
            <option selected disabled>Filter Data</option>
            <option value="1">Belum tercatat LK.</option>
            <option value="0">Belum Diambil</option>
            <option value="2">Arsip</option>
            <option value="all_data">Tampilkan Semua</option>
        </select>

        <input class="form-control me-3" type="date" id="start_date">
        <label class="me-3">Ke</label>
        <input class="form-control me-3" type="date" id="end_date">

        <div class="col-auto">
            <button class="btn btn-info btn-icon" id="btnFilter"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Gaji</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Rute/Trip</th>
                        <th>Total Gaji/Trip</th>
                        <th>Opsi</th>
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
                        url: "{{ route('index.gaji.driver') }}",
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
                            data: 'kode_gaji',
                            name: 'kode_gaji'
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
                            data: 'rute',
                            name: 'rute'
                        },
                        {
                            data: 'salary',
                            name: 'salary',
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



            function deleteData(id, fullname) {
                swal({
                    title: "Hapus data gaji " + fullname + " ?",
                    text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: "/pimpinan/gaji-driver-delete/" + id,
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
                    text: "Data yang sudah di input ke Laporan Keuangan tidak akan bisa di Ubah/Edit lagi   !",
                    icon: "info",
                    buttons: true,
                    buttons: ["Batal", "OK, Saya mengerti"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('gaji-driver-financial-save') }}',
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

            function formatRupiah(angka) {
                var isNegative = false;
                if (angka < 0) {
                    isNegative = true;
                    angka = Math.abs(angka);
                }

                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

                if (isNegative) {
                    rupiah = '-' + rupiah;
                }

                return rupiah;
            }

            // function formatRupiah(angka) {
            //     var number_string = angka.toString().replace(/[^,\d-]/g, '');
            //     split = number_string.split(','),
            //         sisa = split[0].length % 3,
            //         rupiah = split[0].substr(0, sisa),
            //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            //     if (ribuan) {
            //         separator = sisa ? '.' : '';
            //         rupiah += separator + ribuan.join('.');
            //     }
            //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            //     return rupiah;
            // }

            function ambil_gaji(id, fullname, salary) {
                var numericSalary = salary.replace(/\D/g, '');
                $.ajax({
                    type: "get",
                    url: "/pimpinan/ambil-gaji/" + id,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response.down_payment);
                        if (response.data) {
                            swal("Apakah ingin melakukan potongan gaji untuk melunasi panjar?", {
                                title: fullname + " memiliki hutang panjar sebesar " + response.data,
                                buttons: {
                                    cancel: "Batal",
                                    catch: {
                                        text: "Ya, Potong Gaji",
                                        value: "Ya",
                                    },
                                    Tidak: "Ambil Gaji",
                                },
                            }).then((value) => {
                                var total = numericSalary - response.down_payment;
                                var statusdata = response.statusdata
                                // console.log(statusdata);
                                var formattedTotal = formatRupiah(total);
                                var no = true;
                                $(this).val(formattedTotal);
                                switch (value) {
                                    case "Tidak":
                                        $.ajax({
                                            type: "put",
                                            url: "/pimpinan/gaji-driver-update/" + id,
                                            data: {
                                                no: no,
                                                _token: "{{ csrf_token() }}"
                                            },
                                            success: function(response) {
                                                console.log(response)
                                                swal({
                                                    title: "Gaji berhasil di ambil",
                                                    icon: "success",
                                                    text: "Total Gaji yang diterima " +
                                                        salary,
                                                }).then(function() {
                                                    $('#data_table').DataTable().ajax
                                                        .reload();
                                                });
                                            },
                                            error: function(xhr, ajaxOptions, thrownError) {
                                                swal("Oops...",
                                                    "Terjadi kesalahan saat mengupdate data!",
                                                    "error");
                                                console.log(xhr.status + "\n" + xhr
                                                    .responseText +
                                                    "\n" + thrownError);
                                            }
                                        });

                                        break;

                                    case "Ya":
                                        if (total <= 0) {
                                            swal({
                                                title: 'Mohon maaf, Total gaji tidak mencukupi',
                                                text: "Proses dibatalkan!",
                                                icon: "warning",
                                            });
                                            return;
                                        }
                                        if (statusdata == 0) {
                                            swal({
                                                title: 'Periksa Data Panjar!',
                                                text: 'Mohon maaf, Data pengambilan penjar ' +
                                                    fullname +
                                                    ' belum di input ke Laporan Keuangan, Harap input datanya terlebih dahulu agar proses pemotongan gaji bisa dilakukuan! ',
                                                icon: "warning",
                                            });
                                            return;
                                        }
                                        $.ajax({
                                            type: "put",
                                            url: "/pimpinan/gaji-driver-update/" + id,
                                            data: {
                                                _token: "{{ csrf_token() }}"
                                            },
                                            success: function(response) {
                                                console.log(response.success)
                                                swal({
                                                    icon: "success",
                                                    title: "Gaji dipotong, Sisa gaji",
                                                    text: "Rp" + formattedTotal,
                                                }).then(function() {
                                                    $('#data_table').DataTable().ajax
                                                        .reload();
                                                });
                                            },
                                            error: function(xhr, ajaxOptions, thrownError) {
                                                swal("Oops...",
                                                    "Terjadi kesalahan saat mengupdate data!",
                                                    "error");
                                                console.log(xhr.status + "\n" + xhr
                                                    .responseText +
                                                    "\n" + thrownError);
                                            }
                                        });

                                        break;
                                        // default:
                                        //     swal("Proses dibatalkan");
                                }
                            });
                        } else {
                            swal({
                                title: "Total gaji " + fullname + " :",
                                text: salary,
                                icon: "info",
                                buttons: ["Batal", "Ambil Gaji"],
                            }).then((getsalary) => {
                                if (getsalary) {
                                    $.ajax({
                                        type: "put",
                                        url: "/pimpinan/gaji-driver-update/" + id,
                                        data: {
                                            _token: "{{ csrf_token() }}"
                                        },
                                        success: function(response) {
                                            console.log(response.success)
                                            if (response.success) {
                                                swal({
                                                    title: "Gaji berhasil di ambil",
                                                    text: "Terima Kasih",
                                                    icon: "success",
                                                    // buttons: true,
                                                    // timer: 1500,
                                                }).then(function() {
                                                    $('#data_table').DataTable().ajax
                                                        .reload();
                                                });
                                            }
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            swal("Oops...",
                                                "Terjadi kesalahan saat menghapus data!",
                                                "error");
                                            console.log(xhr.status + "\n" + xhr
                                                .responseText +
                                                "\n" + thrownError);
                                        }
                                    });

                                }
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
                        console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        </script>
    @endpush
@endsection
