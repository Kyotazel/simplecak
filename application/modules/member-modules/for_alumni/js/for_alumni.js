var url_controller = baseUrl + "/" + "member-area" + "/" + _controller + "/";
var save_method;
var id_use = 0;

if ($(".ckeditor_forma").length) {
  $(".ckeditor_forma").ckeditor({
    height: 100,
    removePlugins :'a11yhelp,about,basicstyles,bidi,blockquote,clipboard,colorbutton,colordialog,contextmenu,copyformatting,dialogadvtab,div,elementspath,enterkey,entities,filebrowser,find,flash,floatingspace,font,format,forms,horizontalrule,htmlwriter,iframe,image,indentblock,indentlist,justify,language,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastefromword,pastetext,preview,print,removeformat,resize,save,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table,tableselection,tabletools,templates,toolbar,undo,uploadimage,wsc,N1ED-editor'
  });

  $(document).on("click", ".n1ed_btn_minimize", function () {
    $(".main-body").attr("style", "height: auto !important");
  });
}

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
          msg: `<b>Sukses : </b> Data berhasil diubah`,
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

$(".btn_save_about_me").click(function (e) {
  e.preventDefault();
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  var formData = new FormData($(".form_input_about_me")[0]);
  var description = CKEDITOR.instances["description_about_me"].getData();
  formData.append("description", description);
  $.ajax({
    url: url_controller + "about_me_edit" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status) {
        notif({
          msg: `<b>Sukses : </b> Data berhasil diubah`,
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

$(".btn_add_experience").click(function () {
  save_method = "add";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_experience")[0].reset();
  $(".modal-title").text("TAMBAH DATA");
  $("#modal_experience").modal("show");
});

$(".btn_save_experience").click(function (e) {
  e.preventDefault();
  var formData = new FormData($(".form_input_experience")[0]);
  if (save_method == "add") {
    url = "save"
  } else {
    url = "update"
    formData.append("id", id_use)
  }
  var description = CKEDITOR.instances["description_experience"].getData();
  formData.append("description", description);
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $.ajax({
    url: url_controller + "experience_" + url + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status) {
        notif({
          msg: `<b>Sukses : </b> Data berhasil diubah`,
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

$(".btn_delete_experience").click(function (e) {
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
          url: url_controller + "delete_experience" + "?token=" + _token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              swal({
                title: "Hapus Berhasil",
                text: "Pengalaman berhasil dihapus",
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

$(".btn_edit_experience").click(function (e) {
  e.preventDefault();
  id = $(this).data("id");
  id_use = id
  save_method = "edit";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_experience")[0].reset();
  $(".modal-title").text("EDIT DATA");

  $.ajax({
    url: url_controller + "get_data_experience" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: {id:id},
    success: function(data) {
      if(data.status) {
        $('[name="company_name"]').val(data.data.company_name);
        $('[name="description_experience"]').val(data.data.description);
        $('[name="position"]').val(data.data.position);
        $('[name="start_month"]').val(data.data.started_date.substr(5,2));
        $('[name="start_year"]').val(data.data.started_date.substr(0,4));
        $('[name="end_month"]').val(data.data.end_date.substr(5,2));
        $('[name="end_year"]').val(data.data.end_date.substr(0,4));
        $("#modal_experience").modal("show");
      }
    }
  })

});

$(".btn_add_education").click(function () {
  save_method = "add";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_education")[0].reset();
  $(".modal-title").text("TAMBAH DATA");
  $("#modal_education").modal("show");
});

$(".btn_save_education").click(function (e) {
  e.preventDefault();
  var formData = new FormData($(".form_input_education")[0]);
  if (save_method == "add") {
    url = "save"
  } else {
    url = "update"
    formData.append("id", id_use)
  }
  var description = CKEDITOR.instances["description_education"].getData();
  formData.append("description", description);
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $.ajax({
    url: url_controller + "education_" + url + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status) {
        notif({
          msg: `<b>Sukses : </b> Data berhasil diubah`,
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

$(".btn_delete_education").click(function (e) {
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
          url: url_controller + "delete_education" + "?token=" + _token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              swal({
                title: "Hapus Berhasil",
                text: "Pengalaman berhasil dihapus",
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

$(".btn_edit_education").click(function (e) {
  e.preventDefault();
  id = $(this).data("id");
  id_use = id
  save_method = "edit";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_education")[0].reset();
  $(".modal-title").text("EDIT DATA");

  $.ajax({
    url: url_controller + "get_data_education" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: {id:id},
    success: function(data) {
      if(data.status) {
        $('[name="school_name"]').val(data.data.school_name);
        $('[name="description_education"]').val(data.data.description);
        $('[name="study_program"]').val(data.data.study_program);
        $('[name="start_year"]').val(data.data.started_date);
        $('[name="end_year"]').val(data.data.end_date);
        $("#modal_education").modal("show");
      }
    }
  })

});

$(".btn_add_skill").click(function () {
  save_method = "add";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_skill")[0].reset();
  $(".modal-title").text("TAMBAH DATA");
  $("#modal_skill").modal("show");
});

$(".btn_save_skill").click(function (e) {
  e.preventDefault();
  var formData = new FormData($(".form_input_skill")[0]);
  if (save_method == "add") {
    url = "save"
  } else {
    url = "update"
    formData.append("id", id_use)
  }
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $.ajax({
    url: url_controller + "skill_" + url + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status) {
        notif({
          msg: `<b>Sukses : </b> Data berhasil diubah`,
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

$(".btn_delete_skill").click(function (e) {
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
          url: url_controller + "delete_skill" + "?token=" + _token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              swal({
                title: "Hapus Berhasil",
                text: "Pengalaman berhasil dihapus",
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

$(".btn_edit_skill").click(function (e) {
  e.preventDefault();
  id = $(this).data("id");
  id_use = id
  save_method = "edit";
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  $(".form_input_skill")[0].reset();
  $(".modal-title").text("EDIT DATA");

  $.ajax({
    url: url_controller + "get_data_skill" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    data: {id:id},
    success: function(data) {
      if(data.status) {
        $('[name="skill"]').val(data.data.skill);
        $("#modal_skill").modal("show");
      }
    }
  })

});