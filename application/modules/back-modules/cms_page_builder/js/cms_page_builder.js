var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;



$(document).ready(function () {
    load_data();

});

function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}

function load_data() {
    showLoading();
    $.ajax({
        url: url_controller+'load_data/?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $('.html_respon').html(data.html_respon);
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}


$('.btn_save').click(function (e) {
    var selector = $(this);
    e.preventDefault();
    showLoading();
    var act = $(this).data('act');
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    // save_method = $(this).data('method');
	  //defined form
    var content  =  CKEDITOR.instances['content'].getData();
    var formData = new FormData($('#form-data')[0]);
    formData.append('content', content);

    var url;
    if(act=='add'){
        url = 'save';
    }else{
        url = 'update';
        id_use = selector.data('id');
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                location.href = url_controller;
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('.notif_'+data.inputerror[i]).parent().addClass('has-danger');
                    $('.notif_'+data.inputerror[i]).text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});

$(document).on('click', '.btn_edit', function () {
    showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form-data')[0].reset();
    id = $(this).data('id');
    save_method = 'update';
    $.ajax({
        url: url_controller+'get_data'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function (data) {
            hideLoading();
            console.log(data);
            id_use = data.id;
            $('[name="name"]').val(data.name);
            $('[name="description"]').val(data.description);
            $('[name="position_text"]').val(data.position_text);
            $('#modal_form').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
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
                        load_data();
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
    // $(this).toggleClass('on');
    $('.change_status').removeClass('on');
    selector.addClass('on');
    var id = selector.data('id');
    active_status = selector.hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'/?token='+_token_user,
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


$(document).on('change', '.upload_background', function () { 
    alert('ok');
    return false;
    var formData = new FormData($('.form_update_image_profile')[0]);
    formData.append('id', $(this).data('id'));
    $.ajax({
        url: url_controller+'update_image'+'/?token='+_token_user,
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
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            // $('.btn_save_group').button('reset');
        }
	});//end ajax
});
