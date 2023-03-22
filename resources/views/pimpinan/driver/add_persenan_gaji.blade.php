@extends('layouts.master')

@section('title')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Tambah Persenan Gaji Driver
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="driver/persenan-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="from_city" class="form-label">Kota Asal<span class="text-danger">*</span></label>
                    <select class="form-select" id="from_city" name="from_city" required>
                        <option value="" selected disabled>Kota asal</option>
                        @foreach ($ruteList as $row)
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
                        @foreach ($ruteList as $row)
                            <option value="{{ $row->city }}">
                                {{ $row->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Sopir Utama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sopir_utama" name="sopir_utama"
                        placeholder="% Sopir Utama" required>
                </div>

                <div class="col-md-6">
                    <label for="inputAddress2" class="form-label">Sopir Bantu<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sopir_bantu" name="sopir_bantu"
                        placeholder="% Sopir Bantu" required>
                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus"></i> Tambah</button>
                    <a href="/pimpinan/persenan-gaji" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
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
                        url: 'persenan-gaji-toCity',
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
            });
        </script>
    @endpush
@endsection
