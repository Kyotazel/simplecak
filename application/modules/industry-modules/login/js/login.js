var controller = 'login';
var url_controller = baseUrl + '/' + 'industry-area' + '/' + controller + '/';

var save_method;
var id_use = 0;

$(document).ready(function () {
    
});


$('.btn-sign-in').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-login')[0]);
    
    $.ajax({
        url: url_controller+'do_login',
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            // console.log(data); return;
            if(data.status){
                location.href = baseUrl + '/' + 'industry-area' + '/?token='+data.token;
            } else {
                if (data.error_login != '') {
                    $('.text-message').html(data.error_login);
                }
                
                if (data.status_forgot_password) {
                    location.href = url_controller + 'forgot_password';
                }
                
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

$('.btn-sign-up').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-register')[0]);
    
    $.ajax({
        url: url_controller+'do_register',
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            // console.log(data); return;
            if (data.status) {
                swal({
                    title: "Pembuatan Akun Berhasil",
                    text: "Klik tombol dibawah untuk kembali ke halaman Login",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Halaman Login",
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
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});


$('.btn-send-email').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-reset')[0]);
    showLoading();
    
    $.ajax({
        url: url_controller+'send_email',
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $('.html_respon').html(data.html_respon);
            } else {
                if (data.error_login != '') {
                    $('.text-message').html(data.error_login);
                }
                
                if (data.status_forgot_password) {
                    location.href = url_controller + 'forgot_password';
                }
                
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});


$('.btn-reset').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');
	  //defined form
    var id = $(this).data('id');
    var formData = new FormData($('.form-reset-password')[0]);
    formData.append('id', id);
    showLoading();
    
    $.ajax({
        url: url_controller+'do_reset_password',
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                location.href = url_controller;
            } else {
                if (data.error_login != '') {
                    $('.text-message').html(data.error_login);
                }
                
                if (data.status_forgot_password) {
                    location.href = url_controller + 'forgot_password';
                }
                
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});


$(document).on('change', '.upload_background', function () { 
    var type = $(this).data('type');
    var formData = new FormData($('.form_update_background')[0]);
    formData.append('type', type);
    $.ajax({
        url: url_controller+'update_image'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                location.reload();
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            // $('.btn_save_group').button('reset');
        }
	});//end ajax
});

$(document).on('change', '.upload_image', function () { 
    var type = $(this).data('type');
    var formData = new FormData($('.form_update_image')[0]);
    formData.append('type', type);
    $.ajax({
        url: url_controller+'update_image'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                location.reload();
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            // $('.btn_save_group').button('reset');
        }
	});//end ajax
});

$(document).on('click', '.btn_remove_image', function () {
    var type = $(this).data('type');

    $.ajax({
        url: url_controller+'delete_image'+'/?token='+_token_user,
        type: "POST",
        data: {'type':type},
        dataType :"JSON",
        success: function(data){
            if(data.status){
                location.reload();
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            // $('.btn_save_group').button('reset');
        }
	});//end ajax
});