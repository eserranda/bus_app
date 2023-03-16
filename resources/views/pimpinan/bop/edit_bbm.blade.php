@extends('layouts.master')
@section('title', 'Pembelian BBM')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/bbm-update/{{ $ListData->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $ListData->date }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="id_bus" class="form-label">Bus<span class="text-danger">*</span></label>
                    <select class="form-select" name="id_bus" id="id_bus" required>
                        <option value="" selected disabled>Pilih Bus</option>
                        <option value="{{ $ListData->bus->id }}" selected>{{ $ListData->bus->type }} |
                            {{ $ListData->bus->plat }}</option>
                        @foreach ($ListBus as $row)
                            <option value="{{ $row->id }}">{{ $row->type }} | {{ $row->plat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="jumlah_liter" class="form-label">Jumlah Liter</label>
                    <input type="text" class="form-control" id="jumlah_liter" name="jumlah_liter"
                        placeholder="Jumlah liter yang di beli" value="{{ $ListData->jumlah_liter }}" required>
                </div>


                <div class="col-md-6">
                    <label for="total_harga" class="form-label">Total Harga<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="total_harga" name="total_harga"
                        value="{{ $ListData->total_harga }}" placeholder="Total Harga" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1 add" id="update"><i
                            class="fa-solid fa-floppy-disk"></i> Update</button>
                    <a href="/pimpinan/bbm" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i> Kembali</a>

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

            if ($('#total_harga').val()) {
                $('#total_harga').val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            }
            $('#total_harga').on('input', function() {
                $(this).val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            });

            $('#update').click(function() {
                var priceVal = $('#total_harga').val();
                var numericPrice = priceVal.replace(/\D/g, '');
                $('#total_harga').val(numericPrice);
            });

        });
    </script>
@endsection
