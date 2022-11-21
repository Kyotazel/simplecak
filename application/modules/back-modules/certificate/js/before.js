var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
var id_batch_course = $("#id_batch_course").val()

table = $('#table_data').DataTable({
    "responsive" : true,
    "ajax": {
        "url": url_controller+"list_before/" + id_batch_course +"?token="+_token_user,
        "type": "POST",
    },
    "columnDefs": [
        { "width": "10%", "targets": 0 },
        { "width": "65%", "targets": 1 },
        { "width": "25%", "targets": 2 },
        { "className": "text-center", "targets": 2 },
      ]
})

$(document).on('click', '.btn_generate', function () {
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('.modal-title').text('Generate Sertifikat');
    id = $(this).data('id');
    id_use = id;
    $('#modal_form').modal('show');
})

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form_input')[0]);
    formData.append('id', id_use);
    var status;

    $.ajax({
        url: url_controller+"generate"+'?token'+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                notif({
                    msg: `<b>Sukses : </b> Sertifikat berhasil Dibuat`,
                    type: "success"
                })
                table.ajax.reload(null, false);
                $("#modal_form").modal("hide");
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="'+data.inputerror[i]+'"]').addClass("is-invalid");
                    $('[name="'+data.inputerror[i]+'"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})