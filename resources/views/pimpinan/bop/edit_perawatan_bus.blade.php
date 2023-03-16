@extends('layouts.master')
@section('title', 'Edit Data Bop Armada Bus')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-12 col-md-12">
        <div class="card">
            <form action="/pimpinan/perawatan-armada-update/{{ $ListData->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-2">
                    <label for="name" class="form-label">Kode Trasaksi<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" placeholder="Kode"
                        required value="{{ $ListData->kode_transaksi }}" readonly>
                </div>

                <div class="col-md-2">
                    <label for="name" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $ListData->date }}"
                        required>
                </div>


                <div class="col-md-5">
                    <label for="plat" class="form-label">Keterangan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="jenis_pengeluaran" name="jenis_pengeluaran"
                        placeholder="Keterangan" value="{{ $ListData->jenis_pengeluaran }}" required>
                </div>

                <div class="col-md-3">
                    <label for="Bus_seats" class="form-label">Harga<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="harga" name="harga" value="{{ $ListData->harga }}"
                        placeholder="Total Harga" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1 update" id="update">
                        <i class="fa-solid fa-plus"></i> Update</button>
                    <a href="/pimpinan/perawatan-armada" class="btn btn-warning mb-1"><i
                            class="fa-solid fa-angles-left"></i> Kembali</a>

                </div>
            </form>

        </div>
    </div>


    <script>
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

            $('#update').click(function() {
                var priceVal = $('#harga').val();
                var numericPrice = priceVal.replace(/\D/g, '');
                $('#harga').val(numericPrice);
            });
        });
    </script>
@endsection
