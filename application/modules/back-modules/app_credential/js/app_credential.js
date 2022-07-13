var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {
    show_credential();
});

$('.btn_add_credential').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('.form_credential')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_credential').modal('show');
});

$('.btn_save_credential').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var status_menu = $(this).data('status');
	  //defined form
    var formData = new FormData($('.form_credential')[0]);
    var url;
    if(save_method=='add'){
        url = 'save';
    }else{
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                $('#modal_credential').modal('hide');
                location.reload();
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_credential').button('reset');
        }

	});//end ajax
});


$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_data'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
                $('[name="name"]').val(data.name);
                $('[name="description"]').val(data.description);
                $('[name="id_menu"]').val(data.id_app_menu);
                $('#modal_credential').modal('show');

             
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
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
            $.ajax({
                url: url_controller+'delete_data'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id,'status_group':true},
                success: function(data){
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        location.reload();
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }

            });//end ajax
        }
    });
});

$(document).on('click', '.change_status', function () {
    var id = $(this).data('id');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id,'status':active_status},
        success: function(data){
            if (data.status) {
                notif({
                    msg: "<b>Sukses :</b> Data berhasil diupdate",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
});

function show_credential() {
    var id = $('.credential-data').data('id');
    var status = $('.credential-data').data('status');

    var html_empty = `
        <div class="text-center" style="padding-top:150px;">
            <h3>Credential Belum Dipilih</h3>
            <p class="">Silahkan pilih credentil terlebih dahulu untuk menampilkan hak akses module.</p>
        </div>
    `;

    if (id && status) {
        $.ajax({
            url: url_controller+'show_credential'+'?token='+_token_user,
            type: "POST",
            dataType: "JSON",
            data:{'id_credential':id},
            success: function(data){
                if(data.status){
                    $('.html-menu').html(data.html_respon);

                } 
            },
            error:function(jqXHR, textStatus, errorThrown)
            {
            }
    
        });//end ajax
    } else {
        $('.html-menu').html(html_empty);
    }
}


$(document).on('click', '.change_status_module', function () {
    var id_module = $(this).data('id');
    var id_credential = $('.credential-data').data('id');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status_module'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id_module':id_module,'id_credential':id_credential,'status':active_status},
        success: function(data){
            if (data.status) {
                notif({
                    msg: "<b>Sukses :</b> Data berhasil diupdate",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
});

$(document).on('click', '.change_all', function () {
    var type = $(this).data('type');
    var id_credential = $('.credential-data').data('id');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;

    if (active_status) {
        $('[data-type="'+type+'"]').addClass('on');
    } else {
        $('[data-type="'+type+'"]').removeClass('on');
    }

    var array_module = [];
    $('.change_status_module[data-type="' + type + '"]').each(function () {
        var id_module = $(this).data('id');
        array_module.push(id_module);
    });
    console.log(array_module);

    $.ajax({
        url: url_controller+'update_status_all'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'array_module':array_module,'id_credential':id_credential,'status':active_status},
        success: function(data){
            if (data.status) {
                notif({
                    msg: "<b>Sukses :</b> Data berhasil diupdate",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
});