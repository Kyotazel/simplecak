var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table, table_before, table_after;

$(document).ready(function() {
    table = $('#table_data').DataTable({
        "responsive" : true,
        "ajax": {
            "url": url_controller+"list_data"+"?token="+_token_user,
            "type": "POST",
        },
    })
    table_after = $('#table_after').DataTable({
        "responsive" : true,
        "ajax": {
            "url": url_controller+"list_data"+"?token="+_token_user,
            "type": "POST",
        },
    })
})

$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-control').removeClass('is-invalid');
    $(".select2-hidden-accessible").select2('destroy');
    $(".select2").select2();
    $('.invalid-feedback').empty();
 	$('.form_input')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});