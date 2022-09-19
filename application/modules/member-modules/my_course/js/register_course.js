var url_controller = baseUrl + "/" + "member-area" + "/" + _controller + "/";
var save_method;
var id_use = 0;

end_date = $("#end_date").val();
var countDownDate = new Date(end_date).getTime();

var x = setInterval(function () {
  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  $(".day").html(days);
  $(".hour").html(hours);
  $(".minute").html(minutes);
  $(".second").html(seconds);

  if (distance < 0) {
    clearInterval(x);
    $(".expired").addClass("d-block");
    $(".not_expired").addClass("d-none");
    document.getElementById("daftar").disabled = true;
  }
}, 1000);

$("#daftar").click(function (e) {
  id = $(this).data("id");
  $.ajax({
    url: url_controller + "register_batch",
    type: "POST",
    data: { id: id },
    dataType: "JSON",
    success: function (data) {
      if (data.status) {
        swal(
          {
            title: "Pendaftaran Berhasil",
            text: "Klik tombol dibawah untuk kembali Dashboard",
            type: "success",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "daftar pelatihan",
            closeOnConfirm: true,
            closeOnCancel: true,
          },
          function (isConfirm) {
            location.href = url_controller;
          }
        );
      } else {
        swal(
          {
            title: data.title,
            text: data.description,
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "daftar pelatihan",
            closeOnConfirm: true,
            closeOnCancel: true,
          },
          function (isConfirm) {
            location.href = url_controller;
          }
        );
      }
    },
  });
});
