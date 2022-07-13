var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var id_elem = '';
var post;
var table;

$(document).ready(function () {
    list_data();
});


function list_data() {
    showLoading();
    var formData = new FormData($('.form-search')[0]);
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
            table = $('#table_data').DataTable(data.list);

            $(document).find('#cover-search').remove();
            $('.form-print').append(`
                <div id="cover-search"><input type="hidden" name="search" value="`+data.search+`"></div>
            `);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}


$(document).on('click', '.btn_update_price', function () {
    showLoading();
    var data_post = $(this).data();
    $.ajax({
        url: url_controller+'get_data'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:data_post,
        success: function (data) {
            hideLoading();
            $('[name="price"]').val(data.price);
            $('#modal_form').modal('show');
            id_use = data.id;
            id_elem = data.id_elem;
            post = data.data_post;
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
});


// $('.btn_save').click(function (e) {
//     e.preventDefault();
//     showLoading();
//     // swal.showLoading();
// 	$('.form-group').removeClass('has-danger');
//     $('.help-block').empty();
//     // save_method = $(this).data('method');
// 	  //defined form
//     var formData = new FormData($('#form-data')[0]);
//     formData.append('data_post', post);
//     formData.append('id', id_use);

//     $.ajax({
//         url: url_controller+'save/?token='+_token_user,
//         type: "POST",
//         data: formData,
//         contentType: false,
//         processData : false,
//         dataType :"JSON",
//         success: function (data) {
//             hideLoading();
//             if(data.status){
//                 notif_success('data berhasil disimpan');
//                 $('#modal_form').modal('hide');
//                 $('#' + id_elem).val(data.price);
//             } else{
//                 for (var i = 0; i < data.inputerror.length; i++)
//                 {
//                     $('.notif_'+data.inputerror[i]).parent().addClass('has-danger');
//                     $('.notif_'+data.inputerror[i]).text(data.error_string[i]);
//                 }
//             }
//         },
//         error:function(jqXHR, textStatus, errorThrown)
//         {
//             hideLoading();
//         }
// 	});//end ajax
// });

$('.btn_add_price').click(function () {
    save_method = 'add';
    var unique = $(this).data('unique');
    var html_label = $('.html_label_item_' + unique).html();
    $('.html_label_type').html(html_label);
    post = $(this).data();
    console.log(post);

	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form-data')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});


$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
    // swal.showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    // save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('#form-data')[0]);
    formData.append('countainer', post.countainer);
    formData.append('depo', post.depo);
    formData.append('teus', post.teus);
    formData.append('stuffing', post.stuffing);
    formData.append('unique', post.unique);
    formData.append('customer', post.customer);

    var url;
    if (save_method == 'add') {
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
                notif_success('Berhasil disimpan');
                $('.html_container_price_'+data.code).html(data.html_respon);
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
            alert('something wrong');
        }
	});//end ajax
});

$(document).on('click', '.btn_update', function () {
    // swal.showLoading();
    showLoading();

    var unique = $(this).data('unique');
    var html_label = $('.html_label_item_' + unique).html();
    $('.html_label_type').html(html_label);
    post = $(this).data();

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
            hideLoading();
            id_use = id;
            $('[name="price"]').val(data.price);
            $('#modal_form').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            alert('something wrong');
        }

    });//end ajax
});


$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    selector = $(this);
    post = $(this).data();
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
                data:{'id':id,'countainer': post.countainer,'depo':post.depo,'teus':post.teus,'stuffing':post.stuffing,'unique':post.unique,'customer':post.customer},
                success: function (data) {
                    hideLoading();
                    if (data.status) {
                        notif_success('berhasil dihapus');
                        $('.html_container_price_'+data.code).html(data.html_respon);
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

$(document).on('click', '.change_status', function () {
    var id = $(this).data('id');
    var unique = $(this).data('unique');
    $(this).toggleClass('on');
    active_status = $(this).hasClass('on') ? 1 : 0;

    if (active_status == 1) {
        $('.status_' + unique).removeClass('on');
        $(this).addClass('on');
    } else {
        $(this).addClass('on');
        alert_error('Tidak Boleh Non-aktif');
        return false;
    }

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

$(document).on('keyup', '.money_only', function () {
    var new_val = money_function($(this).val());
    $(this).val(new_val);
})

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