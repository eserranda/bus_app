@extends('layouts.master')
@section('title', 'Laporan Transaksi Keberangkatan/Kedatangan Bus')
{{-- @section('submenu', 'show') --}}

@section('content')

    {{-- <div class="my-2">
        <button class="btn btn-info add">Test</button>
    </div> --}}

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Rute</th>
                        <th>Total Tiket</th>
                        <th>Total Pendapatan</th>
                        <th>Status Bus</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($tiketList as $row) --}}
                    <tr>
                        {{-- <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->departure_code }}</td>
                            <td>{{ $row->from_city }} - {{ $row->to_city }}</td>
                            <td>{{ $row->total_ticket }}</td>
                            <td>{{ $row->total_price }}</td> --}}
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function getData() {
            $.ajax({
                url: '{{ route('transaksi_tiket') }}',
                type: "GET",
                dataType: 'json',
                success: function(response) {

                    $('#table-data tbody tr').empty();

                    // Mengisi data ke dalam tabel
                    $.each(response, function(index, data) {

                        var tanggal = new Date(data.date);
                        var tanggalStr = ('0' + tanggal.getDate()).slice(-2) + '-' + ('0' + (tanggal
                            .getMonth() + 1)).slice(-2) + '-' + tanggal.getFullYear();

                        var newRow = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + tanggalStr + '</td>' +
                            '<td>' + data.departure_code + '</td>' +
                            '<td>' + data.from_city + ' - ' + data.to_city + '</td>' +
                            '<td>' + data.total_ticket + '</td>' +
                            '<td>Rp' + new Intl.NumberFormat('id-ID').format(data.total_price) +
                            '</td>' +
                            '<td>' + (data.status == 0 ?
                                '<span class="badge text-bg-warning">Belum Berangkat</span>' :
                                (data.status == 1 ?
                                    '<span class="badge text-bg-info">Dalam Perjalanan</span>' :
                                    '<span class="badge text-bg-success">Telah Sampai</span>'
                                )
                            ) + '</td>' +
                            '<td>' + (data.status == 2 ?
                                '<a class="btn btn-light text-primary btn-sm financial-save" onclick="financial_save(' +
                                data.id + ')">' + '<i class="fa-solid fa-file-medical"></i>' :
                                ' <span class="badge text-bg-warning">Arsip</span> '
                            ) + '</td>';

                        // '<td>' +
                        // '<a class="btn btn-light text-primary btn-sm financial-save" onclick="financial_save(' +
                        // data.id + ')">' + '<i class="fa-solid fa-file-medical"></i>' + '</a>' +
                        // '</td>';

                        $('#table-data tbody').append(newRow);

                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        $(document).ready(function() {
            getData(); // Panggil fungsi untuk pertama kali
            setInterval(getData, 5000); // Panggil setiap 5 detik
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
                                // $('#data_table').DataTable().ajax.reload();
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
