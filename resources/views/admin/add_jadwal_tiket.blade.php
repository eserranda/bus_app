@extends('layouts.master')


@section('content')
    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="jadwal-tiket-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="departure_date" name="departure_date" required
                        min="{{ date('Y-m-d', strtotime('today')) }}">
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Jam Berangakat<span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="departure_time" name="departure_time" required>
                </div>

                <div class="col-md-6">
                    <label for="from_city" class="form-label">Dari Kota<span class="text-danger">*</span></label>
                    <select class="form-select" id="from_city" name="from_city" required>
                        <option value="" selected disabled>Kota Asal</option>
                        @foreach ($ruteList as $row)
                            <option value="{{ $row->city }}">
                                {{ $row->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Kota Tujuan<span class="text-danger">*</span></label>
                    <select class="form-select" id="to_city" name="to_city" required>
                        <option value="">Kota Tujuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Armada Bus<span class="text-danger">*</span></label>
                    <select class="form-select" id="id_bus" name="id_bus" required>
                        <option value="" selected disabled>Pilih Armada Bus</option>
                        @foreach ($busList as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->type }} - {{ $row->plat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Sopir Utama<span class="text-danger">*</span></label>
                    <select class="form-select" id="sopir_utama" name="sopir_utama" required>
                        <option value="" selected disabled>Sopir Utama</option>
                        @foreach ($driverUtama as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Sopir Bantu<span class="text-danger">*</span></label>
                    <select class="form-select" id="sopir_bantu" name="sopir_bantu" required>
                        <option value="" selected disabled>Sopir Bantu</option>
                        @foreach ($driverBantu as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Kondektur<span class="text-danger">*</span></label>
                    <select class="form-select" id="kondektur" name="kondektur" required>
                        <option value="" selected disabled>Kondektur</option>
                        @foreach ($kondektur as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Harga Tiket<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="price" name="price"
                        placeholder="Harga Tiket / Kursi" maxlength="12" required>
                </div>

                <div class="col-12">
                    <button id="add" type="submit" class="btn btn-primary mb-1 add"><i class="fa-solid fa-plus"></i>
                        Tambah</button>
                    <a href="/admin/jadwal-tiket" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                $('#id_bus').on('change', function() {
                    var id_bus = $('#id_bus').val();
                });

                $('#from_city').on('change', function() {
                    var from_city = $('#from_city').val();
                    $.ajax({
                        type: 'post',
                        url: '/admin/toCity',
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

                $('#price').on('input', function() {
                    $(this).val(function(index, value) {
                        return formatRupiah(value.replace(/\D/g, ''));
                    });
                });

                $('#add').click(function() {
                    var priceVal = $('#price').val();
                    var numericPrice = priceVal.replace(/\D/g, '');
                    $('#price').val(numericPrice);
                });
            });
        </script>
    @endpush
@endsection
