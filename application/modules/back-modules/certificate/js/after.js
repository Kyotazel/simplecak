var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
var id_batch_course = $("#id_batch_course").val()

table = $('#table_data').DataTable({
    "responsive" : true,
    "ajax": {
        "url": url_controller+"list_after/" + id_batch_course +"?token="+_token_user,
        "type": "POST",
    },
    "columnDefs": [
        { "width": "10%", "targets": 0 },
        { "width": "65%", "targets": 1 },
        { "width": "25%", "targets": 2 },
        { "className": "text-center", "targets": 2 },
      ]
})