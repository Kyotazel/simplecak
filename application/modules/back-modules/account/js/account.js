var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function() {
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+"?token="+_token_user,
            "type": "POST",
        },
        "columns" : [
            { "width": "10%" },
            { "width": "15%" },
            { "width": "20%" },
            { "width": "15%" },   
            { "width": "15%" },   
            { "width": "10%" },
            { "width": "15%" },
        ],
        "columnDefs" : [
            {
                "targets": [5,6],
                "className": "text-center"
            }            
        ]
    })
})

$(document).on('click', '#confirm_account', function () {
    id = $(this).data('id');
    $.ajax({
        url: url_controller + "update_confirm" + "?token=" + _token_user,
        type: "POST",
        data: {id: id},
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                notif({
                    msg: `<b>Sukses : </b> Data berhasil Dikonfirmasi`,
                    type: "success"
                })
                table.ajax.reload(null, false);
            }
        }
    })
})

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form-input')[0]);
    var url;
    var status;
    save_method = $(this).data('method');
    if(save_method == 'add') {
        url = 'save';
        status = "Ditambahkan";
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', $(this).data('id'));
    }

    $.ajax({
        url: url_controller + url + '?token' + _token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                swal({
                    title: "Edit Berhasil",
                    text: "Klik tombol dibawah untuk ke daftar member",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Halaman daftar",
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

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    $('.help-block').empty();
	$('.form-group').removeClass('has-danger');
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_data'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data: {'id':id},
        success: function(data) {
            if (data.status) {
                // kunci = Object.keys(data.data)[1]
                // console.log(kunci);
                // console.log(data.data.kunci);
                $('[name="no_ktp"]').val(data.data.no_ktp);
                $('[name="no_kk"]').val(data.data.no_kk);
                $('[name="id_skill"]').val(data.skill.id_skill);
                $('[name="name"]').val(data.data.name);
                $('[name="id_last_education"]').val(data.data.id_last_education);
                $('[name="last_school"]').val(data.data.last_school);
                $('[name="email"]').val(data.data.email);
                $('[name="birth_place"]').val(data.data.birth_place);
                $('[name="birth_date"]').val(data.data.birth_date);
                $('[name="gender"]').val(data.data.gender);
                $('[name="religion"]').val(data.data.religion);
                $('[name="married_status"]').val(data.data.married_status);
                $('[name="id_province"]').val(data.data.id_province);
                $('[name="id_city"]').val(data.data.id_city);
                $('[name="id_regency"]').val(data.data.id_regency);
                $('[name="id_village"]').val(data.data.id_village);
                $('[name="address"]').val(data.data.address);
                $('[name="id_province_current"]').val(data.data.id_province_current);
                $('[name="id_city_current"]').val(data.data.id_city_current);
                $('[name="id_regency_current"]').val(data.data.id_regency_current);
                $('[name="id_village_current"]').val(data.data.id_village_current);
                $('[name="address_current"]').val(data.data.address_current);
                $('#modal_form').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {}
    })
})


$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    var redirect = $(this).data('redirect');
    swal({
        title: "Apakah anda yakin?",
        text: "data akan dihapus!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya , Lanjutkan",
        cancelButtonText: "Batal",
        closeOnConfirm: true,
        closeOnCancel: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url_controller + 'delete_data' + '?token=' + _token_user,
                    type: "POST",
                    dataType: "JSON",
                    data: { 'id': id },
                    success: function (data) {
                        if (data.status) {
                            notif({
                                msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                                type: "success"
                            })

                            if (redirect == 1) {
                                location.href = url_controller;
                            } else {
                                table.ajax.reload(null, false);
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                })
            }
        }
    )
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