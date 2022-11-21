var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$(document).ready(function () {
    var type = $('.container_list').data('type');
    table = $('#table_module').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+'?token='+_token_user,
            "type": "POST",
            "data":{'type':type}
        }
      });
});

$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('.form_input')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var status_menu = $(this).data('status');
	  //defined form
    var formData = new FormData($('.form_input')[0]);
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
        success: function (data) {
            hideLoading();
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                table.ajax.reload(null, false);
                $('#modal_form').modal('hide');
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
            hideLoading();
        }

	});//end ajax
});

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_data'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
            if (data.status) {
                
                $('[name="name"]').val(data.name);
                $('[name="description"]').val(data.description);
                $('[name="folder"]').val(data.directory);
                $('[name="module_type"]').val(data.type);
                $('#modal_form').modal('show');

            } 
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
                        table.ajax.reload(null, false);
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

//=============== ROUTING ================
$(document).on('click', '.btn_add_routing', function () { 
    var id = $(this).data('id');
    showDetailRoute(id);
});

function showDetailRoute(id) {
    showLoading();
    $.ajax({
        url: url_controller+'detail_route'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
            hideLoading();
            $('.html_respon_route').html(data.html_respon);
            $('#modal_route').modal('show');
            table.ajax.reload(null, false);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }

    });//end ajax
}



$(document).on('click', '.btn_save_routing', function (e) { 

    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var id_module = $(this).data('id');
	  //defined form
    var formData = new FormData($('.form-routing')[0]);
    formData.append('id_module', id_module);
    $.ajax({
        url: url_controller+'/save_routing?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                showDetailRoute(data.id);
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
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

$(document).on('click', '.btn_update_routing', function () { 
    showLoading();
    var id = $(this).data('id');
    var route = $(document).find('.route_' + id).val();
    var credential_access = $(document).find('.access_route_' + id).val();

    $.ajax({
        url: url_controller+'update_routing'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data: {
            'id': id,
            'route': route,
            'credential_access':credential_access
        },
        success: function(data){
            hideLoading();
            showDetailRoute(data.id);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }

    });//end ajax
});


$(document).on('click', '.btn_delete_routing', function () {
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
                url: url_controller+'delete_routing'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
                success: function (data) {
                    hideLoading();
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        showDetailRoute(data.id);
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

$(document).on('click', '.btn_create_all_config', function () {
    id = $(this).data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "system akan membuat file konfigurasi pada masing-masing modul",
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
                url: url_controller+'create_config'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
                success: function (data) {
                    if (data.status) {
                        setTimeout(() => {
                            hideLoading();
                            alert_success('Selesai, '+data.count_data+' Data Telah Dibuat.');
                        }, 1000);
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

$(document).on('click', '.btn_sync_all_config', function () {
    swal({
        title: "Apakah anda yakin?",
        text: "system akan melakukan synkronisasi data pada semua modul.",
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
                url: url_controller+'sync_config'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        setTimeout(() => {
                            hideLoading();
                            alert_success('Selesai, ' + data.count_data + ' Data Telah Dibuat.');
                            location.reload();
                        }, 1000);
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

$(document).on('click', '.btn_sync_module', function () { 
    var id = $(this).data('module');
    swal({
        title: "Apakah anda yakin?",
        text: "system akan melakukan synkronisasi data pada modul ini.",
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
                url: url_controller+'sync_config_module'+'?token='+_token_user,
                type: "POST",
                data: {
                    'id':id
                },
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        setTimeout(() => {
                            hideLoading();
                            alert_success('Berhasil.');
                            showDetailRoute(data.id);
                        }, 1000);
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