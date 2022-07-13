var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

var field = '';
var data_type = '';

$(document).ready(function () {
    var type = $('.container_list').data('type');
    // table = $('#table_module').DataTable({
    //     "ajax": {
    //         "url": url_controller+"list_data"+'/?token='+_token_user,
    //         "type": "POST",
    //         "data":{'type':type}
    //     }
    // });
});


$('.btn_add').click(function () {
    save_method = 'add';

	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-data-main')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form_main').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    data_type = $(this).data('type');

	  //defined form
    var formData = new FormData($('#form-data-main')[0]);
    formData.append('data_type', data_type);

    $.ajax({
        url: url_controller+'save/?token='+_token_user,
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



$('.btn_add_content').click(function () {
    save_method = 'add';
    field = $(this).data('field');
    data_type = $(this).data('type');

	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-data')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

$('.btn_save_content').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
	  //defined form
    var formData = new FormData($('#form-data')[0]);
    formData.append('data_type', data_type);
    formData.append('field', field);

    
    if(save_method=='add'){
        url = 'save';
    }else{
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+'save/?token='+_token_user,
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

$('.btn_update_content').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var id = $(this).data('id');
    var value = $('.value_' + id).val();
    var param = $('.param_' + id).val();
    var label = $('.label_' + id).val();

    $.ajax({
        url: url_controller+'update/?token='+_token_user,
        type: "POST",
        data: {
            'id': id,
            'label': label,
            'param': param,
            'value':value
        },
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});


$(document).on('click', '.btn_delete_content', function () {
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
                        location.reload();
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

