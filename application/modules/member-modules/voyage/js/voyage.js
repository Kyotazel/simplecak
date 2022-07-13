var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
var table_proceed;

$(document).ready(function () {
    // var type = $('.container_list').data('type');
    list_data(0);
    list_data_proceed();
    $('#table_detail_bs').DataTable();
    
});

function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}

$('.btn_search').click(function (e) {
    e.preventDefault();
	//   //defined form
    list_data(1);
});

function list_data(status) {
    showLoading();
    var formData = new FormData($('#form-search')[0]);
    formData.append('status_search', status);
    $.ajax({
        url: url_controller+'list_data/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if ($.fn.DataTable.isDataTable('#table_data')) {
                table.destroy();
            }
            table = $('#table_data').DataTable({
                data: data.list.data,
                "columns": [
                    null,
                    null,
                    { "width": "15%" },
                    null,
                    null,
                    null,
                    { "width": "30%" },
                    null
                ]
            });

            $(document).find('#cover-search').remove();
            $('.form-print').append(`
                <div id="cover-search"><input type="hidden" name="search" value="`+data.search+`"></div>
            `);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            swal.close();
        }
	});//end ajax
}


function list_data_proceed() {
    showLoading();
    var formData = new FormData($('#form-search')[0]);
    $.ajax({
        url: url_controller+'list_proceed_voyage/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if ($.fn.DataTable.isDataTable('#table_data_proceed')) {
                table.destroy();
            }
            table_proceed = $('#table_data_proceed').DataTable({
                data: data.list.data,
                "columns": [
                    null,
                    null,
                    { "width": "15%" },
                    null,
                    null,
                    null,
                    { "width": "30%" },
                    null
                ]
            });

            $(document).find('#cover-search').remove();
            $('.form-print').append(`
                <div id="cover-search"><input type="hidden" name="search" value="`+data.search+`"></div>
            `);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            swal.close();
        }
	});//end ajax
}


$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-data')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});



// $('.btn_search').click(function (e) {
//     e.preventDefault();
//     showLoading();
//     // swal.showLoading();
// 	$('.form-group').removeClass('has-danger');
//     $('.help-block').empty();
//     // save_method = $(this).data('method');
// 	  //defined form
//     var formData = new FormData($('#form-search')[0]);
//     $.ajax({
//         url: url_controller+'list_data/?token='+_token_user,
//         type: "POST",
//         data: formData,
//         contentType: false,
//         processData : false,
//         dataType :"JSON",
//         success: function (data) {
//             hideLoading();
//         },
//         error:function(jqXHR, textStatus, errorThrown)
//         {
//             hideLoading();
//             $('.btn_save_group').button('reset');
//         }
// 	});//end ajax
// });

$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
    // swal.showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    // save_method = $(this).data('method');
	  //defined form
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
                list_data();
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
            $('.btn_save_group').button('reset');
        }
	});//end ajax
});

$(document).on('click', '.btn_edit', function () {
    // swal.showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    id = $(this).data('id');
    save_method = 'update';
    $.ajax({
        url: url_controller+'get_data'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function (data) {
            swal.close();
            id_use = data.id;
            $('[name="name"]').val(data.name);
            $('[name="pic"]').val(data.pic);
            $('[name="npwp"]').val(data.npwp);
            $('[name="address"]').val(data.address);
            $('[name="number_phone"]').val(data.number_phone);
            $('[name="email"]').val(data.email);
            $('[name="credit_limit"]').val(data.credit_limit);
            $('[name="expired_limit"]').val(data.expired_limit);
            $('[name="active_status"]').val(data.isActive);
            $('#modal_form').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            swal.close();
        }
    });//end ajax
});


$(document).on('click', '.btn_close_ticket', function () {
    id = $(this).data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "Pembelian tiket akan ditutup!",
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
                url: url_controller+'close_ticket'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id},
                success: function(data){
                    if (data.status) {
                        notif_success('data berhasil disimpan');
                        location.reload();
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                    notif_error('something wrong');
                    hideLoading();
                }

            });//end ajax
        }
    });
});


$(document).on('click', '.btn_save_cancel', function () {
    var id = $('.btn_cancel_voyage').data('id');
    var note = $('[name="note"]').val();
    swal({
        title: "Apakah anda yakin?",
        text: "Voyage akan dibatalkan!",
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
                url: url_controller+'cancel_voyage'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id,'note':note},
                success: function(data){
                    if (data.status) {
                        notif_success('data berhasil disimpan');
                        location.reload();
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                    notif_error('something wrong');
                    hideLoading();
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

$(document).on('click', '.btn_cancel_voyage', function () {
    $('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-data')[0].reset();
	$('.modal-title').text('FORM PEMBATALAN');
    $('#modal_form').modal('show');
});

$(document).on('click', '.empty_form', function () {
    var name = $(this).data('name');
    $('[name="' + name + '"]').val('');
});


$(document).on('keyup', '.rupiah', function () {
    var new_val = money_function($(this).val());
    $(this).val(new_val);
});


function money_function(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
}

rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
