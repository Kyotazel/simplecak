var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {
    var type = $('.container_list').data('type');
    table = $('#table_module').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+'?token='+_token_user,
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
    var status_menu = $(this).data('status');
	  //defined form
    var formData = new FormData($('.form_input')[0]);
    var url;
    if(save_method=='add'){
        url = 'save';
    }else{
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'?token='+_token_user,
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
                table.ajax.reload(null, false);
                $('#modal_form').modal('hide');
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
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

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_data'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
            if (data.status) {
                
                $('[name="name"]').val(data.name);
                $('[name="description"]').val(data.description);
                $('[name="folder"]').val(data.directory);
                $('[name="module_type"]').val(data.type);
                $('#modal_form').modal('show');

            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
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
                url: url_controller+'delete_data'+'?token='+_token_user,
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
    var id = $(this).data('id');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id,'status':active_status},
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
});

