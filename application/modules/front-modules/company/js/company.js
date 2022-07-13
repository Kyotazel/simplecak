var url_controller = baseUrl + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {

    $(document).on('click', '.btn_send', function (e) {
        e.preventDefault();
        $('.form-group').removeClass('has-danger');
        $('.help-block').empty();
          //defined form
        var formData = new FormData($('.form-contact')[0]);
        
        $.ajax({
            url: url_controller+'save_message',
            type: "POST",
            data: formData,
            contentType: false,
            processData : false,
            dataType :"JSON",
            success: function(data){
                if (data.status) {
                    location.href = url_controller + 'thanks';
                } else{
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                // $('.btn_send').button('reset');
            },
            error:function(jqXHR, textStatus, errorThrown)
            {
                // $('.btn_send').button('reset');
                console.log('error process');
            }
    
        });//end ajax
    });

});

