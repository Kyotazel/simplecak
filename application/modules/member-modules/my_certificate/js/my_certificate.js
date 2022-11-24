var url_controller = baseUrl + "/" + "member-area" + "/" + _controller + "/";
var save_method;
var id_use = 0;

$(".btn_check").click(function (e) {
  id = $(this).data("id");

  $.ajax({
    url: url_controller + "check_certificate",
    type: "POST",
    data: { id: id },
    dataType: "JSON",
    success: function (data) {
      if(data.status) {
        window.location.href = data.redirect;
      } else {
        swal(
          {
            title: "Sertifikat Belum dibuat",
            text: "Hubungi Admin untuk mendapatkan informasi lebih lanjut",
            type: "error",
          }
        )
      }
    },
  });
})