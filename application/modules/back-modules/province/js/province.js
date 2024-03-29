var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function() {
    table = $('#table_data').DataTable({
        "responsive": true,
        "ajax": {
            "url": url_controller+"list_data"+"?token="+_token_user,
            "type": "POST",
        },
        "columns" : [
            { "width": "10%" },
            { "width": "70%" },
            { "width": "20%" },
        ],
        "columnDefs" : [
            {
                "targets": 2,
                "className": "text-center"
            }            
        ]
    })
})

$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();
 	$('.form_input')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
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
                    $('[name="'+data.inputerror[i]+'"]').addClass("is-invalid");
                    $('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    $('.invalid-feedback').empty();
	$('.form-control').removeClass('is-invalid');
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
                $('[name="name"]').val(data.data.name);
                $('#modal_form').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {}
    })
})

$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
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
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url_controller+'delete_data'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data: {'id': id},
                success: function(data) {
                    if(data.status) {
                        notif({
                            msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                            type: "success"
                        })
                        table.ajax.reload(null, false);
                    }
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }
            })
        }
    }
    )
})