@extends('layouts.master')

@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Tambah Panjar Driver
                    </h2>
                </div>
                <!-- Page title actions -->
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/panjar-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="col-md-6">
                    <label for="id_driver" class="form-label">Nama Driver<span class="text-danger">*</span></label>
                    <select class="form-select" id="id_driver" name="id_driver" required>
                        <option value="" selected disabled>Nama Driver</option>
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
                        placeholder="Jumlah panjar" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1 save"><i class="fa-solid fa-plus"></i>
                        Simpan</button>
                    <a href="/pimpinan/panjar-driver" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $('#from_city').on('change', function() {
                    var from_city = $('#from_city').val();
                    $.ajax({
                        type: 'post',
                        url: '/pimpinan/toCity',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            from_city: from_city
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#to_city').empty();
                            $('#to_city').append(
                                '<option value=""  selected disabled>Kota Tujuan</option>');
                            $.each(data, function(index, element) {
                                $('#to_city').append('<option value="' + element.city +
                                    '">' + element.city + '</option>');
                            });
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    })
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

                $('#down_payment').on('input', function() {
                    $(this).val(function(index, value) {
                        return formatRupiah(value.replace(/\D/g, ''));
                    });
                });

                $('.save').click(function() {
                    var priceVal = $('#down_payment').val();
                    var numericPrice = priceVal.replace(/\D/g, '');
                    $('#down_payment').val(numericPrice);
                });

            });
        </script>
    @endpush
@endsection
