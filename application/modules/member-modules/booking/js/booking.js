var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
var table_proceed;

$(document).ready(function () {
    // var type = $('.container_list').data('type');
    if ($(document).find('.countdown_ticket').length) {
        countdown_timer_ticket();
    }

    if($('#table_unloading').length){
        list_data_unloading(0);
    }
    if($('#table_return').length){
        list_data_return(0);
    }
    
    
    if($('.html_respon_order').length){
        list_data(0);
    }
    
    // countdown_timer_ticket();
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
    var status_filter = 'all';
    if ($('.status_booking_chosen.active').length) {
        status_filter = $('.status_booking_chosen.active').data('value');
    }
    var formData = new FormData($('#form-search')[0]);
    formData.append('status_search', status);
    formData.append('status_filter',status_filter);
    $.ajax({
        url: url_controller+'list_data/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            $('.html_respon_order').html(data.html_respon);
            if ($(document).find('.countdown_ticket').length) {
                countdown_timer_ticket();
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}

$(document).on('click', '.status_booking_chosen', function () { 
    var selector = $(this);
    var value = $(this).data('value');
    $('.status_booking_chosen').removeClass('active');
    selector.addClass('active');

    if (value == 'proceed') {
        $('.html_proceed_status').show();
    } else {
        if (!parseInt(value) > 0) {
            $('.html_proceed_status').hide();
        }
        
    }

    list_data(1);
});

$(document).on('click', '.btn_cancel_order', function () {
    id_use = $(this).data('id');
    $('#form-reject-data')[0].reset();
    $('#modal_form_reject').modal('show');
});

$('.btn_save_reject').click(function () {
    swal({
        title: "Apakah anda yakin?",
        text: "data booking dibatalkan!",
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
            formData.append('id', id_use);
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

//====================================================== UNLOADING COUNTAINER ================================================================

function countdown_timer_unloading() {
    var x = setInterval(function() {
        $('.countdown_unloading').each(function () {
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

function countdown_up_unloading() {
    var x = setInterval(function() {
        $('.countup_unloading').each(function () {
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
            var distance = now - countDownDate ;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            selector.find('.text_day').text(days);
            selector.find('.text_hour').text(hours);
            selector.find('.text_minute').text(minutes);
            selector.find('.text_second').text(seconds);
        });

    }, 1000);
}

function list_data_unloading(status) {
    showLoading();
    var formData = new FormData($('#form-search-unloading')[0]);
    formData.append('status_search', status);
    $.ajax({
        url: url_controller+'list_data_unloading/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if ($.fn.DataTable.isDataTable('#table_unloading')) {
                table.destroy();
            }
            table = $('#table_unloading').DataTable({
                data: data.list.data,
                "columns": [
                    { "width": "5%" },
                    { "width": "20%" },
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "30%" },
                ]
            });

            countdown_timer_unloading();
            countdown_up_unloading();

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

$(document).on('click', '.btn_search_unloading', function (e) { 
    e.preventDefault(); 
    list_data_unloading(1);
});


//================================================ RETURN KONTAINER ==============================================
function list_data_return(status) {
    showLoading();
    var formData = new FormData($('#form-search-return')[0]);
    formData.append('status_search', status);
    $.ajax({
        url: url_controller+'list_data_return/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if ($.fn.DataTable.isDataTable('#table_return')) {
                table.destroy();
            }
            table = $('#table_return').DataTable({
                data: data.list.data,
                "columns": [
                    { "width": "5%" },
                    { "width": "20%" },
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "15%" },
                    { "width": "30%" },
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


$(document).on('click', '.btn_search_return', function (e) { 
    e.preventDefault(); 
    list_data_return(1);
});

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



$(document).on('keyup', '.rupiah', function () {
    var new_val = money_function($(this).val());
    $(this).val(new_val);
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
