
var url_controller_print = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/print_data/';
$(document).ready(function () {

});

$(document).on('click', '.btn_print', function () { 
    showLoading();
    var data_print = $('.data-print').data('print');
    var document_type = $(this).data('doc');
    $.ajax({
        url: url_controller_print+'print_data/?token='+_token_user,
        type: 'POST',
        data: {
            'data': data_print,
            'document':document_type
        },
        dataType :'JSON',
        success: function (data) {
            hideLoading();
            if (document_type == 'excel') {
                location.href = data.url;
            }
            if (document_type == 'pdf') {
                $('.html_respon_print').html(data.html_respon);
                $('#modal_print').modal('show');
            }
            
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
});
