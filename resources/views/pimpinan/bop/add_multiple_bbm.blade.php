@extends('layouts.master')
@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Tambah data BOP BBM
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="d-flex my-2">
        <button class="btn btn-info reload"> <i class="fa-solid fa-rotate"></i></button>
    </div>
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <form action="{{ route('bbm-multiple-save') }}" method="post">
                @csrf
                <div class="table responsive mb-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Kode</td>
                                <td>Tanggal</td>
                                <td>Bus</td>
                                <td>Jumlah Liter</td>
                                <td>Total Harga</td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody class="from_add">
                            <tr>
                                <td class="col-md-2">
                                    <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi[]"
                                        placeholder="Kode" required value="{{ $kode }}" readonly>
                                </td>
                                <td>
                                    <input type="date" class="form-control" id="date" name="date[]" required>
                                </td>
                                <td>
                                    <select class="form-control" name="id_bus[]" id="id_bus">
                                        <option value="" selected disabled>Pilih Bus</option>
                                        @foreach ($ListBus as $row)
                                            <option value="{{ $row->id }}">{{ $row->type }} | {{ $row->plat }}
                                            </option>
                                        @endforeach
                                    </select>

                                </td>
                                <td class="col-md-2">
                                    <input type="text" class="form-control" id="jumlah_liter" name="jumlah_liter[]"
                                        placeholder="Jumlah Liter" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="total_harga" name="total_harga[]"
                                        placeholder="Total Harga" required>
                                </td>
                                <td>
                                    <button class="btn btn-icon btn-primary mb-1 add" id="add_rows"><i
                                            class="fa-solid fa-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 p-2">
                    <button type="submit" class="btn btn-primary  mb-1 save" id="save">
                        <i class="fa-regular fa-floppy-disk mx-1"></i>
                        Simpan</button>
                    <a href="/pimpinan/bbm" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left mx-1"></i>
                        Kembali</a>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function(e) {
                var kode = $('#kode_transaksi').val();
                var nextKode = 'BBM-' + (parseInt(kode.split('-')[1]) + 1).toString().padStart(3, '0');

                $('#add_rows').click(function(e) {
                    e.preventDefault();

                    var kodeBaru = nextKode;

                    $('.from_add').append(
                        '<tr>\
                                    <td><input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi[]" placeholder="Kode" required value=' +
                        kodeBaru +
                        '  readonly></td>\
                                      <td><input type="date" class="form-control" id="date" name="date[]" required></td>\
                                      <td><select class="form-control" name="id_bus[]" id="id_bus">@foreach ($ListBus as $row)<option value="{{ $row->id }}">{{ $row->type }} | {{ $row->plat }}</option>@endforeach</select></td>\
                                     <td class="col-md-2"><input type="number" class="form-control" id="jumlah_liter" name="jumlah_liter[]" placeholder="Jumlah Liter" required></td>\
                                                                                                                                                                                                                                                                            <td><input type="text" class="form-control harga" id="harga" name="total_harga[]" placeholder="Total Harga" required></td>\
                                  <td><button class="btn btn-icon btn-danger mb-1 remove_row" id="add_rows"><i class="fa-solid fa-trash-can"></i></button></td>\
                                                                                                   </tr>'
                    );
                    nextKode = 'BBM-' + (parseInt(kodeBaru.split('-')[1]) + 1).toString().padStart(3, '0');
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

                $('#save').click(function() {
                    var priceVal = $('#total_harga').val();
                    var numericPrice = priceVal.replace(/\D/g, '');
                    $('#total_harga').val(numericPrice);

                    $('.harga').each(function() {
                        var harga = $(this).val().replace(/\D/g, '');
                        $(this).val(harga);
                    });
                });
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

                $('#total_harga').on('input', function() {
                    $(this).val(function(index, value) {
                        return formatRupiah(value.replace(/\D/g, ''));
                    });
                });

            });
        </script>
    @endpush
@endsection
