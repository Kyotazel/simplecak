var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function() {
    id = $(this).data('id');
    console.log(id);
    $.ajax({
        url: url_controller + "get_data" + '?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            console.log(data);
        }
    })
})