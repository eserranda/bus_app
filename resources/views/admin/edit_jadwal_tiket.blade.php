@extends('layouts.master')


@section('content')
    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/admin/jadwal-tiket-update/{{ $dataJadwal->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="departure_date" name="departure_date"
                        value="{{ $dataJadwal->departure_date }}" required min="{{ date('Y-m-d', strtotime('today')) }}">
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Jam Berangakat<span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="departure_time" name="departure_time"
                        value="{{ $dataJadwal->departure_time }}" required>
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Armada Bus<span class="text-danger">*</span></label>
                    <select class="form-select" id="id_bus" name="id_bus" required>
                        <option value="{{ $dataJadwal->bus->id }}">{{ $dataJadwal->bus->type }} -
                            {{ $dataJadwal->bus->plat }}</option>
                        @foreach ($busList as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->type }} - {{ $row->plat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="from_city" class="form-label">Dari Kota<span class="text-danger">*</span></label>
                    <select class="form-select" id="from_city" name="from_city" required>
                        <option value="{{ $dataJadwal->from_city }}">{{ $dataJadwal->from_city }}</option>
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
                        <option value="{{ $dataJadwal->to_city }}">{{ $dataJadwal->to_city }}</option>
                    </select>

                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Sopir Utama<span class="text-danger">*</span></label>
                    <select class="form-select" id="sopir_utama" name="sopir_utama">
                        <option value="{{ $dataJadwal->sopir_utama ? $dataJadwal->sopir_utama : '' }}">
                            {{ $dataJadwal->sopir_utama ? $dataJadwal->driver->fullname : '-' }}
                        </option>
                        @if ($dataJadwal->sopir_utama != null)
                            <option value="">-</option>
                        @endif

                        @foreach ($driverUtama as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Sopir Bantu<span class="text-danger">*</span></label>
                    <select class="form-select" id="sopir_bantu" name="sopir_bantu">
                        <option value="{{ $dataJadwal->sopir_bantu ? $dataJadwal->sopir_bantu : '' }}">
                            {{ $dataJadwal->sopir_bantu ? $dataJadwal->sopirBantu->fullname : '-' }}
                        </option>
                        @if ($dataJadwal->sopir_bantu != null)
                            <option value="">-</option>
                        @endif
                        @foreach ($driverBantu as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="driver" class="form-label">Kondektur<span class="text-danger">*</span></label>
                    <select class="form-select" id="kondektur" name="kondektur">
                        <option value="{{ $dataJadwal->kondektur ? $dataJadwal->kondektur : '' }}">
                            {{ $dataJadwal->kondektur ? $dataJadwal->Kondektur->fullname : '-' }}
                        </option>
                        @if ($dataJadwal->kondektur != null)
                            <option value="">-</option>
                        @endif
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
                        value="{{ $dataJadwal->price }}" placeholder="Harga Tiket / Kursi" maxlength="12" required>

                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus"></i> Update</button>
                    <a href="/admin/jadwal-tiket" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {

                $('#from_city').on('change', function() {
                    // alert('test');
                    var from_city = $('#from_city').val();
                    $.ajax({
                        type: 'post',
                        url: '/admin/toCity',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            from_city: $('#from_city').val()
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
