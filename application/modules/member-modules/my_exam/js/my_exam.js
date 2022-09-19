var url_controller = baseUrl + "/" + "member-area" + "/" + _controller + "/";
var save_method;
var id_use = 0;

function show_exam(id) {
  $.ajax({
    url: url_controller + "get_exam?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      $(".html_start").html(data.html);
      $(".modal-title").text(data.title);
      $("#modal_start").modal("show");
    },
  });
}

function join_exam(id) {
  $.ajax({
    url: url_controller + "save_exam_participant?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      if (data.status) {
        window.location.href = "do_examination?token" + _token_user;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}
