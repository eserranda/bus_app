function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return rupiah;
}

$(document).ready(function () {
    $("#update").on("click", function () {
        // $("#update").addClass("d-none");
        // $("#loading").removeClass("d-none");
        var biaya_tambahan = $("#biaya_tambahan")
            .val()
            .replace(/-/g, "")
            .replace(/[Rp.]/g, "");

        var from_city = $("#tiket_from_city").val();
        var no_ticket = $("#no_ticket").val();
        var to_city = $("#tiket_to_city").val();
        var date = $("#departure_date").val();
        var bus = $("#id_bus").val();
        if (bus == null) {
            var bus = $("#tiket_id_bus").val();
        } else {
            var bus = bus.split("/")[0];
        }
        var price = $("#total_bayar").val().replace(/[Rp.]/g, "");
        var seats_number = $("#seats_number").val();
        var total_seats = $("#total_passeger").val();
        var customer_name = $("#tiket_customer_name").val();
        var customers_phone_number = $("#customers_phone_number").val();
        var customers_address = $("#tiket_costumers_address").val();
        var payment_methods = $("input[name=payment_method]:checked").val();
        if (!payment_methods) {
            var payment_methods = $("#payment_methods").val();
        }
        // var departure_code = $("#tiket_departure_code").val();
        // var departure_code = $("#id_bus").val().split("/")[4];
        var departure_code = $("#id_bus").val();
        if (departure_code == null) {
            var departure_code = $("#tiket_departure_code").val();
        } else {
            var departure_code = $("#id_bus").val().split("/")[4];
        }
        // alert(departure_code);
        var id = $("#id_tiket").val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/admin/pemesanan-tiket-update/" + id,
            type: "put",
            data: {
                biaya_tambahan: biaya_tambahan,
                no_ticket: no_ticket,
                from_city: from_city,
                price: price,
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
            },
            dataType: "json",
            success: function (response) {
                if (response.errors) {
                    $("#process").removeClass("d-none");
                    $("#loading").addClass("d-none");

                    $("#alert-danger").removeClass("d-none");
                    $("#alert-danger").html("<ul>");
                    $.each(response.errors, function (key, value) {
                        $("#alert-danger")
                            .find("ul")
                            .append("<li>" + value + "</li>");
                    });
                    $("#alert-danger").append("</ul>");
                } else {
                    swal({
                        title: "Success!",
                        text: "Tiket Berhasil di Update",
                        icon: "success",
                        buttons: false,
                        timer: 1000,
                    });

                    setTimeout(function () {
                        window.location.replace("/admin/data-pemesanan-tiket");
                    }, 1000);
                    $("#alert-danger").addClass("d-none");
                    $("#alert-success").removeClass("d-none");
                    $("#alert-success").html(response.success);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                );
            },
        });
    });

    var dataPrice = parseFloat($("#harga_tiket").val());
    var total_passeger = parseFloat($("#total_passeger").val());
    $("#harga_tiket").val(total_passeger + " x " + dataPrice);
    $("#departure_date").on("change", function () {
        // sendDate();
        var departureDate = $("#departure_date").val();
        var tanggal = new Date(departureDate);
        var tanggalStr =
            ("0" + tanggal.getDate()).slice(-2) +
            "-" +
            ("0" + (tanggal.getMonth() + 1)).slice(-2) +
            "-" +
            tanggal.getFullYear();
        $("#date").val(tanggalStr);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/admin/ajax_req_all_data",
            type: "post",
            data: {
                departure_date: departureDate,
            },
            success: function (response) {
                console.log(response);
                $("#from_city").val("");
                var fromCitySelect = $("#from_city");
                fromCitySelect.empty();
                fromCitySelect.append(
                    '<option value="" selected disabled>Pilih Kota Asal</option>'
                );
                // var toCitySelect = $("#to_city");
                // toCitySelect.empty();
                if (response.data_city.length > 0) {
                    $.each(response.data_city, function (key, value) {
                        fromCitySelect.append(
                            '<option value="' +
                                value.from_city +
                                '">' +
                                value.from_city +
                                "</option>"
                        );
                    });

                    var to_city = $("#from_city").val();
                    if (to_city != "") {
                        // alert(to_city);
                    }
                } else {
                    fromCitySelect.empty();
                    $("#from_city").append(
                        '<option value="" selected disabled>Jadwal tidak ditemukan!</option>'
                    );
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });

    // Krtika Kota asal di pilih
    $("#from_city").on("change", function () {
        var from_city = $("#from_city").val();
        var departure_date = $("#departure_date").val();
        $("#tiket_from_city").val(from_city);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/admin/get_to_City",
            type: "POST",
            data: {
                from_city: from_city,
                departure_date: departure_date,
            },
            dataType: "json",
            success: function (response) {
                var fromCitySelect = $("#to_city");
                fromCitySelect.empty();

                fromCitySelect.append(
                    '<option value="" selected disabled>Kota Tujuan</option>'
                );
                if (response.length > 0) {
                    $.each(response, function (key, value) {
                        fromCitySelect.append(
                            '<option value="' +
                                value.to_city +
                                '">' +
                                value.to_city +
                                "</option>"
                        );
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                );
            },
        });
    });

    $("#to_city").on("change", function () {
        var to_city = $("#to_city").val();
        var from_city = $("#from_city").val();
        var departure_date = $("#departure_date").val();
        $("#tiket_to_city").val(to_city);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/admin/get_id_bus",
            type: "POST",
            data: {
                to_city: to_city,
                from_city: from_city,
                departure_date: departure_date,
            },
            dataType: "json",
            success: function (response) {
                // console.log(response)
                if (response.errors) {
                    swal(
                        "Bus Sudah Berangkat",
                        "Tiket tidak tersedia, Bus sudah berangkat!",
                        "warning"
                    );
                    $("#tiket_from_city").val("");
                    $("#tiket_to_city").val("");
                }
                var fromBusSelect = $("#id_bus");
                fromBusSelect.empty();
                fromBusSelect.append(
                    '<option value="" selected disabled>Pilih Bus</option>'
                );

                if (response.length > 0) {
                    $.each(response, function (key, value) {
                        fromBusSelect.append(
                            '<option value="' +
                                value.id_bus +
                                "/" +
                                value.price +
                                "/" +
                                value.bus_name +
                                "/" +
                                value.plat +
                                "/" +
                                value.departure_code +
                                '">' +
                                value.bus_name +
                                " - " +
                                value.price +
                                "</option>"
                        );
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                );
            },
        });
    });

    $("#id_bus").on("change", function () {
        $("#biaya_tambahan").val("");
        $("#Payment").hide();
        var total_passeger = parseFloat($("#total_passeger").val());
        var price = parseFloat($("#id_bus").val().split("/")[1]);
        var dataPrice = parseFloat($("#harga_tiket").val().split("x")[1]);
        // var dataPrice = $("#total_bayar").val().replace(/[Rp.]/g, "");

        if (price != dataPrice) {
            if (price > dataPrice) {
                var tambahan = price - dataPrice;
                var final_total = tambahan * total_passeger;
                $("#biaya_tambahan").val(final_total);
                $("#biaya_tambahan").val(function (index, value) {
                    return "Rp" + formatRupiah(value.replace(/\D/g, ""));
                });
                $("#Payment").show();
                // alert(final_total);
            } else if (price <= dataPrice) {
                $("#biaya_tambahan").val("-");
                $("#Payment").hide();
            }
        }

        var departure_date = $("#departure_date").val();
        var from_city = $("#from_city").val();
        var to_city = $("#to_city").val();

        // var seats_number = $("#seats_number").val();
        // var seatsArray = seats_number.split(","); // memisahkan data berdasarkan koma
        // var seatsCount = seatsArray.length; // menghitung jumlah data pada array

        var bus_id = $("#id_bus").val().split(" / ")[0];
        var bus_name = $("#id_bus").val().split("/")[2];
        var bus_plat = $("#id_bus").val().split("/")[3];

        $("#tiket_id_bus").val(bus_name + " | " + bus_plat);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/admin/get_seats_bus",
            type: "POST",
            data: {
                bus_id: bus_id,
                from_city: from_city,
                to_city: to_city,
                departure_date: departure_date,
                price: price,
            },
            dataType: "json",
            success: function (response) {
                console.log(response.kursi);

                var fromBusSeatsSelect = $("#bus_seats");
                fromBusSeatsSelect.empty();

                if (response.kursi.length > 0) {
                    $.each(response.kursi, function (key, value) {
                        fromBusSeatsSelect.append(
                            '<option value="' +
                                value +
                                '">' +
                                value +
                                "</option>"
                        );
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(
                    xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                );
            },
        });
    });

    $("#bus_seats").on("change", function () {
        var selectedCount = $(this).val().length;
        var seatsTotal = $("#total_passeger").val();
        // var price = $("#id_bus").val().split("/")[1];
        if (selectedCount >= seatsTotal) {
            // menonaktifkan opsi yang belum dipilih
            $("#bus_seats option:not(:selected)").prop("disabled", true);
            // memperbarui tampilan select2
            $("#bus_seats").trigger("change.select2");
        } else {
            // mengaktifkan kembali semua opsi
            $("#bus_seats option").prop("disabled", false);
        }
        // set nilai ke input form
        var seatsSelect = $(this).val();
        $("#seats_number").val(seatsSelect);
    });

    $("#tiket_customer_name").on("input", function () {
        $("#customer_name").val($(this).val());
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

    $("#tiket_customers_phone_number").on("input", function () {
        $(this).val(formatNomor($(this).val().replace(/\D/g, "")));
        $("#customers_phone_number").val(
            formatNomor($(this).val().replace(/\D/g, ""))
        );
    });

    $("#tiket_costumers_address").on("input", function () {
        $("#customers_address").val($(this).val());
    });
});

$(document).ready(function () {
    $("#bus_seats").select2({
        placeholder: " Pilih Kursi",
    });
});
