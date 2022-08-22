var url_controller = baseUrl + '/' + prefix_folder_admin + '/';
var save_method;
var id_use = 0;
var table;
var id_batch = $("#id_batch").val();
table = $('#table_data').DataTable({})

$(document).ready(function () {
    
    table.destroy();
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller + "batch_course/schedule/list_data/" + id_batch + "?token=" + _token_user,
            "type": "POST",
        },
        "columnDefs": [
            {
                "targets": [2, 3, 4, 5],
                "className": "text-center"
            }
        ]
    })
})

$(document).on('click', '.popupqrcode', function (e) {
    e.preventDefault();
    $('.modal img').attr('src', $(this).attr('src'))
    $('.modal').modal('show');
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
        url: url_controller + "batch_course/schedule/" + url + '?token' + _token_user,
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
                    url: url_controller + "batch_course/schedule/"  + 'delete_data' + '?token=' + _token_user,
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