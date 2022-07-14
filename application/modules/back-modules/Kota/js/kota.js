var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function() {
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+"?token="+_token_user,
            "type": "POST",
        },
        "columns" : [
            { "width": "10%" },
            { "width": "40%" },   
            { "width": "30%" },
            { "width": "20%" },
        ]
    })
})