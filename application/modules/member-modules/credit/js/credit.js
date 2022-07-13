var controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var table_paid;
var table_has_paid;
var id_use;
$(document).ready(function(){
	table_paid= $('.table_credit').DataTable({
        "ajax": {
            "url": controller+"/list_data",
            "type": "POST"
        }
    });

    // table_has_paid= $('.table_has_paid').DataTable({
    //     "ajax": {
    //         "url": controller+"/list_has_paid",
    //         "type": "POST"
    //     }
    // });
    
    // table_has_paid= $('.table_reject').DataTable({
    //     "ajax": {
    //         "url": controller+"/list_reject",
    //         "type": "POST"
    //     }
    // });
    

    // $('.table_payment').DataTable();
    $('.datepicker_form').datepicker();
    load_invoice();
});

function load_invoice() {
    showLoading();
    var status_payment = $('.status_payment.active').data('status');
    var formData = new FormData($('#form-search')[0]);
    formData.append('status_payment', status_payment);
    $.ajax({
        url: controller+'list_data/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            $('.html_respon_invoice').html(data.html_respon);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}

$(document).on('click', '.btn_search', function (e) { 
    e.preventDefault();
    load_invoice();
});
$(document).on('click', '.clear_date', function () { 
    $(this).closest('.input-group').find('.datepicker').val('');
});


$(document).on('click', '.preview-payment', function () { 

    showLoading();
    var id = $(this).data('id');
    $.ajax({
        url: controller+'detail_payment/?token='+_token_user,
        type: "POST",
        data: {'id':id},
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            $('.modal-title').text('Detail Pembayaran');
            $('#modal-form').modal('show');
            $('.html_respon_modal').html(data.html_respon);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
    
});

$('.btn_add').click(function () {
    hideLoading();
    save_method = 'add';
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('.form-input')[0].reset();
    $('.modal-title').text('TAMBAH DATA');
    $('#modal-form').modal('show');
});

$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    //defined form
    var formData = new FormData($('.form-input-credit')[0]);
    var url;
    $.ajax({
        url: controller + '/save',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                alert_success('Data Berhasil Disimpan');
                window.location.href = controller;
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    if (data.inputerror[i] == 'price') {
                        $('.notif_' + data.inputerror[i]).parent().addClass('has-error');
                        $('.notif_' + data.inputerror[i]).text(data.error_string[i]);
                    } else {
                        $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    }
                }
            }
            hideLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading();
            alert_error('something wrong');
        }
    });//end ajax
});

$('.btn_preview').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-error');
    $('.help-block').empty();
    var html_resume_credit = $('.html_resume_credit').html();
    $('.html_resume_credit_modal').html(html_resume_credit);
      //defined form
    var id = $(this).data('id'); 
    var formData = new FormData($('.form_payment')[0]);
    formData.append('id', id);
    $.ajax({
        url: controller+'/preview_save_payment',
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function(data){
            if (data.status) {
                $('.html_payment_preview').html(data.html_respon);
                $('#modal-form').modal('show');
            } else{
            for (var i = 0; i < data.inputerror.length; i++)
            {
                if (data.inputerror[i] == 'price') {
                    $('.notif_'+data.inputerror[i]).parent().parent().addClass('has-error');
                    $('.notif_'+data.inputerror[i]).text(data.error_string[i]);
                } else {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);   
                }
                }
            }
            hideLoading();
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            alert_error('something wrong');
        }
    });//end ajax
})

$(document).on('click', '.btn_save_payment', function () {
    var id = $(this).data('id');
    swal({
        title: 'Apakah anda yakin?',
        text: "simpan data pembayaran",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya,simpan data',
        cancelButtonText: 'Batal'
    },
    function(isConfirm) {
        if (isConfirm) {
            $('.btn_save').button('loading');
            var formData = new FormData($('.form_payment')[0]);
            formData.append('id', id);
            $.ajax({
                url: controller + '/save_payment',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        alert_success('data berhasil disimpan');
                        window.location.href = controller + '/detail?data=' + data.id_encrypt
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            if (data.inputerror[i] == 'price') {
                                $('.notif_' + data.inputerror[i]).parent().parent().addClass('has-error');
                                $('.notif_' + data.inputerror[i]).text(data.error_string[i]);
                            } else {
                                $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                                $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                            }
                        }
                    }
                    hideLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    alert_error('something wrong');
                }
            });//end ajax
        }
    })
});

$(document).on('click', '.btn_delete_payment', function () {
    var id = $(this).data('id');
    swal({
        title: 'Apakah anda yakin?',
        text: "hapus data pembayaran",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data',
        cancelButtonText: 'Batal'
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: controller + '/delete_payment',
                type: "POST",
                data: {'id':id},
                dataType: "JSON",
                success: function (data) {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert_error('something wrong');
                }
            });//end ajax
        }
    })
});


