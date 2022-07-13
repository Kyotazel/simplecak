var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
var id_member = 0;
var status_validate = 0;
var status_validate_detail_transport = 0;
var tax_status = 0;
var materai_status = 0;


$(document).ready(function () {
    if ($(document).find('.countdown_ticket').length) {
        countdown_timer_ticket();
    }
    list_booking_confirm();
    $('.table_member').DataTable();
    $('[name="category_stuff"]').chosen();
    $('[name="transport"]').chosen();

    if ($('#data_customer').length) {
        id_member = $('#data_customer').data('id');
    }

    // $('#modal_add_lc').modal('show');
});

$('.btn_search').click(function (e) {
    e.preventDefault();
	//   //defined form
    list_data(1);
});

function list_data(status) {
    showLoading();
    $('.help-block').empty();
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
            if (data.status) {
                $('.html_response').html(data.html_respon);
                countdown_timer_ticket();
            }else{
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
            swal.close();
        }
	});//end ajax
}

function list_booking_confirm() {
    showLoading();
    $('.help-block').empty();
    var formData = new FormData($('#form-search')[0]);
    formData.append('status_search', status);
    $.ajax({
        url: url_controller+'list_data_confirm/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                if ($.fn.DataTable.isDataTable('#table_confirm_booking')) {
                    table.destroy();
                }
                table = $('#table_confirm_booking').DataTable({
                    data: data.list.data,
                    "columns": [
                        { "width": "5%" },
                        { "width": "20%" },
                        { "width": "25%" },
                        null
                    ]
                });
                countdown_timer_ticket();
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
            swal.close();
        }
	});//end ajax
}

function countdown_timer_ticket() {
    var x = setInterval(function() {
        $('.countdown_ticket').each(function () {
            type = $(this).data('type');
            //alert(type);
            
            if (type == 'datetime') {
                date_to = $(this).data('date-to');
            } else {
                date_to = $(this).data('date-to') + ' 00:00:00';
            }
            
            selector = $(this);
            console.log(date_to);
            var countDownDate = new Date(date_to).getTime();
            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            selector.find('.text_day').text(days);
            selector.find('.text_hour').text(hours);
            selector.find('.text_minute').text(minutes);
            selector.find('.text_second').text(seconds);
            // If the count down is finished, write some text
            if (distance < 0) {
                //clearInterval(x);
                selector.parent().html(`
                    <h3 class="text-muted text-center">EXPIRED</h3>
                `);
            }
        });

    }, 1000);
}


$(document).on('click', '.btn_search_member', function () {
    $('.modal-title').text('PILIH CUSTOMER');
    $('#modal_member').modal('show');
});

$(document).on('click', '.btn_choose_member', function () { 
    id_member = $(this).data('id');
    $('#member_name').val($(this).data('name'));
    $('#modal_member').modal('hide');
    $('#member_name').popover('hide');

    $('.btn_search_member').hide();
    $('.btn_clear_member').show();

    $('.form_btn_act').show();
    $('.form_help_description').hide();
});

$(document).on('click', '.btn_clear_member', function () { 
    swal({
        title: "Member dibatalkan ?",
        text: "data item kontainer dan loss cargo akan dihapus!",
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
            $(document).find('.item_detail').remove();
            $('.form_btn_act').hide();
            $('.form_help_description').show();

            $('.btn_search_member').show();
            $('.btn_clear_member').hide();
            $('#member_name').val('');
            id_member = 0;
            total_resume_detail();

        }
    });
});

$('[name="stuffing_take"]').change(function () { 
    var value = $(this).find("option:selected").data('val');
    if (value == 1) {
        $('#address_stuffing_take').show();
    } else {
        $('#address_stuffing_take').hide();
        $('[name="address_stuffing_take"]').val('');
    }
});

$('[name="stuffing_open"]').change(function () { 
    var value = $(this).find("option:selected").data('val');
    if (value == 1) {
        $('#address_stuffing_open').show();
    } else {
        $('#address_stuffing_open').hide();
        $('[name="address_stuffing_open"]').val('');
    }
});

$('#btn_add_item').click(function () { 
    $('#member_name').popover('hide');
    $('#head_table_item').popover('hide');

    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form_add_countainer')[0].reset();
    $('.modal-title').text('TAMBAH KONTAINER');
    $("#category_stuff").val('').trigger("chosen:updated");
    $('#modal_add_countainer').modal('show');
    $('#address_stuffing_take').hide();
    $('#address_stuffing_open').hide();
});

