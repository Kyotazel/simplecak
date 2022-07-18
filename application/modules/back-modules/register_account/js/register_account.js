var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-group").removeClass('has-danger');
    $('.help-block').empty();
    var formData = new FormData($('.form_input')[0]);
    var url;
    var status;
    if(save_method == 'add') {
        url = 'save';
        status = "Ditambahkan";
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', id_use);
    }

    $.ajax({
        url: url_controller+url+'?token'+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                notif({
                    msg: `<b>Sukses : </b> Data berhasil ${status}`,
                    type: "success"
                })
                table.ajax.reload(null, false);
                $("#modal_form").modal("hide");
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass("has-danger");
                    $('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$("#provinsi_asal").on("change", function() {
    var provinsi = $(this).val();

    $.ajax({
        url: url_controller+"get_kota"+"?token="+_token_user,
        type: "POST",
        data: {provinsi: provinsi},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Kota Asal -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#kota_asal").html(html);
        }
    });
})

$("#kota_asal").on("change", function() {
    var kota = $(this).val();

    $.ajax({
        url: url_controller+"get_kecamatan"+"?token="+_token_user,
        type: "POST",
        data: {kota: kota},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Kecamatan Asal -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#kecamatan_asal").html(html);
        }
    });
})

$("#kecamatan_asal").on("change", function() {
    var kecamatan = $(this).val();

    $.ajax({
        url: url_controller+"get_desa"+"?token="+_token_user,
        type: "POST",
        data: {kecamatan: kecamatan},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Desa Asal -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#desa_asal").html(html);
        }
    });
})

$("#provinsi_sekarang").on("change", function() {
    var provinsi = $(this).val();

    $.ajax({
        url: url_controller+"get_kota"+"?token="+_token_user,
        type: "POST",
        data: {provinsi: provinsi},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Kota Sekarang -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#kota_sekarang").html(html);
        }
    });
})

$("#kota_sekarang").on("change", function() {
    var kota = $(this).val();

    $.ajax({
        url: url_controller+"get_kecamatan"+"?token="+_token_user,
        type: "POST",
        data: {kota: kota},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Kecamatan Sekarang -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#kecamatan_sekarang").html(html);
        }
    });
})

$("#kecamatan_sekarang").on("change", function() {
    var kecamatan = $(this).val();

    $.ajax({
        url: url_controller+"get_desa"+"?token="+_token_user,
        type: "POST",
        data: {kecamatan: kecamatan},
        dataType: "JSON",
        success: function(data) {
            var html = '<option value="">-- Pilih Desa Sekarang -- </option>';
            for(i = 0; i < data.length; i++) {
                html += `<option value=${data[i]["id"]}>${data[i]["name"]}</option>`;
            }
            $("#desa_sekarang").html(html);
        }
    });
})