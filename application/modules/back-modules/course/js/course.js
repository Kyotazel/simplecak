var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function () {
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller + "list_data" + "?token=" + _token_user,
            "type": "POST",
        },
        "columns": [
            { "width": "10%" },
            { "width": "25%" },
            { "width": "30%" },
            { "width": "20%" },
            { "width": "15%" }
        ],
        "columnDefs": [
            {
                "targets": 4,
                "className": "text-center"
            }
        ]
    })
})

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form_input')[0]);
    var url;
    var status;
    save_method = $(this).data('method');
    var description = CKEDITOR.instances['description'].getData();
    if (save_method === 'add') {
        url = 'save';
        status = "Ditambahkan";
        formData.append('description', description);
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', $(this).data('id'));
        formData.append('description', description);
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
                notif({
                    msg: `<b>Sukses : </b> Data berhasil ${status}`,
                    type: "success"
                })
                location.href = data.redirect;
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
    $(".form-group").removeClass('is-invalid');
    $('.invalid-feedback').empty();
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
                $('[name="name"]').val(data.course.name);
                $('[name="description"]').val(data.course.description);
                $('[name="id_category_course"]').val(data.course.id_category_course);
                $('[name="skill"]').val(data.skill.id_skill);
                $('#modal_form').modal('show');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { }
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