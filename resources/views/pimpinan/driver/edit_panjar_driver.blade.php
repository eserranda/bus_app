@extends('layouts.master')
@section('title', 'Edit Panjar Driver')


@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/panjar-update/{{ $ListPanjar->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="kode_panjar" class="form-label">Kode<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="kode_panjar" name="kode_panjar"
                        value="{{ $ListPanjar->kode_panjar }}" required readonly>
                </div>

                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $ListPanjar->date }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="id_driver" class="form-label">Nama Driver<span class="text-danger">*</span></label>
                    <select class="form-select" id="id_driver" name="id_driver" required>
                        <option value="" selected disabled>Nama Driver</option>
                        <option value="{{ $ListPanjar->driver->id }}" selected>{{ $ListPanjar->driver->fullname }}</option>
                        @foreach ($ListDriver as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="down_payment" class="form-label">Jumlah Panjar<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="down_payment" name="down_payment"
                        placeholder="Jumlah panjar" value="{{ $ListPanjar->down_payment }}" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1" id="update"><i class="fa-solid fa-plus"></i>
                        Update</button>
                    <a href="/pimpinan/panjar-driver" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>
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

            if ($('#down_payment').val()) {
                $('#down_payment').val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            }
            $('#down_payment').on('input', function() {
                $(this).val(function(index, value) {
                    return formatRupiah(value.replace(/\D/g, ''));
                });
            });

            $('#update').click(function() {
                var priceVal = $('#down_payment').val();
                var numericPrice = priceVal.replace(/\D/g, '');
                $('#down_payment').val(numericPrice);
            });
        });
    </script>
@endsection
