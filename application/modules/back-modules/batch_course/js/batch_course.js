var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
table_add = $('#table_add').DataTable({});
table_peserta = $('#table_peserta').DataTable({});

$(document).ready(function () {
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller + "list_data" + "?token=" + _token_user,
            "type": "POST",
        },
        "columns": [
            { "width": "10%" },
            { "width": "15%" },
            { "width": "20%" },
            { "width": "30%" },
            { "width": "10%" },
            { "width": "15%" },
        ],
        "columnDefs": [
            {
                "targets": 5,
                "className": "text-center"
            }
        ]
    })
})

$(".btn_tambah").on("click", function () {
    save_method = 'add';
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('.form-input')[0].reset();
    $('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
})

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    $('.help-block').empty();
    $('.form-group').removeClass('has-danger');
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller + 'get_data' + '?token=' + _token_user,
        type: "POST",
        dataType: "JSON",
        data: { 'id': id },
        success: function (data) {
            if (data.status) {
                $('[name="id_course"]').val(data.data.id_course);
                $('[name="title"]').val(data.data.title);
                $('[name="description"]').val(data.data.description);
                $('[name="target_registrant"]').val(data.data.target_registrant);
                $('[name="opening_registration_date"]').val(data.data.opening_registration_date);
                $('[name="closing_registration_date"]').val(data.data.closing_registration_date);
                $('[name="starting_date"]').val(data.data.starting_date);
                $('[name="ending_date"]').val(data.data.ending_date);
                $('#modal_form').modal('show');

            }
        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
})

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form-input')[0]);
    var url;
    var status;
    if (save_method == 'add') {
        url = 'save';
        status = "Ditambahkan";
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', id_use);
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

$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    console.log(id);
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
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                })
            }
        }
    )
})

function modal_tambah(batch_course) {
    table_add.destroy();
    $("#modal_tambah").modal("show");
    table_add = $('#table_add').DataTable({
        "ajax": {
            "url": url_controller + "get_add" + "?token=" + _token_user,
            "type": "POST",
            "data": {id_batch_course: batch_course}
        }
    })
}

function modal_peserta(batch_course) {
    console.log("Tes Berhasil");
    table_peserta.destroy();
    $("#modal_peserta").modal("show");
    table_peserta = $("#table_peserta").DataTable({
        "ajax" : {
            "url": url_controller + "get_peserta" + "?token=" + _token_user,
            "type": "POST",
            "data": {id_batch_course: batch_course}
        },
        "columnDefs": [
            {
                "targets": 3,
                "className": "text-center"
            }
        ]
    })
}

function add_to_batch(account, batch) {
    $.ajax({
        url: url_controller + "add_account_batch" + "?token=" + _token_user,
        data: {id_account: account, id_batch: batch},
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            notif({
                msg: `<b>Sukses : </b> Peserta berhasil ditambahkan`,
                type: "success"
            })
            table.ajax.reload(null, false);
            $("#modal_tambah").modal("hide");
        }
    })
}

$(document).on('click', '.btn_delete_peserta', function () {
    id = $(this).data("id");
    $.ajax({
        url: url_controller + "delete_peserta" + "?token=" + _token_user,
        type: "POST",
        dataType: "JSON",
        data: {id: id},
        success: function(data) {
            notif({
                msg: `<b>Sukses : </b> Peserta berhasil dihapus`,
                type: "success"
            })
            table_peserta.ajax.reload(null, false);
            table.ajax.reload(null, false);
        }
    })
})