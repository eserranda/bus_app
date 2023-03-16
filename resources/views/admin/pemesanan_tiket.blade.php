@extends('layouts.master')
{{-- @section('title', 'Pemesanan Tiket') --}}
{{-- @section('submenu', 'show') --}}

@section('content')
    <style>
        .form-inline {
            display: flex;
            align-items: center;
        }

        .form-group {
            display: flex;
            align-items: center;
        }
    </style>
    <div class="alert alert-danger d-none" id="alert-danger"></div>

    <div class="alert alert-success d-none" id="alert-success"></div>

    <div class="row">
        <div class="col-xl-7 col-md-12 mb-2">
            <div class="card shadow">
                <div class="m-3">
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label for="departure_date" class="form-label">Tanggal Berangkat<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="departure_date" name="date" required
                                min="{{ date('Y-m-d', strtotime('today')) }}" onchange="sendDate()"
                                value="{{ $today->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="driver" class="form-label">Jumlah Penumpang</label>
                            <input type="text" class="form-control" id="total_passeger" name="total_passeger"
                                placeholder="Jumlah Penumpang">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="driver" class="form-label">Kota Asal<span class="text-danger">*</span></label>
                            <select class="form-select" id="from_city" name="from_city" required>
                                <option value="" selected disabled>Kota Asal</option>

                            </select>
                        </div>

                        <div class="col-md-6 mt-2 mt-md-0">
                            <label for="to_city" class="form-label">Kota Tujuan<span class="text-danger">*</span></label>
                            <select class="form-select" id="to_city" name="to_city" required>
                                <option value="">Kota Tujuan</option>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-2 mb-3">
                        <div class="col-md-6">
                            <label for="bus" class="form-label">Bus & Harga<span class="text-danger">*</span></label>
                            <select class="form-select" id="id_bus" name="bus" required>
                                <option value="" selected disabled>Bus</option>

                            </select>
                        </div>

                        <div class="col-md-6  mt-2 mt-md-0">
                            <label for="name" class="form-label">Nomor Kursi<span class="text-danger">*</span></label>
                            <select class="form-control kursi m-2" style="width:100% " id="bus_seats" name="seats_number[]"
                                multiple="multiple" required>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Bus_seats" class="form-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tiket_customer_name" name="tiket_customer_name"
                                placeholder="Nama" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Bus_seats" class="form-label">Hp/Wa<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tiket_customers_phone_number"
                                name="tiket_customers_phone_number" placeholder="Nomor Hp/Wa" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6  mt-2  ">
                            <label for="description" class="form-label">Alamat/Penjemputan</label>
                            <textarea class="form-control" id="tiket_costumers_address" name="tiket_costumers_address" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-12 mt-3 mt-md-0 mb-5  mb-2">
            <div class="card shadow p-3">
                <form id="form-input-tiket">
                    <h4 class="text-center">Detail Pemesanan Tiket</h4>
                    <div class="mb-0 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="date">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="tiket" class="col-sm-3 col-form-label">Rute</label>
                        <div class="col-sm-7 form-inline">
                            <div class="form-group">
                                <input type="text" readonly class="form-control-plaintext fw-bold"
                                    id="tiket_from_city">
                                <label class="mx-3" id="to" style="display:none;">
                                    <i class="fa-solid fa-van-shuttle"></i></label>
                                <input type="text" readonly class="form-control-plaintext fw-bold"
                                    style="text-align: center;" id="tiket_to_city">

                            </div>
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <label for="tiket_id_bus" class="col-sm-3 col-form-label">Bus</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="tiket_id_bus">
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">No. Kursi</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="seats_number">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="customer_name" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="customer_name">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="phone_number" class="col-sm-3 col-form-label">Hp</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold"
                                id="customers_phone_number" required>
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="customers_address" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="customers_address">
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class=" row">
                        <label for="total_bayar" class="col-sm-4 col-form-label mt-2 fw-bold">Total
                            Bayar</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext fw-bold" style="font-size: 24px"
                                id="total_bayar" readonly>
                        </div>
                    </div>

                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="tunai"
                            value="tunai" checked>
                        <label class="form-check-label fw-bold" for="tunai"><i class="fa-solid fa-money-bill"></i>
                            Tunai</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="transfer"
                            value="transfer">
                        <label class="form-check-label fw-bold" for="transfer"><i
                                class="fa-solid fa-building-columns"></i> Transfer Bank</label>
                    </div>

                </form>
                <div class="col-12 mt-3">
                    <button type="submit" id="process" class="btn btn-primary mb-1 process"><i
                            class="fa-solid fa-file-export"></i> Proses Tiket</button>

                    <button class="btn btn-primary d-none" type="button" id="loading" disabled>
                        <span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>

            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $("#bus_seats").select2({
                placeholder: ' Pilih Kursi',
            });

            $('#process').on('click', function(e) {
                e.preventDefault();
                $('#process').addClass('d-none');
                $('#loading').removeClass('d-none');
                var price = $('#total_bayar').val().replace(/[Rp.]/g, '');
                var from_city = $('#from_city').val();
                var to_city = $('#to_city').val();
                var date = $('#departure_date').val();
                var bus = $('#id_bus').val();
                if (bus == null) {
                    // return false;
                    $('#process').removeClass('d-none');
                    $('#loading').addClass('d-none');
                } else {
                    bus = bus.split('/')[0];
                }
                var seats_number = $('#seats_number').val();
                var total_seats = $('#bus_seats').val().length;
                var customer_name = $('#tiket_customer_name').val();
                var customers_phone_number = $('#tiket_customers_phone_number').val();
                var customers_address = $('#tiket_costumers_address').val();
                var payment_methods = $('input[name=payment_method]:checked').val();
                var departure_code = $('#id_bus').val().split("/")[4];

                $.ajax({
                    url: '{{ route('store') }}',
                    type: 'POST',
                    data: {
                        price: price,
                        from_city: from_city,
                        to_city: to_city,
                        date: date,
                        bus: bus,
                        seats_number: seats_number,
                        total_seats: total_seats,
                        customer_name: customer_name,
                        customers_phone_number: customers_phone_number,
                        customers_address: customers_address,
                        payment_methods: payment_methods,
                        departure_code: departure_code,

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.errors) {
                            $('#process').removeClass('d-none');
                            $('#loading').addClass('d-none');

                            $('#alert-danger').removeClass('d-none');
                            $('#alert-danger').html("<ul>");
                            $.each(response.errors, function(key, value) {
                                $('#alert-danger').find('ul').append("<li>" + value +
                                    "</li>");
                            });
                            $('#alert-danger').append("</ul>");
                        } else {
                            $('#process').removeClass('d-none');
                            $('#loading').addClass('d-none');
                            $('#form-input-tiket')[0].reset();

                            resetFormInputs()
                            swal({
                                title: 'Pembelian Tiket Berhasil',
                                icon: "success",
                                text: 'Terima kasih',
                            })
                            // $('#alert-danger').addClass('d-none');
                            // $('#alert-success').removeClass('d-none');
                            // $('#alert-success').html(response.success);

                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                })
            });
        });


        $(document).ready(function() {
            sendDate();
        });

        function resetFormInputs() {
            $('#from_city').val('');
            $('#to_city').val('');
            $('#id_bus').val('');
            $('#price').val('');
            $('#bus_seats').val('');
            $('#tiket_customer_name').val('');
            $('#tiket_customers_phone_number').val('');
            $('#tiket_costumers_address').val('');
            $('#total_seats').val('');
            $('#bus_seats').empty();
            $("#to").hide();
        }


        function sendDate() {
            var departureDate = $('#departure_date').val();

            var tanggal = new Date(departureDate);
            var tanggalStr = ('0' + tanggal.getDate()).slice(-2) + '-' + ('0' + (tanggal.getMonth() + 1)).slice(
                -2) + '-' + tanggal.getFullYear();
            $('#date').val(tanggalStr);

            $.ajax({
                url: '{{ route('send_date') }}',
                type: 'POST',
                data: {
                    departure_date: departureDate,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var fromCitySelect = $('#from_city');
                    fromCitySelect.empty();
                    fromCitySelect.append('<option value="" selected disabled>Kota Asal</option>');
                    // console.log(response);
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            fromCitySelect.append('<option value="' + value.from_city +
                                '">' + value
                                .from_city + '</option>');
                        });
                    } else {
                        // fromCitySelect.empty();
                        swal("Jadwal Tidak Tersedia",
                            "Jadwal keberangkatan bus tidak tersedia!", "error");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            $('#from_city').on('change', function() {
                var from_city = $('#from_city').val();
                var departure_date = $('#departure_date').val();
                $('#tiket_from_city').val(from_city);
                $("#to").show();
                $.ajax({
                    url: '{{ route('to_city') }}',
                    type: 'POST',
                    data: {
                        from_city: from_city,
                        departure_date: departure_date,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {

                        var fromCitySelect = $('#to_city');
                        fromCitySelect.empty();

                        fromCitySelect.append(
                            '<option value="" selected disabled>Kota Tujuan</option>'
                        );
                        if (response.length > 0) {
                            $.each(response, function(key, value) {
                                fromCitySelect.append(
                                    '<option value="' + value.to_city +
                                    '">' +
                                    value.to_city + '</option>');
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                })
            });

            $('#to_city').on('change', function() {
                var to_city = $('#to_city').val();
                var from_city = $('#from_city').val();
                var departure_date = $('#departure_date').val();
                $('#tiket_to_city').val(to_city);
                $.ajax({
                    url: '{{ route('get_id_bus') }}',
                    type: 'POST',
                    data: {
                        to_city: to_city,
                        from_city: from_city,
                        departure_date: departure_date,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response)
                        if (response.errors) {
                            swal("Bus Sudah Berangkat",
                                "Tiket tidak tersedia, Bus sudah berangkat!", "warning");
                            // $('#tiket_from_city').val('');
                            $('#tiket_to_city').val('');
                        }
                        var fromBusSelect = $('#id_bus');
                        fromBusSelect.empty();
                        fromBusSelect.append(
                            '<option value="" selected disabled>Bus</option>');

                        if (response.length > 0) {
                            $.each(response, function(key, value) {
                                fromBusSelect.append(
                                    '<option value="' + value.id_bus + '/' + value
                                    .price + '/' + value.bus_name + '/' + value
                                    .plat + '/' + value.departure_code + '">' +
                                    value.bus_name + ' - ' + value
                                    .price +
                                    '</option>'
                                );
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                })
            });

            $('#id_bus').on('change', function() {
                var departure_date = $('#departure_date').val();
                var from_city = $('#from_city').val();
                var to_city = $('#to_city').val();

                var selectedOption = $('#bus_seats').find(':selected');
                var bus_id = $('#id_bus').val().split(' / ')[0];

                var bus_name = $('#id_bus').val().split('/')[2];
                var bus_plat = $('#id_bus').val().split('/')[3];


                $('#tiket_id_bus').val(bus_name + ' | ' + bus_plat);

                $.ajax({
                    url: '{{ route('get_seats_bus') }}',
                    type: 'POST',
                    data: {
                        bus_id: bus_id,
                        from_city: from_city,
                        to_city: to_city,
                        departure_date: departure_date,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.kursi)

                        var fromBusSeatsSelect = $('#bus_seats');
                        fromBusSeatsSelect.empty();

                        if (response.kursi.length > 0) {
                            $.each(response.kursi, function(key, value) {
                                fromBusSeatsSelect.append(
                                    '<option value="' + value + '">' +
                                    value + '</option>'
                                );
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
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

            $('#bus_seats').on('change', function() {
                var seatsSelect = $(this).val();
                var selectedCount = $(this).val().length;
                var price = $('#id_bus').val().split('/')[1];
                var totalPrice = selectedCount * price;
                $('#price').val('Rp' + totalPrice);

                $('#total_bayar').val(totalPrice);

                $('#total_bayar').val(function(index, value) {
                    return 'Rp' + formatRupiah(value.replace(/\D/g, ''));
                });

                $('#seats_number').val(seatsSelect)
            });

            $('#tiket_customer_name').on('input', function() {
                $('#customer_name').val($(this).val());
            });

            function formatNomor(num) {
                var formatted_num = "";
                for (var i = 0; i < num.length; i++) {
                    if (i > 0 && i % 4 == 0) {
                        formatted_num += "-";
                    }
                    formatted_num += num.charAt(i);
                }
                return formatted_num;
            }


            $("#tiket_customers_phone_number").on("input", function() {
                $(this).val(formatNomor($(this).val().replace(/\D/g, "")));
                $("#customers_phone_number").val(
                    formatNomor($(this).val().replace(/\D/g, ""))
                );
            });

            // $("#tiket_customers_phone_number").on("input", function() {
            //     var nomor_hp = $(this).val(); // mengambil nilai dari input
            //     var nomor_hp_formatted = nomor_hp.replace(/(\d{4})/g, "$1-");
            //     nomor_hp_formatted = nomor_hp_formatted.slice(0, -1); // menghapus tanda - pada akhir
            //     $("#customers_phone_number").val(nomor_hp_formatted);
            //     // menampilkan nilai yang sudah diformat ke input
            // });

            $('#tiket_costumers_address').on('input', function() {
                $('#customers_address').val($(this).val());
            });


        });


        // $(document).ready(function() {
        //     $('#bus_seats').select2({
        //         theme: "bootstrap-5",
        //         // width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
        //         //     'style',

        //         placeholder: 'Pilih Kursi',
        //         closeOnSelect: false,
        //     });
        // });
    </script>
@endsection
