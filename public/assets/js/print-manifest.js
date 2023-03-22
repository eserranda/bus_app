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

        error: function (xhr, ajaxOptions, thrownError) {
            swal("Oops...", "Manifest sudah tidak tersedia!", "error");
            console.log(
                xhr.status + "\n" + xhr.responseText + "\n" + thrownError
            );
        },
    });
}
