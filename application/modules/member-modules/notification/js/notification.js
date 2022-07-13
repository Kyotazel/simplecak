var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function () {
    $('.chosen').chosen();

});

$(document).on('click', '.mark-all-data', function () {
    mark_all();
});
function mark_all() {
    showLoading();
    $.ajax({
        url: url_controller+'mark_all?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            if (data.status) {
                location.reload();
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hidewLoading();
        }
    });//end ajax
}

$(document).on('click', '.mark_item', function () { 
    var id = $(this).data('id');
    mark_item(id);
});

function mark_item(id) {
    showLoading();
    $.ajax({
        url: url_controller+'mark_item?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function (data) {
            if (data.status) {
                location.href = data.redirect;
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
    });//end ajax
}