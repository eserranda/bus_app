@extends('layouts.master')
@section('title', 'Data Pemesanan Tiket')

@section('content')

    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            margin-left: 20px;
        }
    </style>
    <div class="d-flex align-items-center mb-2 col-md-12">
        <button class="btn btn-primary reload"> <i class="fa-solid fa-rotate"></i></button>
        <select class="form-select mx-2 " id="filter" aria-label="Default select example">
            <option selected disabled>Filter Data</option>
            <option value="0">Bulan ini</option>
            <option value="1">Minggu ini</option>
            <option value="all_data">Tampilkan Semua</option>
        </select>

        <input class="form-control me-3" type="date" id="start_date">
        <label class="me-3">Ke</label>
        <input class="form-control me-3" type="date" id="end_date">

        <button class="btn btn-info border-0" id="btnFilter"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                        <th>No. Tiket</th>
                        <th>Tanggal</th>
                        <th>Rute</th>
                        <th>Bus</th>
                        <th>Nama</th>
                        <th>No. Hp</th>
                        <th>No. Kursi</th>
                        <th>Total Bayar</th>
                        <th>Ket.</th>
                        <th width="120px">Opsi</th>
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

        function deleteData(id, fullname) {
            swal({
                title: "Hapus data tiket " + fullname + " ?",
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "/admin/pemesanan-tiket-delete/" + id,
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
                            swal("Oops...", "Terjadi kesalahan saat menghapus data!",
                                "error");
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    });
                }
            });
        }

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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 9]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 9]
                        }
                    },
                ],

                initComplete: function() {
                    $('.dataTables_wrapper .btn').css('margin', '1px');
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('index.data.tiket') }}",
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
                        data: 'no_ticket',
                        name: 'no_ticket'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'rute',
                        name: 'rute'
                    },
                    {
                        data: 'bus',
                        name: 'bus'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customers_phone_number',
                        name: 'customers_phone_number'
                    },
                    {
                        data: 'seats_number',
                        name: 'seats_number'
                    },
                    {
                        data: 'price',
                        name: 'price'
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
    </script>

@endsection
