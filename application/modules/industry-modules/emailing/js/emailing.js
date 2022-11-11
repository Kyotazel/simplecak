var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function () {
    load_data();
});

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

$(document).on('click', '.btn_update_email', function (e) {
    e.preventDefault();
    var selector = $(this);
    e.preventDefault();
    showLoading();
    var act = $(this).data('act');
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
	  //defined form
    var content  =  CKEDITOR.instances['content'].getData();
    var formData = new FormData($('#form-data')[0]);
    formData.append('content', content);
    formData.append('id', selector.data('id'));

    $.ajax({
        url: url_controller+'save/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                alert_success('data berhasil disimpan');
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