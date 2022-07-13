var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_parent = 0;
var id_use = 0;

$(document).ready(function () {
    // $('#modal_form').modal('show');
    show_menu();
});

$('.btn_add_group').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('.form_group_menu')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_group').modal('show');
});

$('.btn_save_group').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var status_menu = $(this).data('status');
	  //defined form
    var formData = new FormData($('.form_group_menu')[0]);
    formData.append('status', status_menu);
    var url;
    if(save_method=='add'){
        url = 'save_group';
    }else{
        url = 'update_group';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                $('#modal_group').modal('hide');
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                location.reload();
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-danger');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            $('.btn_save_group').button('reset');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.btn_save_group').button('reset');
            alert('error process');
showLoading();
        }

	});//end ajax
});

$('.btn_edit_group').click(function () {
    $('.modal-title').text('EDIT DATA');
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_menu'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
            if (data.status) {
                
                $('[name="name"]').val(data.name);
                $('[name="description"]').val(data.description);
                $('#modal_group').modal('show');

            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
});

$(document).on('click', '.btn_duplicate_group', function () {
    id = $(this).data('id');
    swal({
        title: "Duplicat Menu?",
        text: "menu akan diduplicate!",
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
                url: url_controller+'duplicate_group'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
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

$(document).on('click', '.btn_delete_group', function () {
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
                url: url_controller+'delete_group'+'/?token='+_token_user,
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

function show_menu() {
    var id = $('.group-data').data('id');
    var status = $('.group-data').data('status');

    var html_empty = `
        <div class="text-center" style="padding-top:150px;">
            <h3>Group Menu Belum Dipilih</h3>
            <p class="">Silahkan pilih group menu terlebih dahulu untuk menampilkan daftar menu.</p>
        </div>
    `;

    if (id && status) {
        $.ajax({
            url: url_controller+'show_menu'+'/?token='+_token_user,
            type: "POST",
            dataType: "JSON",
            data:{'group':id},
            success: function(data){
                if(data.status){
                    $('.html-menu').html(data.html_respon);
                        list = $('.usd_list');
                        list.sortable({
                            tolerance: "pointer",
                            items: ".usd_item_drag",
                            connectWith: '.usd_list',
                            placeholder: 'placeholder',
                            update: function (event, ui) {
                                update_sort_menu(ui.item);
                            }
                        });

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

function update_sort_menu(selector) {
    var position = selector.closest('.usd_list').data('position');
    var id_current = selector.data('id');
    id_parent = 0;
    if (position == 'sub_menu') {
        id_parent = selector.closest('.usd_list').parent().data('id');
    }
    var list_id = [];
    selector.closest('.usd_list').children('.usd_item_drag').each(function () {
        var id_slider = $(this).data('id');
        list_id.push(id_slider)
    });
    

    $.ajax({
        url: url_controller+'update_sort'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'list_id':list_id,'id_current':id_current,'id_parent':id_parent},
        success: function(data){
            if(data.status){
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
}

$('.btn_add_menu').click(function () {
    save_method = 'add';
    id_parent = 0;
    $('#devider_status').removeClass('on');
    $('.html_parent_menu').html('');
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('.form_main_menu')[0].reset();
   $('.modal-title').text('TAMBAH DATA MENU UTAMA');
   $('#modal_menu').modal('show');
});

$('.btn_main_menu').click(function (e) {
    e.preventDefault();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    var group = $(this).data('group');
    var devider_status = $('#devider_status').hasClass('on') ? 1 : 0;
	  //defined form
    var formData = new FormData($('.form_main_menu')[0]);
    formData.append('group', group);
    formData.append('id_parent', id_parent);
    formData.append('devider_status', devider_status);
    var url;
    if(save_method=='add'){
        url = 'save_main_menu';
    }else{
        url = 'update_main_menu';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if(data.status){
                $('#modal_menu').modal('hide');
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                show_menu();
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
            alert('error process');
showLoading();
        }

	});//end ajax
});

$(document).on('click', '.btn_add_sub', function () {
    id_parent = $(this).data('id');
    var html_parent = $(this).parent().parent().parent().find('.slide').html();
    html_parent_show = `
    <div class="p-2 row">
        <label class="col-md-2"><b>Menu Parent :</b></label>
        <div class="col-md-3  border">`+ html_parent + `</div>
    </div>
    `;
    $('.html_parent_menu').html(html_parent_show);
    save_method = 'add';
    $('#devider_status').removeClass('on');
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('.form_main_menu')[0].reset();
   $('.modal-title').text('TAMBAH DATA MENU UTAMA');
   $('#modal_menu').modal('show');
});

$(document).on('click', '.btn_edit_menu', function () {
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller+'get_menu'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function(data){
            if (data.status) {
                
                $('[name="name"]').val(data.name);
                $('[name="link"]').val(data.link);
                $('[name="css"]').val(data.css);
                $('[name="icon"]').val(data.icon);

                if (data.is_devider==true) {
                    $('#devider_status').addClass('on');
                } else {
                    $('#devider_status').removeClass('on');
                }
                $('#modal_menu').modal('show');

            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
});

$(document).on('click', '.btn_delete_menu', function () {
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
                url: url_controller+'delete_menu'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
                success: function(data){
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });
                        show_menu();
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }

            });//end ajax
        }
    });
});

$(document).on('click', '#devider_status', function () {
    $(this).toggleClass('on');
});

$(document).on('click', '.change_status', function () {
    var id_menu = $(this).data('id');
    var menu = $(this).data('menu');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status_menu'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id_menu':id_menu,'menu':menu,'status':active_status},
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

$(document).on('click', '.change_status_front_group', function () {
    var selector = $(this);
    var id_menu = $(this).data('id');
    var type = $(this).data('type');

    if (selector.hasClass('on')) {
        alert_error('Tidak boleh di non-aktifkan');
        return false;
    }

    if (type == 1) {
        $('.front_group_menu').removeClass('on');
    } else {
        $('.member_group_menu').removeClass('on');
    }
    selector.toggleClass('on');

    active_status = selector.hasClass('on') ? 1 : 0;
    console.log(active_status);


    $.ajax({
        url: url_controller+'update_status_group_front_menu'+'?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id_menu':id_menu,'type':type,'status':active_status},
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