var getUrl = window.location;
var baseUrl =_base_url;
var prefix_folder_admin = 'admin';
var prefix_folder_api = 'api';


$(document).ready(function () {
	$('.horizontal-mainwrapper').show();
    $('.datepicker').datepicker({
        autoclose: true,
        dateFormat: 'yy-mm-dd'
    });
    $('.datepicker_form').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    });

    $('.datepicker_custom').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('.datetimepickera').datetimepicker({
        setDatesDisabled: true,
        autoclose: true,
        format: 'hh:ii:00'
    })

    // var today = new Date('16-01-2022');
    // console.log(today.getFullYear(),today.getMonth(),today.getDate());
    $('.datepicker-today').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    var path_current = getUrl.origin + getUrl.pathname;
    $("a[data-url='" + path_current + "']").addClass('active');
    // main-parent-menu
    $("a[data-url='" + path_current + "']").closest('.main-parent-menu').addClass('is-expanded');

    //========== custom data ============
    // show_count_confirm();
    // data_load();
});

function showLoading() {
    $('#global-loader').show();
}
function hideLoading() {
    $("#global-loader").fadeOut("slow");
}

function alert_success(msg){
    swal({
        type: 'success',
        title: msg,
        showConfirmButton: false,
        timer: 1500
    });
}


function alert_error(msg){
    swal({
        type: 'error',
        title: msg,
        showConfirmButton: false,
        timer: 1500
    });
}

function notif_success(message) {
    notif({
        msg: message,
        type: "success"
    });
}
function notif_error(message) {
    notif({
        msg: message,
        type: "error"
    });
}

$(document).on('click', '.btn_custom_minus', function () {
    selector_val = $(this).closest('.group-plus-minus').find('.value');
    if (parseInt(selector_val.val()) > 1) {
        value_int = parseInt(selector_val.val()) - 1;
        selector_val.val(value_int);
    }
    
});
$(document).on('click', '.btn_custom_plus', function () { 
    selector_val = $(this).closest('.group-plus-minus').find('.value');
    value_int = parseInt(selector_val.val()) + 1;
    console.log(value_int); 
    selector_val.val(value_int);
});

if ($('.ckeditor_form').length) {
    $('.ckeditor_form').ckeditor({
        // filebrowserBrowseUrl:baseUrl+'/admin/app_media?token='+_token_user,//url
    });

    $(document).on('click', '.n1ed_btn_minimize', function () { 
        $('.main-body').attr('style', 'height: auto !important');
    });

}

$(document).on('keyup', '.search_menu', function () {
    var value_current = $(this).val();
    autocomplete_search_menu();
});

function autocomplete_search_menu() {
    $('.search_menu').autocomplete({
        source: baseUrl+'/admin/template/search_menu?token='+_token_user,
        search: function () {
            $(".load_search_menu").show();
        },
        response: function () {
            $(".load_search_menu").hide();
        },
        select: function(event, ui) {
            event.preventDefault();
            location.href = ui.item.link;
        }
    });
}


//=========================================== module function ====================================================
function show_count_confirm() {
    
    $.ajax({
        url: baseUrl+'/admin/maintenance/count_queue_maintenance?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            // $('.count_confirm_booking').css('position', 'relative');
            if(data.count > 0){
                $('.count_maintenance > a').prepend(`
                    <span class="badge badge-primary span-counter">`+data.count+`</span>
                `);
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
    
    $.ajax({
        url: baseUrl+'/admin/booking/count_booking_confirm?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            // $('.count_confirm_booking').css('position', 'relative');
            if(data.count > 0){
                $('.count_confirm_booking > a').prepend(`
                    <span class="badge badge-primary span-counter">`+data.count+`</span>
                `);
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
    
    $.ajax({
        url: baseUrl+'/admin/transaction/count_transaction?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            if (data.status) {
                if(data.count_proceed_voyage > 0){
                    $('.count_transaction_voyage > a').prepend(`
                        <span class="badge badge-primary span-counter">`+data.count_proceed_voyage+`</span>
                    `);
                }

                if(data.count_return_countainer > 0){
                    $('.count_return_countainer > a').prepend(`
                        <span class="badge badge-primary span-counter">`+data.count_return_countainer+`</span>
                    `);
                }

                if(data.count_unloading_countainer > 0){
                    $('.count_unloading_countainer > a').prepend(`
                        <span class="badge badge-primary span-counter">`+data.count_unloading_countainer+`</span>
                    `);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
}



function data_load() {
    load_notification();
    time=setInterval(function(){
        //your code
        load_notification();
    },5000);
}

function load_notification() {
    $.ajax({
        url: baseUrl+'/'+prefix_folder_admin+'/template/load_data?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            if (data.status) {
                $('.main-notification-list').html(data.html_notification);
                $('.count-notification').text(data.count_notification);
                if (data.count_notification > 0) {
                    $('.pulse-notif').show();
                    $('.mark-notification').show();
                } else {
                    $('.pulse-notif').hide();
                    $('.mark-notification').hide();
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }
    });//end ajax
}

$(document).on('click', '.mark-notification', function () { 
    showLoading();
    $.ajax({
        url: baseUrl+'/'+prefix_folder_admin+'/template/mark_notification?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if (data.status) {
                load_notification();
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax

});


