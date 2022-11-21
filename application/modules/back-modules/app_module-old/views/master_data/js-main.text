
var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function () {
    table = $('#table_data').DataTable({
        "ajax": {
        "url": url_controller+"list_data"+'/?token='+_token_user,
        "type": "POST",
        }
    });
});

function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}

$('.btn_add').click(function () {
    save_method = 'add';
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form-data')[0].reset();
    $('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var formData = new FormData($('#form-data')[0]);
    var url;
    if(save_method=='add'){
        url = 'save';
    }else{
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type:'POST',
        dataType:'JSON',
        data: formData,
        contentType: false,
        processData : false,
        success: function (data) {
                hideLoading();
                if(data.status){
                    notif({
                        msg: "<b>Sukses :</b> Data berhasil disimpan",
                        type: "success"
                    });
                    reload_table();
                    $('#modal_form').modal('hide');
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

$(document).on('click', '.btn_edit', function () {
    showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    id = $(this).data('id');
    save_method = 'update';
    $.ajax({
        url: url_controller+'get_data'+'/?token='+_token_user,
        type:'POST',
        dataType:'JSON',
        data:{'id':id},
        success: function (data) {
            hideLoading();
            id_use = data.id;
            $('[name="name"]').val(data.name);
            $('#modal_form').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }

    });//end ajax
});

$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "data akan dihapus!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya , Lanjutkan",
        cancelButtonText: "Batal",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            showLoading();
            $.ajax({
                url: url_controller+'delete_data'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id,'status_group':true},
                success: function(data){
                    hideLoading();
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        table.ajax.reload(null, false);
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                    hideLoading();
                }

            });//end ajax
        }
    });
});

            