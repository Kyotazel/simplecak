var url_controller = baseUrl + "/" + prefix_folder_admin + "/";
var save_method;
var id_use = 0;
var id_parent = $("#id_parent").val();

if ($(".ckeditor_forma").length) {
  $(".ckeditor_forma").ckeditor({
    height: 100,
    removePlugins :'a11yhelp,about,bidi,blockquote,colorbutton,colordialog,contextmenu,copyformatting,dialogadvtab,elementspath,enterkey,entities,find,flash,floatingspace,font,format,forms,horizontalrule,indentblock,indentlist,justify,language,link,list,liststyle,magicline,newpage,pagebreak,pastefromword,pastetext,print,removeformat,resize,save,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table,tableselection,tabletools,templates,undo,wsc,paste'
  });

  $(document).on("click", ".n1ed_btn_minimize", function () {
    $(".main-body").attr("style", "height: auto !important");
  });
}

$(".btn_save").click(function (e) {
  e.preventDefault();
  $(".form-control").removeClass("is-invalid");
  $(".invalid-feedback").empty();
  var formData = new FormData($(".form_input")[0]);
  var url;
  var status;
  save_method = $(this).data("method");
  var text_question = CKEDITOR.instances["text_question"].getData();
  var result_1 = CKEDITOR.instances["result_1"].getData();
  var result_2 = CKEDITOR.instances["result_2"].getData();
  var result_3 = CKEDITOR.instances["result_3"].getData();
  var result_4 = CKEDITOR.instances["result_4"].getData();
  var result_5 = CKEDITOR.instances["result_5"].getData();
  var solution = CKEDITOR.instances["solution"].getData();
  if (save_method === "add") {
    url = "save";
    status = "Ditambahkan";
    formData.append("text_question", text_question);
    formData.append("result_1", result_1);
    formData.append("result_2", result_2);
    formData.append("result_3", result_3);
    formData.append("result_4", result_4);
    formData.append("result_5", result_5);
    formData.append("solution", solution);
  } else {
    url = "update";
    status = "Diubah";
    formData.append("id", $(this).data("id"));
    formData.append("text_question", text_question);
    formData.append("result_1", result_1);
    formData.append("result_2", result_2);
    formData.append("result_3", result_3);
    formData.append("result_4", result_4);
    formData.append("result_5", result_5);
    formData.append("solution", solution);
  }

  $.ajax({
    url:
      url_controller +
      "package_question/question/" +
      url +
      "?token" +
      _token_user,
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
        location.href = data.redirect;
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
});

$(document).on("click", ".btn_delete", function () {
  id = $(this).data("id");
  var redirect = $(this).data("redirect");
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
          url: url_controller + "package_question/" + "delete_data" + "?token=" +_token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              notif({
                msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                type: "success",
              });

              if (redirect == 1) {
                location.href = url_controller + "package_question";
              } else {
                table.ajax.reload(null, false);
              }
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {},
        });
      }
    }
  );
});


$(document).on("click", ".btn_delete_question", function () {
  id = $(this).data("id");
  var redirect = $(this).data("redirect");
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
          url: url_controller + "package_question/question/" + "delete_data" + "?token=" +_token_user,
          type: "POST",
          dataType: "JSON",
          data: { id: id },
          success: function (data) {
            if (data.status) {
              notif({
                msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                type: "success",
              });

              if (redirect == 1) {
                location.href = url_controller + "package_question";
              } else {
                table.ajax.reload(null, false);
              }
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {},
        });
      }
    }
  );
});
