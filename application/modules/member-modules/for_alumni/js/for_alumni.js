var url_controller = baseUrl + "/" + "member-area" + "/" + _controller + "/";
var save_method;
var id_use = 0;

$('.asdas').summernote({
  placeholder: 'Hello bootstrap 4',
  tabsize: 3,
  height: 300
});

$(".dropify").dropify({
  messages: {
    default: "klik disini untuk upload cv",
    replace: "klik disini untuk replace cv",
    remove: "Remove",
    error: "Ooops, something wrong appended.",
  },
  error: {
    fileSize: "The file size is too big (2M max).",
  },
});

$(".btn_save_cv").click(function (e) {
  e.preventDefault();
  $(".invalid-cv").addClass("d-none");
  $(".invalid-cv").removeClass("d-block");
  var formData = new FormData($(".form-input")[0]);

  // console.log(formData); return;

  $.ajax({
    url: url_controller + "save_cv" + "?token" + _token_user,
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    dataType: "JSON",
    success: function (data) {
      if (data.status) {
        swal({
          title: "Upload Berhasil",
          text: "CV Kamu berhasil di upload",
          type: "success",
        });
        window.location.href = data.redirect;
      } else {
        $(".invalid-cv").html(data.error_string);
        $(".invalid-cv").removeClass("d-none");
        $(".invalid-cv").addClass("d-block");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $(".btn_save_group").button("reset");
    },
  });
});

$(".btn_delete_extern").click(function (e) {
  e.preventDefault();
  id = $(this).data("id");
  swal(
    {
      title: "Apakah anda yakin?",
      text: "data akan dihapus!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Ya , Lanjutkan",
      cancelButtonText: "Batal",
      closeOnConfirm: true,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: url_controller + "delete_data" + "?token=" + _token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              swal({
                title: "Hapus Berhasil",
                text: "CV Kamu berhasil di hapus",
                type: "success",
              });
              window.location.href = data.redirect;
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {},
        });
      }
    }
  );
});

$(".btn_edit_salary").click(function () {
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_salary")[0].reset();
  $(".modal-title").text("EDIT DATA");
  $("#modal_salary").modal("show");
});

$(".btn_save_salary").click(function (e) {
  e.preventDefault();
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  var formData = new FormData($(".form_input_salary")[0]);
  $.ajax({
    url: url_controller + "salary_edit" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status) {
        notif({
          msg: `<b>Sukses : </b> Data berhasil ${status}`,
          type: "success",
        });
        window.location.href = data.redirect
        $("#modal_salary").modal("hide");
      } else {
        for (var i = 0; i < data.inputerror.length; i++) {
          $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
          $('[name="' + data.inputerror[i] + '"]').next().html(data.error_string[i]);
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {},
  });
});

$(".btn_edit_about_me").click(function () {
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_about_me")[0].reset();
  $(".modal-title").text("EDIT DATA");
  $("#modal_about_me").modal("show");
});