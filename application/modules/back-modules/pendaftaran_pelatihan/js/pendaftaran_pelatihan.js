var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass("is-invalid");
    $(".invalid-feedback").empty();
    var formData = new FormData($('#form-input')[0]);
    var url = "save";
    $.ajax({
        url: url_controller + url + '?token' + _token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                swal({
                    title: "Penambahan Berhasil",
                    text: "Klik tombol dibawah untuk ke halaman daftar pelatihan",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Halaman daftar",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                    function (isConfirm) {
                        location.href = baseUrl + "/" + prefix_folder_admin + "/" + "batch_course" + "?token=" + _token_user;
                    }
                );
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})