// $(document).on("change", ".checkbox_status", function () {
//     var id = $(this).val();
//     if ($(this).prop('checked')) {
//         status_active = 1;
//     }else{
//         status_active = 0;
//     }
//     $.ajax({
//         url: controller+'/update_status',
//         type: "POST",
//         data: {'status':status_active,'id':id},
//         dataType :"JSON",
//         success: function(data){
//                 alert_success('status berhasil diupdate');
//         },
//         error:function(jqXHR, textStatus, errorThrown)
//         {
//             hideLoading();
//             alert_error('something wrong');
//         }
//     });//end ajax
// });

$(document).on('click', '.btn_reject', function () {
    var id = $(this).data('id');
    $('.modal-title').text('BATALKAN PIUTANG');
	save_method = 'update';
	var PostData = {'id':id};
	$.ajax({
	    url: controller+'/get_form_reject',
	    type: "POST",
	    data: PostData,
	    dataType :"JSON",
        success: function (data) {
            id_use = data.id;  
            $('.html_respon_modal').html(data.html_respon);
	      	$('#modal-form').modal('show'); 
	        hideLoading();
	    },
	      error:function(jqXHR, textStatus, errorThrown)
	      {
	       hideLoading();
	       alert_error('something wrong');
	      }
	  });//end ajax
})

$(document).on('click', '.btn_save_reject', function (e) {
    e.preventDefault();
    showLoading();
    var id = $(this).data('id');
    var note = $('[name="note"]').val();
    $('.form-group').removeClass('has-error');
	$('.help-block').empty();  
    if (note == '') {
        $('[name="note"]').next().text('harus di isi');
        $('[name="note"]').parent().parent().addClass('has-error');
        $('.btn_save_reject').button('reset');
    }else{
        swal({
            title: 'Apakah anda yakin?',
            text: "Piutang ini akan dibatalkan",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya,lanjutkan',
            cancelButtonText: 'Batal'
        },
    function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: controller + '/save_reject',
                    type: "POST",
                    data: { 'id': id, 'note': note },
                    dataType: "JSON",
                    success: function (data) {
                        $('#modal-form').modal('hide');
                        alert_success('data berhasil dibatalkan');
                        reload_table();
                        $('.btn_save_reject').button('reset');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.btn_save_reject').button('reset');
                        alert_error('something wrong');
                    }
                });//end ajax
            } else {
                $('.btn_save_reject').button('reset');
            }
        });
    }
})

$('[name="type_search"]').change(function () {
    var type = $(this).val();
    if (type == '1') {
        $('.html_date_range').show();
        $('.html_code').hide();
    } else {
        $('.html_date_range').hide();
        $('.html_code').show();
    }
})


$('.btn_search_credit').click(function (e) {
    e.preventDefault();
    showLoading();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    //defined form
    var formData = new FormData($('.form-search')[0]);
    $.ajax({
        url: controller + '/get_history_credit',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                // alert_success('Data Berhasil Disimpan');
                $('.html_respon').html(data.html_respon);
                $('#table_history').DataTable();
                $('.table_history').DataTable();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading();
            alert_error('something wrong');
        }
    });//end ajax
});

$('.btn_search_payment').click(function (e) {
    e.preventDefault();
    showLoading();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    //defined form
    var formData = new FormData($('.form-search')[0]);
    $.ajax({
        url: controller + '/get_history_payment',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                // alert_success('Data Berhasil Disimpan');
                $('.html_respon').html(data.html_respon);
                $('#table_history').DataTable();
                $('.table_history').DataTable();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                    $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                }
            }
            hideLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading();
            alert_error('something wrong');
        }
    });//end ajax
});

$(document).on('click', '.reset_date', function () {
    type = $(this).data('date');
    if (type == 'date-from') {
        $('[name="date_from"]').val('');
    }
    if (type == 'date-to') {
        $('[name="date_to"]').val('');
    }
});

$(document).on('keyup', '.number_only', function () {
    var qty = $(this).val();
    var clean_word = qty.replace(/[^,\d]/g, '');
    $(this).val(clean_word);
});

$(document).on('keyup', '.money_only', function () {
    var qty = $(this).val();
    var clean_word = qty.replace(/[^,\d]/g, '');
    var money = money_function(qty, '');
    $(this).val(money);
});

$('.btn_do_import').click(function (e) {
    e.preventDefault();
    swal.showLoading();
    showLoading();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    //defined form
    var formData = new FormData($('.form-import')[0]);
    var url;
    $.ajax({
        url: controller + '/do_import_data',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                alert_success('Prview Data');
                $('.html_respon').html(data.html_respon);
                $('.table-data').DataTable();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoading();
            alert_error('something wrong');
        }
    });//end ajax
});

$(document).on('click', '.btn_save_import', function (e) {
    e.preventDefault();
    swal({
        title: 'Apakah anda yakin?',
        text: "Data piutang akan disimpan",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya,lanjutkan',
        cancelButtonText: 'Batal'
    },
    function(isConfirm) {
        if (isConfirm) {
            var formData = new FormData($('.form-save-import')[0]);
             swal.showLoading();
            var url;
            $.ajax({
                url: controller + '/save_import_data',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function (data) {
                    hideLoading();
                    if (data.status) {
                        location.href = controller;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    alert_error('something wrong');
                }
            });//end ajax
        } else {
            $('.btn_save_reject').button('reset');
        }
    });
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
    // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    return rupiah;
}