@extends('layouts.master')
@section('title', 'Data Gaji Karyawan')
{{-- @section('submenu', 'show') --}}

@section('content')


    <div class="d-flex my-2">
        <a href="/pimpinan/add-gaji-karyawan" class="btn btn-info btn-sm">Tambah</a>
        {{-- <a href="/pimpinan/bbm-add-multiple" class="btn btn-warning btn-sm mx-2">Tambah Banyak</a> --}}
        <button class="btn-sm border-0 btn-primary reload mx-2"> <i class="fa-solid fa-rotate"></i></button>
    </div>

    @if (Session::has('status'))
        <script>
            swal("Success!", "Data berhasil disimpan", "success");
        </script>

        {{ Session::forget('status') }}
    @endif

    <div class="card">
        <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr class="item-center">
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Gaji</th>
                        <th>Nama Karyawan</th>
                        <th>Gaji Bulan</th>
                        <th>Gaji Pokok</th>
                        <th>Bonus</th>
                        <th>Potongan</th>
                        <th>Total Gaji</th>
                        {{-- <th>Status</th> --}}
                        <th width="120px">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ListData as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->kode_gaji_karyawan }}</td>
                            <td>{{ $row->karyawan->fullname }} ({{ $row->jabatan }})</td>
                            <td>{{ $row->month }}</td>
                            <td>{{ $row->gaji_pokok }}</td>
                            <td>{{ $row->bonus }}</td>
                            <td>{{ $row->potongan }}</td>
                            <td>{{ $row->total_gaji }}</td>
                            {{-- <td>{{ $row->status }}</td> --}}
                            <td>
                                @if ($row->status == false)
                                    <a class="btn btn-light text-danger btn-sm"
                                        onclick="deleteData('{{ $row->id }}','{{ $row->status }}', $(this).closest('tr').find('td:eq(2)').text())">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>

                                    <a class="btn btn-light text-dark btn-sm"
                                        href="/pimpinan/gaji-karyawan-edit/{{ $row->id }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <a class="btn btn-light text-primary btn-sm financial-save" data-toggle="tooltip"
                                        title="Input ke laporan Keuangan" onclick="financial_save('{{ $row->id }}')">
                                        <i class="fa-solid fa-file-medical"></i>
                                    </a>
                                @elseif ($row->status == true)
                                    <a class="btn btn-light text-danger btn-sm"
                                        onclick="deleteData('{{ $row->id }}','{{ $row->status }}', $(this).closest('tr').find('td:eq(2)').text())">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteData(id, status, name) {
            if (status == 0) {
                swal({
                    title: "Hapus data " + name,
                    text: "Data ini belum tersimpan di Laporan Keuangan, Apakah tetap ingin melanjutkan penghapusan??",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: '/pimpinan/gaji-karyawan-delete/' + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                swal({
                                    title: 'Succes!',
                                    icon: "success",
                                    text: 'Data berhasil dihapus',
                                    timer: 1000,
                                    timerProgressBar: true,
                                    buttons: false,
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                });
            } else(
                swal({
                    title: "Hapus data " + name,
                    text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: '/pimpinan/gaji-karyawan-delete/' + id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                swal({
                                    title: 'Succes!',
                                    icon: "success",
                                    text: 'Data berhasil dihapus',
                                    timer: 1000,
                                    timerProgressBar: true,
                                    buttons: false,
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                })
            )
        }


        function financial_save(id) {
            swal({
                title: "Pastikan data sudah benar!",
                text: "Data yang sudah di input ke Laporan Keuangan tidak bisa di Ubah/Edit kembali",
                icon: "info",
                buttons: true,
                buttons: ["Batal", "OKE, Saya mengerti"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('gaji-karyawan-financial-save') }}',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            // console.log(response)
                            swal({
                                title: "Success!",
                                text: 'Data berhasil ditambahkan ke Laporan Keuangan',
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then(function() {
                                window.location.reload();
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
@endsection
