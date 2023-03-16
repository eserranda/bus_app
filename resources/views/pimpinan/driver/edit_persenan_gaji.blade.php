@extends('layouts.master')
@section('title', 'Edit Data Persenan Driver')


@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="/pimpinan/driver/persenan-update/{{ $listDataPersenan->id }}" class="row g-3 m-2" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="from_city" class="form-label">Kota Asal<span class="text-danger">*</span></label>
                    <select class="form-select" id="from_city" name="from_city" required>
                        <option value="" selected disabled>Kota asal</option>
                        <option value="{{ $listDataPersenan->from_city }} "selected>{{ $listDataPersenan->from_city }}
                        </option>
                        @foreach ($ListRute as $row)
                            <option value="{{ $row->city }}">
                                {{ $row->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="to_city" class="form-label">Kota Tujuan<span class="text-danger">*</span></label>
                    <select class="form-select" id="to_city" name="to_city" required>
                        <option value="" selected disabled>Kota Tujuan</option>
                        <option value="{{ $listDataPersenan->to_city }} "selected>{{ $listDataPersenan->to_city }}</option>
                        @foreach ($ListRute as $row)
                            <option value="{{ $row->city }}">
                                {{ $row->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Sopir Utama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sopir_utama" name="sopir_utama"
                        placeholder="% Sopir Utama" value="{{ $listDataPersenan->sopir_utama }}" required>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Sopir Bantu<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sopir_bantu" name="sopir_bantu"
                        placeholder="% Sopir Bantu" value="{{ $listDataPersenan->sopir_bantu }}" required>
                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus"></i> Update</button>
                    <a href="/pimpinan/persenan-gaji" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>

                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#from_city').on('change', function() {
                var from_city = $('#from_city').val();
                $.ajax({
                    type: 'post',
                    url: '{{ route('persenan_toCity') }}',

                    data: {
                        from_city: from_city,
                        _token: "{{ csrf_token() }}"
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
        });
    </script>
@endsection
