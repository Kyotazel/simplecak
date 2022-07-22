var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;

// console.log(url_controller);

swal({
    title: "Aktivasi Berhasil",
    text: "Klik tombol dibawah untuk ke halaman login",
    type: "success",
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Halaman Login",
    closeOnConfirm: true,
    closeOnCancel: true
},
    function (isConfirm) {
        location.href = baseUrl + '/' + prefix_folder_admin + '/' + 'login/'
    }
);