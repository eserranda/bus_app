@extends('layouts.master')
@section('title', ' Data Driver')
@section('submenu', 'show')

@section('content')
    <style>
        .dataTables_wrapper {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            margin-left: 20px;
        }
    </style>

    <div class="my-2">
        <a href="/pimpinan/add-driver" class="btn btn-info">Tambah</a>
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
                    {{-- @foreach ($driverList as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->fullname }}</td>
                            <td>{{ $row->gender }}</td>
                            <td>{{ $row->driver_type }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->entry_year }}</td>
                            <td>{{ $row->address }}</td>
                            <td>
                                <a class="btn-sm btn-info" href="/admin/driver-info/{{ $row->id }}"><i
                                        class="fa-solid fa-circle-info"></i></a>
                                <a class="btn-sm btn-primary" href="/admin/driver-edit/{{ $row->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn-sm btn-danger" href="/admin/driver-delete/{{ $row->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach --}}
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
@endsection
