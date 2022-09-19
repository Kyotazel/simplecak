var url_controller =
  baseUrl + "/" + prefix_folder_admin + "/" + _controller + "/";
var save_method;
var id_use = 0;
var table;
var table_canceled_exam;
var table_finished_exam;
var table_recap;
var id_batch_course = $("#id_batch_course").val();

$(document).ready(function () {
  table = $("#table-examination").DataTable({
    ajax: {
      url: url_controller + "/list_data",
      type: "POST",
    },
    columnDefs: [
      {
        targets: [3, 4],
        className: "text-center",
      },
    ],
  });

  table_canceled_exam = $("#table_canceled_exam").DataTable({
    ajax: {
      url: url_controller + "list_data_canceled",
      type: "POST",
    },
    columnDefs: [
      {
        targets: [4, 5],
        className: "text-center",
      },
    ],
  });

  table_canceled_exam = $("#table_finished_exam").DataTable({
    ajax: {
      url: url_controller + "list_data_finished",
      type: "POST",
    },
    columnDefs: [
      {
        targets: [4, 5],
        className: "text-center",
      },
    ],
  });

  table_recap = $("#table_recap").DataTable({
    ajax: {
      url: url_controller + "list_data_recap",
      data: { id: id_batch_course },
      type: "POST",
    },
  });

  get_active_exam();
});

function add() {
  get_package();
  save_method = "add";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input")[0].reset();
  $("#modal-examination").modal("show");
  $(".modal-title").text("TAMBAH UJIAN ONLINE");
}

function get_package() {
  var id_type_package = $("#id_type_package").val();
  $.ajax({
    url: url_controller + "get_list_package",
    type: "POST",
    data: { id_type_package: id_type_package },
    dataType: "HTML",
    success: function (data) {
      $(".html_content_package").html(data);
      // $('.table_package').DataTable();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}

$(".btn_save").click(function (e) {
  e.preventDefault();
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  var formData = new FormData($(".form_input")[0]);
  var url;
  var status;
  if (save_method == "add") {
    url = "save";
    status = "Ditambahkan";
  } else {
    url = "update";
    status = "Diubah";
    formData.append("id", id_use);
  }

  var agree = $("#agree");
  if (agree.prop("checked") == false) {
    $("#notif_aggree").text("(harus dicentang untuk Pembuatan Akun)");
  } else {
    $.ajax({
      url: url_controller + url + "?token" + _token_user,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function (data) {
        if (data.status) {
          notif({
            msg: `<b>Sukses : </b> Data berhasil ${status}`,
            type: "success",
          });
          table.ajax.reload(null, false);
          $("#modal-examination").modal("hide");
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
            $('[name="' + data.inputerror[i] + '"]')
              .next()
              .html(data.error_string[i]);
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $(".btn_save_group").button("reset");
      },
    });
  }
});

function get_detail(id) {
  $(".modal-title").text("DETAIL AKUN UJIAN");
  $.ajax({
    url: url_controller + "/get_detail_account/" + id,
    type: "GET",
    dataType: "HTML",
    success: function (data) {
      $(".html_detail_account").html(data);
      $("#modal_detail_account").modal("show");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}

function cancel_exam(id) {
  swal(
    {
      title: "apakah anda yakin ?",
      text: "ujian ini akan dibatalkan!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes ",
    },
    function (isConfirm) {
      $.ajax({
        url: url_controller + "/cancel_exam/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
          //if success
          $("#modal_detail_account").modal("hide");
          table.ajax.reload(null, false);
          table_canceled_exam.ajax.reload(null, false);
          alert_success("ujian berhasil dibatalkan");
        },
        error: function (jqXHR, textStatus, errorThrown) {
          alert("Error deleting data");
        },
      });
    }
  );
}

function confirm_exam(id) {
  var password = $("#confirm_password").val();
  var post_data = { id: id, password: password };
  if (password == "") {
    $("#confirm_password").addClass("is-invalid");
    $("#confirm_password").next().html("Password Harus Diisi");
  } else {
    $.ajax({
      url: url_controller + "/confirm_exam",
      type: "POST",
      data: post_data,
      dataType: "JSON",
      success: function (data) {
        if (data.status) {
          $("#modal_detail_account").modal("hide");
          table.ajax.reload();
          notif({
            msg: `<b>Sukses : </b> Ujian Berhasil Dikonfirmasi`,
            type: "success",
          });
          get_active_exam();
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
            $('[name="' + data.inputerror[i] + '"]')
              .next()
              .html(data.error_string[i]);
          }
        }
      },
    });
  }
}

function get_active_exam() {
  $.ajax({
    url: url_controller + "/get_active_exam",
    type: "GET",
    dataType: "HTML",
    success: function (data) {
      $("#html_active_exam").html(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}

function validate_event(id) {
  $(".notif_validate").empty();
  $(".hidden_element").html(
    '<input type="hidden" id="id_account_exam" value="' + id + '" >'
  );
  $("#modal_confirm_account").modal("show");
}

function validate_monitoring_exam() {
  var password = $("#confirm_password_login").val();
  var id_account_exam = $("#id_account_exam").val();
  var post_data = { password: password, id_account_exam: id_account_exam };
  $(".notif_validate").empty();
  $.ajax({
    url: url_controller + "/validate_monitoring",
    type: "POST",
    data: post_data,
    dataType: "JSON",
    success: function (data) {
      if (data.status) {
        window.location.href = url_controller + "monitoring";
      } else {
        $(".notif_validate").text("(maaf, validasi password salah)");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}

function recapitulation_exam() {
  $("#modal_recap").modal("show");
}

function recap_confirm() {
  var password = $("#confirm_password_recap").val();
  var post_data = { password: password };
  $(".notif_validate").empty();
  $.ajax({
    url: url_controller + "/validate_close_monitoring",
    type: "POST",
    data: post_data,
    dataType: "JSON",
    success: function (data) {
      if (data.status) {
        window.location.href = url_controller;
      } else {
        $(".notif_validate").text("(maaf, validasi password salah)");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  });
}
