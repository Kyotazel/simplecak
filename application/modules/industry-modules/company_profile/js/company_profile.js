var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {
    load_service();
});


$('.btn_update_profile').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-profile')[0]);

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
                hideLoading();
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});


$('.btn_update_sosmed').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-sosmed')[0]);

    $.ajax({
        url: url_controller+'update_sosmed'+'/?token='+_token_user,
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
                hideLoading();
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});

$('.btn-add-service').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-service')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_service').modal('show');
});


function load_service() {
    showLoading();
    $.ajax({
        url: url_controller+'list_service'+'/?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $('#tbody-service').html(data.html_respon);
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}

$('.btn_save_service').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    // save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('#form-service')[0]);
    var url;
    if(save_method=='add'){
        url = 'save_service';
    }else{
        url = 'update_service';
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
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                $('#modal_service').modal('hide');
                load_service();

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

$(document).on('click', '.btn_edit_service', function () {
    showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    id_use = $(this).data('id');
    save_method = 'update';
    $.ajax({
        url: url_controller+'get_data_service'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id_use},
        success: function (data) {
            hideLoading();
            $('[name="title"]').val(data.name);
            $('[name="description"]').val(data.description);
            $('#modal_service').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }

    });//end ajax
});

$(document).on('click', '.btn_delete_service', function () {
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
            showLoading();
            $.ajax({
                url: url_controller+'delete_service'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
                success: function (data) {
                    hideLoading();
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        load_service();
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                    hideLoading();
                }

            });//end ajax
        }
    });
    
});

$(document).on('click', '.btn_save_description', function () { 
    var content = CKEDITOR.instances['content_profile'].getData();
    var content_short = CKEDITOR.instances['content_short_profile'].getData();
    
    
   var PostData = {'content':content,'content_short':content_short};
    $.ajax({
        url:  url_controller+'update_description/?token='+_token_user,
        type: "POST",
        data: PostData,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                alert_success('Data Berhasil Disimpan');
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            alert_error('error process');
        }

    });//end ajax
});

$(document).on('change', '.upload_form', function () { 
    var formData = new FormData($('.form_update_front_profile')[0]);
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