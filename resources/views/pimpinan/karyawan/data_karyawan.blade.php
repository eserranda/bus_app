@extends('layouts.master')
@section('title', 'Data Karyawan')
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

    <div class="my-2">
        <a href="/pimpinan/add-data-karyawan" class="btn btn-info">Tambah</a>
    </div>

    @if (Session::has('status'))
        <script>
            swal({
                title: 'Succes!',
                icon: "success",
                text: 'Data berhasil diupdate',
                timer: 1500,
                timerProgressBar: true,
                buttons: false,
            })
        </script>

        {{ Session::forget('status') }}
    @endif
    <div class="card">
        <div class="table-responsive">

            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>No. Hp</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th width="90px">Opsi</th>
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
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('index.data.karyawan') }}",
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
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'position',
                        name: 'position'
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
                title: "Hapus karyawan " + fullname + "?",
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "/pimpinan/data-karyawan-delete/" + id,
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
