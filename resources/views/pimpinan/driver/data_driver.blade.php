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
                        Data Driver
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="/pimpinan/add-driver" class="btn btn-info">Tambah</a>
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
                        <th>Nama</th>
                        <th>Gender</th>
                        <th>Jenis Driver</th>
                        <th>Hp</th>
                        <th>Tahun Masuk</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th width="70px">Opsi</th>
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
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('index.data.drivers') }}",
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
                            text: '<i class="fa-solid fa-print text-warning"></i>',
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
                            data: 'fullname',
                            name: 'fullname'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'driver_type',
                            name: 'driver_type'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'entry_year',
                            name: 'entry_year'
                        },
                        {
                            data: 'address',
                            name: 'address'
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
                    $('#btnFilter').prop('disabled', false);
                });

                $('#search').on('keyup change', function() {
                    dataTable.search($('#search').val()).draw();
                    $('#btnFilter').trigger('click'); // Trigger event click pada tombol filter
                });
            });

            function deleteData(id, fullname) {
                swal({
                    title: "Hapus driver " + fullname + "?",
                    text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: "/pimpinan/driver-delete/" + id,
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
        </script>
    @endpush
@endsection