$('#btn_act_add').click(function (e) {
    e.preventDefault();
    showLoading();
    // swal.showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    // save_method = $(this).data('method');
	  //defined form
    var id_depo_from = $(this).data('id-depo');
    var formData = new FormData($('#form_add_countainer')[0]);
    formData.append('id_depo_from', id_depo_from);
    formData.append('id_member', id_member);
    $.ajax({
        url: url_controller+'add_item_countainer/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $(document).find('.tbody_item_booking').find('.countainer_'+data.class).remove();
                $('.tbody_item_booking').prepend(data.html_item);
                $('#modal_add_countainer').modal('hide');
                total_resume_detail();
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

$('#btn_add_lc').click(function () { 
    $('#member_name').popover('hide');
    $('#head_table_item').popover('hide');
    $(document).find('.item_add_transport').remove();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form_add_lc')[0].reset();
    $('.modal-title').text('TAMBAH LOSS CARGO');
    $("#transport").val('').trigger("chosen:updated");
    $("#category_stuff_lc").val('').trigger("chosen:updated");
    $('#modal_add_lc').modal('show');
});

function validate_detail_transport() {
    status_validate_detail_transport = 1;
    $(document).find('.item_transport').each(function () {
        var selector = $(this);
        var val_current = selector.find('.detail_transport').val();
        if (val_current == '') {
            status_validate_detail_transport = 0;
            selector.find('.help-block').text('Harus Diisi');
        }
    });
}

$('#btn_act_add_lc').click(function (e) {
    e.preventDefault();
    showLoading();
    // swal.showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    validate_detail_transport();
    if (status_validate_detail_transport == 0) {
        hideLoading();
        return false;
    }
    // save_method = $(this).data('method');
	  //defined form
    var id_depo_from = $(this).data('id-depo');
    var formData = new FormData($('#form_add_lc')[0]);
    formData.append('id_depo_from', id_depo_from);
    $.ajax({
        url: url_controller+'add_item_lc/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $(document).find('.tbody_item_booking').find('.countainer_'+data.class).remove();
                $('.tbody_item_booking').prepend(data.html_item);
                $('#modal_add_lc').modal('hide');
                total_resume_detail();
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

$(document).on('click', '.btn_act_qty', function () { 
    selector = $(this);
    var price = selector.data('price');
    var value = selector.closest('.group-plus-minus').find('.value').val();
    var new_total_price = parseInt(price) * parseInt(value);
    selector.closest('.item_detail').find('.text-qty').text(value);
    console.log(new_total_price);
    selector.closest('.item_detail').find('.text-total-price').val(money_function(new_total_price.toString()));
    total_resume_detail();
});

$(document).on('click', '.btn_act_qty_lc', function () { 
    selector = $(this);
    var value = selector.closest('.group-plus-minus').find('.value').val();

});

$(document).on('click', '.btn_add_transport', function () {
    var html_form_transport = `
        <div class="item_transport item_add_transport  mb-1">
            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-truck"></i></span>
                </div>
                <input name="detail_transport[]"  placeholder="ketik nama kendaraan..." class="form-control detail_transport" type="text">
                <div class="input-group-append">
                
                    <a href="javascript:void(0)" class="delete_transport btn btn-light"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <span class="help-block text-danger"></span>
        </div>
    `;
    $('.html_transport').append(html_form_transport);
});
$(document).on('click', '.delete_transport', function () { 
    $(this).closest('.input-group').remove();
});

function total_resume_detail() {
    var grand_total_teus = 0;
    var grand_total_countainer = 0;
    $(document).find('.tbody_item_booking').find('.value').each(function () { 
        selector = $(this);
        var qty_countainer = selector.val();
        var teus = selector.data('teus');
        var total_teus = parseInt(qty_countainer) * parseInt(teus);
        
        grand_total_countainer += parseInt(qty_countainer);
        grand_total_teus += total_teus;
    });

    $('.text-total-countainer').text(grand_total_countainer);
    $('.text-total-teus').text(grand_total_teus);

    var total_lc = 0;
    $(document).find('.tbody_item_booking').find('.value_lc').each(function () { 
        selector = $(this);
        var qty_lc = selector.data('qty');
    
        total_lc += parseInt(qty_lc);
    });
    $('.text-total-lc').text(total_lc);
}

$(document).on('click', '.btn_del_item', function () { 
    $(this).closest('.item_detail').remove();
    total_resume_detail();
});

function validate_save() {
    $('#member_name').popover('hide');
    $('#head_table_item').popover('hide');

    // $('[data-popover-color="head-primary"]').popover({
	// 	template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
    // });

    status_validate = 0;
    if (id_member == 0) {
        
        $('#member_name').popover({
            template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
        });
        $('#member_name').popover('show');
        status_validate = 1;
    }

    if ($(document).find('.tbody_item_booking').find('.item_detail').length==0) {
        $('#head_table_item').popover('show');
        status_validate = 1;
    }
    
}

$('.btn_save_order').click(function (e) {
    e.preventDefault();
    validate_save();

    if(status_validate==1){
        return;
    }

    swal({
            title: "Pastikan data benar?",
            text: "mohon dikoreksi kembali, Data akan disimpan!",
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
                save_booking_slot();
            }
        });
});

function save_booking_slot() {
    showLoading();
    // swal.showLoading();
    var id_voyage = $('.voyage-data').data('id');
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
	  //defined form
    var formData = new FormData($('.form-transaction')[0]);
    formData.append('id_member', id_member);
    formData.append('id_voyage', id_voyage);
    formData.append('tax_status', tax_status);
    formData.append('materai_status', materai_status);
    $.ajax({
        url: url_controller+'save_transaction?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                alert_success('Data berhasil disimpan');
                location.href = url_controller+'detail?data='+data.code+'&token='+_token_user
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}


$(document).on('click', '.change_materai', function () {
    
    $(this).toggleClass('on');
    materai_status = $(this).hasClass('on') ? 1 : 0;
});

$(document).on('click', '.change_status', function () {
    
    $(this).toggleClass('on');
    tax_status = $(this).hasClass('on') ? 1 : 0;
    if (tax_status == 1) {
        $('.tax_value').css('display', 'flex');
    } else {
        $('.tax_value').css('display', 'none');
    }
});

$(document).on('keyup', '.count_price_item', function () { 
    selector = $(this);
    var value = selector.val() == '' ? 0 : parseInt(clear_dot_value(selector.val()));
    console.log(value);
    var qty = selector.data('qty');
    var target = selector.data('target');
    var total_price = value * qty;
    $('.' + target).text(money_function(total_price.toString()));
    //grand total
    count_grand_total_price_detail();
});

$(document).on('click', '.btn_update_price_countainer', function () {
    var type    = $(this).data('type');
    var id      = $(this).data('id');
    var depo    = $(this).data('depo');
    var customer = $(this).data('customer');
    var price = $(this).data('price');

    showLoading();
    $.ajax({
        url: url_controller+'get_list_price?token='+_token_user,
        type: "POST",
        data: {'type':type,'id':id,'depo':depo,'customer':customer,'price':price},
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                $('.html_respon_price').html(data.html_respon);
                $('#modal_update_price').modal('show');
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
});

$(document).on('click', '.btn_use_price', function () { 
    var type = $(this).data('type');
    var id = $(this).data('id');
    var price = $(this).data('price');

    showLoading();
    $.ajax({
        url: url_controller+'update_price_countainer?token='+_token_user,
        type: "POST",
        data: {'type':type,'id':id,'price':price},
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                if (type == 1) {
                    $('.price_freight_' + id).val(money_function(price.toString()));
                } else {
                    $('.price_thc_' + id).val(money_function(price.toString()));
                }
                notif_success('harga diperbaharui');
                $('#modal_update_price').modal('hide');

                count_grand_total_price_countainer();
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
});

function validate_confirm() {
    status_validate = 1;
    $('.count_price_item').each(function () {
        selector = $(this);
        var value_current = clear_dot_value(selector.val());
        if (parseInt(value_current) == 0) {
            status_validate = 0;
        }
    });
}

$('.btn_confirm').click(function () {
    validate_confirm();
    if (status_validate == 0) {
        alert_error('Lengkapi Harga, ada harga yang masih Rp.0');
        return false;
    }

    var id = $(this).data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "data booking kontainer akan disimpan!",
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
                url: url_controller+'confirm_order?token='+_token_user,
                type: "POST",
                data: {'id':id},
                dataType :"JSON",
                success: function (data) {
                    hideLoading();
                    if(data.status){
                        notif_success('Data berhasil disimpan');
                        location.reload();
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

$('.btn_reject').click(function () { 
    $('#form-reject-data')[0].reset();
    $('#modal_form_reject').modal('show');
});


$('.btn_save_reject').click(function () {
    var id = $('.btn_reject').data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "data booking ditolak!",
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
            var formData = new FormData($('#form-reject-data')[0]);
            formData.append('id', id);
            $.ajax({
                url: url_controller+'reject_order?token='+_token_user,
                type: "POST",
                data: formData,
                contentType: false,
                processData : false,
                dataType :"JSON",
                success: function (data) {
                    hideLoading();
                    if(data.status){
                        notif_success('Data berhasil disimpan');
                        location.reload()
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

function count_grand_total_price_countainer() {
    var grand_total_freight = 0;
    var grand_total_thc = 0;
    //count freight

    $('.price_freight ').each(function () { 
        selector = $(this);
        var id_current = $(this).data('id');
        var qty = selector.data('qty');

        //freight
        var value_freight = selector.val() == '' ? 0 : parseInt(clear_dot_value(selector.val()));
        var total_price_freight = value_freight * qty;
        grand_total_freight += total_price_freight;

        $('.span_price_freight_' + id_current).text(money_function(value_freight.toString()));
        $('.span_total_price_freight_' + id_current).text('Rp.'+money_function(total_price_freight.toString()));
        
        //thc
        var value_thc = $('.price_thc_'+id_current).val() == '' ? 0 : parseInt(clear_dot_value($('.price_thc_'+id_current).val()));
        var total_price_thc = value_thc * qty;
        grand_total_thc += total_price_thc;

        $('.span_price_thc_' + id_current).text(money_function(value_thc.toString()));
        $('.span_total_price_thc_' + id_current).text('Rp.'+money_function(total_price_thc.toString()));

        // total per id 
        grand_total_id = total_price_freight + total_price_thc;
        $('.text-count-' + id_current).text(money_function(grand_total_id.toString()));
        
    });

    var tax_freight = $('.text-total-tax-freight').data('tax');
    var price_tax_freight = grand_total_freight * (parseInt(tax_freight) / 100);
    $('.text-total-price-freight').text('Rp.' + money_function(price_tax_freight.toString()));
    var all_total_freight = price_tax_freight + grand_total_freight;
    $('.text-grand-total-freight').text('Rp. ' + money_function(all_total_freight.toString()));

    var price_tax_thc = grand_total_thc * (parseInt(tax_freight) / 100);
    $('.text-total-price-thc').text('Rp.' + money_function(price_tax_thc.toString()));
    var all_total_thc = price_tax_thc + grand_total_thc;
    $('.text-grand-total-freight').text('Rp. ' + money_function(all_total_thc.toString()));

    var price_materai = $('.text-materai').data('price');

    var all_total = all_total_freight + all_total_thc + parseInt(price_materai);
    $('.all-grand-total-price').text('Rp. ' + money_function(all_total.toString()));
}

$(document).on('keyup', '.price_lc', function () { 
    count_grand_total_price_lc();
});



function count_grand_total_price_lc() {
    var grand_total = 0;
    $('.price_lc').each(function () { 
        selector = $(this);
        var id_current = selector.data('id');
        var qty = selector.data('qty');
        var value = selector.val() == '' ? 0 : parseInt(clear_dot_value(selector.val()));

        var total_price = (qty * value);
        grand_total += total_price;
        $('.text-count-lc-' + id_current).text('Rp.'+money_function(total_price.toString()));
    });

    $('.text-grand-total-lc').text('Rp.' + money_function(grand_total.toString()));
    var tax_value = $('.text-tax-lc').data('tax');
    var tax_price = grand_total * (parseInt(tax_value) / 100);
    $('.text-tax-lc').text('Rp.' + money_function(tax_price.toString()));

    var all_total = tax_price + grand_total;
    $('.all-total-lc').text('Rp.' + money_function(all_total.toString()));
}

$(document).on('click', '.btn_save_price_lc', function () {
    var id = $(this).data('id');
    var price = $('.lc_' + id).val();
    var qty = $('.lc_' + id).data('qty');

    $.ajax({
        url: url_controller+'update_price_lc?token='+_token_user,
        type: "POST",
        data: {'id':id,'price':price,'qty':qty},
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                notif_success('Data berhasil disimpan');
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
});

function clear_dot_value(value) {
    var array_value = value.split('.');
    var count_array = array_value.length;
    payment_value = value;
    for (var i = 0; i < count_array; i++) {
        payment_value = payment_value.replace('.', '');
    };
    return payment_value;
}


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
