@extends('layouts.master')

@push('headcss')
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.3/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush
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

    <div class="my-1">

    </div>
    <div class="card mt-1">
        <div class="table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Berangkat</th>
                        <th>Rute</th>
                        <th>Bus</th>
                        <th>Driver</th>
                        <th>Kondektur</th>
                        <th>Penumpang</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- @foreach ($listKedatangan as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->departure_date }}</td>
                            <td>{{ $row->from_city }} - {{ $row->to_city }}</td>
                            <td>{{ $row->bus->type }}</td>
                            <td>{{ $row->sopirUtama->fullname }} / {{ $row->sopirBantu->fullname }}</td>
                            <td>{{ $row->Kondektur->fullname }}</td>
                            <td class="text-center">{{ $row->total_passenger }} </td>
                            <td>
                                @if ($row->status == 1)
                                    <span class="badge text-bg-warning">Dalam Perjalanan</span>
                                @elseif ($row->status == 3)
                                    <span class="badge text-bg-success">Telah Tiba</span>
                                @endif
                            </td>
                            <td>
                                @if ($row->status == 1)
                                    <a class="btn btn-info" href="/admin/kedatangan-tiba/{{ $row->id }}">Tiba</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach --}}


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
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                    ],

                    initComplete: function() {
                        $('.dataTables_wrapper .btn').css('margin', '1px');
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.kedatangan') }}",
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
                            data: 'rute',
                            name: 'rute'
                        },
                        {
                            data: 'bus',
                            name: 'bus'
                        },
                        {
                            data: 'id_driver',
                            name: 'id_driver'
                        },
                        {
                            data: 'kondektur',
                            name: 'kondektur',
                        },
                        {
                            data: 'total_passenger',
                            name: 'total_passenger',
                        },
                        {
                            data: 'status',
                            name: 'status',
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
                            url: '{{ route('financial_tiket_save') }}',
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
        </script>
    @endpush
@endsection
