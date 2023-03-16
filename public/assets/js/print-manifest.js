function printManifest(id) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "post",
        url: "/admin/keberangkatan-manifest/" + id,
        dataType: "json",

        success: function (data) {
            var url = "/manifest?data=";
            url += encodeURIComponent(JSON.stringify(data.data));
            url += "&rute=";
            url += encodeURIComponent(JSON.stringify(data.rute));
            window.open(url, "/admin/manifest");
        },

        // success: function(data) {
        //     console.log(data.data);
        //     for (var i = 0; i < data.data.length; i++) {
        //         var row = $("<tr>");
        //         row.append($("<td>").text(data.data[i].customer_name));
        //         row.append($("<td>").text(data.data[i].customers_phone_number));
        //         row.append($("<td>").text(data.data[i].seats_number));
        //         row.append($("<td>").text(data.data[i].customers_address));
        //         row.append($("<td>").append($('<input type="checkbox">')));
        //         tableBody.append(row);
        //     }
        // },
        error: function (xhr, ajaxOptions, thrownError) {
            swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
            console.log(
                xhr.status + "\n" + xhr.responseText + "\n" + thrownError
            );
        },
    });
}
