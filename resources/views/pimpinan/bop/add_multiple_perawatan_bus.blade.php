@extends('layouts.master')
@section('title', 'Tambah Banyak BOP Armada')
@section('submenu', 'show')

@section('content')
    <div class="d-flex my-2">
        <button class="btn-sm border-0 btn-info reload"> <i class="fa-solid fa-rotate"></i></button>
    </div>
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <form action="{{ route('perawatan_multiple_save') }}" method="POST">
                @csrf

                <div class="table responsive mb-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Kode</td>
                                <td>Tanggal</td>
                                <td>Jenis Pengeluaran</td>
                                <td>Harga</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody class="from_add">
                            <tr>
                                <td> <input type="text" class="form-control " id="kode_transaksi" name="kode_transaksi[]"
                                        placeholder="Kode" required value="{{ $kode }}" readonly></td>
                                <td>
                                    <input type="date" class="form-control" id="date" name="date[]"
                                        placeholder="Jenis Bus" required>
                                </td>
                                <td>
                                    {{-- <input type="text" class="form-control" id="jenis_pengeluaran"
                                        name="jenis_pengeluaran[]" placeholder="Keterangan" required> --}}
                                    <textarea class="form-control" id="jenis_pengeluaran" name="jenis_pengeluaran[]" rows="2"></textarea>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="harga" name="harga[]"
                                        placeholder="Total Harga" required>
                                </td>
                                <td>
                                    <button class="btn btn-primary mb-1 add" id="add_rows"><i
                                            class="fa-solid fa-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 p-2">
                    <button type="submit" class="btn btn-primary  mb-1 create_data" id="add"><i
                            class="fa-solid fa-plus"></i>
                        Tambah</button>
                    <a href="/pimpinan/perawatan-armada" class="btn btn-warning mb-1"><i
                            class="fa-solid fa-angles-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(e) {
            var kode = $('#kode_transaksi').val();
            var nextKode = 'BOP-' + (parseInt(kode.split('-')[1]) + 1).toString().padStart(3, '0');

            $('#add_rows').click(function(e) {
                e.preventDefault();

                var kodeBaru = nextKode;

                $('.from_add').append(
                    '<tr>\
              <td><input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi[]" placeholder="Kode" required value=' +
                    kodeBaru + '  readonly></td>\
            <td><input type="date" class="form-control" id="date" name="date[]" placeholder="Jenis Bus" required></td>\
             <td><textarea class="form-control" id="jenis_pengeluaran"  name="jenis_pengeluaran[]" rows="2"></textarea></td>\
              <td><input type="text" class="form-control harga" id="harga" name="harga[]" placeholder="Total Harga" required></td>\
             <td><button class="btn btn-danger mb-1 remove_row" id="add_rows"><i class="fa-solid fa-trash-can"></i></button></td>\
              </tr>');
                nextKode = 'BOP-' + (parseInt(kodeBaru.split('-')[1]) + 1).toString().padStart(3, '0');
            });

            $(document).on('click', '.remove_row', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });

            function formatRupiah(angka) {
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
                return rupiah;
            }

            $(document).on('input', '#harga', function() {
                $(this).val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            });

            $('.reload').click(function() {
                window.location.reload();
            });

            $('#add').click(function() {
                var priceVal = $('#harga').val();
                var numericPrice = priceVal.replace(/\D/g, '');
                $('#harga').val(numericPrice);

                $('.harga').each(function() {
                    var harga = $(this).val().replace(/\D/g, '');
                    $(this).val(harga);
                });
            });

            // $('#create_data').submit(function(e) {
            //     e.preventDefault();

            //     $.ajax({
            //         data: $('#form_add').serialize(),
            //         success: function(data) {
            //             alert('Data brhasil disimpan.');
            //         },
            //         error: function(data) {
            //             alert('Terjadi kesalahan saat menyimpan data.');
            //         }
            //     });
            // });
        });


        $(document).ready(function() {
            function formatRupiah(angka) {
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
                return rupiah;
            }

            $('#harga').on('input', function() {
                $(this).val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            });

        });
    </script>
@endsection
