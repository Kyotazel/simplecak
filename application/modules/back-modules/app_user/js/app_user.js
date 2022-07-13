var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {
    var type = $('.container_list').data('type');
    table = $('#table_module').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+'/?token='+_token_user,
            "type": "POST",
            "data":{'type':type}
        }
    });
});


$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('.form_input')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-input')[0]);
    var url;
    if(save_method=='add'){
        url = 'save';
    }else{
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                location.href = url_controller+'/?token='+_token_user;
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});

$('.btn_update_profile').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var formData = new FormData($('.form-update-profile')[0]);
    formData.append('id', $(this).data('id'));
    $.ajax({
        url: url_controller+'update_profile'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                location.reload();
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});

$('.btn_save_login').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var formData = new FormData($('.form-login')[0]);
    formData.append('id', $(this).data('id'));
    $.ajax({
        url: url_controller+'update_login'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                location.reload();
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});

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
                url: url_controller+'delete_data'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id,'status_group':true},
                success: function(data){
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        table.ajax.reload(null, false);
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }

            });//end ajax
        }
    });
});

$(document).on('click', '.change_status', function () {
    var selector = $(this);
    $(this).toggleClass('on');
    update_status(selector)
    
});
$(document).on('click', '.change_status_detail', function () {
    var selector = $(this);
    $(this).toggleClass('on');
    update_status(selector)
    
});

function update_status(selector) {
    var id = selector.data('id');
    var field = selector.data('status');
    active_status = selector.hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id,'status':active_status,'field':field},
        success: function(data){
            if (data.status) {
                notif({
                    msg: "<b>Sukses :</b> Data berhasil diupdate",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
}

