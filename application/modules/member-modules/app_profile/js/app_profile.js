var url_controller = baseUrl + '/' + "member-area" + '/' + _controller + '/';
var save_method;
var id_use = 0;

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form-input')[0]);

    $.ajax({
        url: url_controller + "update" + '?token' + _token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                swal({
                    title: "Edit Berhasil",
                    text: "Klik tombol dibawah untuk ke Menu Profile",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Halaman Profile",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                    function (isConfirm) {
                        location.href = url_controller;
                    }
                );
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$('.btn_save_password').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form-password')[0]);

    $.ajax({
        url: url_controller + "update_password" + '?token' + _token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                swal({
                    title: "Password Berhasil Diperbarui",
                    text: "Klik tombol dibawah untuk ke Menu Profile",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Halaman Profile",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                    function (isConfirm) {
                        location.href = url_controller;
                    }
                );
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$("#id_province").on("change", function () {
    var provinsi = $(this).val();

    $.ajax({
        url: url_controller + "get_kota" + "?token=" + _token_user,
        type: "POST",
        data: { provinsi: provinsi },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Kota Asal -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_city").html(html);
        }
    });
})

$("#id_city").on("change", function () {
    var kota = $(this).val();

    $.ajax({
        url: url_controller + "get_kecamatan" + "?token=" + _token_user,
        type: "POST",
        data: { kota: kota },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Kecamatan Asal -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_regency").html(html);
        }
    });
})

$("#id_regency").on("change", function () {
    var kecamatan = $(this).val();

    $.ajax({
        url: url_controller + "get_desa" + "?token=" + _token_user,
        type: "POST",
        data: { kecamatan: kecamatan },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Desa Asal -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_village").html(html);
        }
    });
})

$("#id_province_current").on("change", function () {
    var provinsi = $(this).val();

    $.ajax({
        url: url_controller + "get_kota" + "?token=" + _token_user,
        type: "POST",
        data: { provinsi: provinsi },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Kota Sekarang -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_city_current").html(html);
        }
    });
})

$("#id_city_current").on("change", function () {
    var kota = $(this).val();

    $.ajax({
        url: url_controller + "get_kecamatan" + "?token=" + _token_user,
        type: "POST",
        data: { kota: kota },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Kecamatan Sekarang -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_regency_current").html(html);
        }
    });
})

$("#id_regency_current").on("change", function () {
    var kecamatan = $(this).val();

    $.ajax({
        url: url_controller + "get_desa" + "?token=" + _token_user,
        type: "POST",
        data: { kecamatan: kecamatan },
        dataType: "JSON",
        success: function (data) {
            var html = '<option value="">-- Pilih Desa Sekarang -- </option>';
            for (i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#id_village_current").html(html);
        }
    });
})