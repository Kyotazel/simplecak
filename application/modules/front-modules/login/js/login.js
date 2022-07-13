var controller = 'login';
var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + controller + '/';
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
            if(data.status){
                location.href = baseUrl + '/' + prefix_folder_admin + '/?token='+data.token;
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