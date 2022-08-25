var url_controller = baseUrl + "/" + prefix_folder_admin + "/";
var save_method;
var id_use = 0;
var id_parent = $("#id_parent").val();
var table = $("#table_question").DataTable({
  ajax: {
    url:
      url_controller + "package_question/question/list_data/" + id_parent + "?token=" + _token_user,
    type: "POST",
  },
  columns: [{ width: "10%" }, { width: "60%" }, { width: "20%" }],
  columnDefs: [
    {
      targets: [0, 2],
      className: "text-center",
    },
  ],
});

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
  var result_a = CKEDITOR.instances["result_a"].getData();
  var result_b = CKEDITOR.instances["result_b"].getData();
  var result_c = CKEDITOR.instances["result_c"].getData();
  var result_d = CKEDITOR.instances["result_d"].getData();
  var result_e = CKEDITOR.instances["result_e"].getData();
  var solution = CKEDITOR.instances["solution"].getData();
  if (save_method === "add") {
    url = "save";
    status = "Ditambahkan";
    formData.append("text_question", text_question);
    formData.append("result_a", result_a);
    formData.append("result_b", result_b);
    formData.append("result_c", result_c);
    formData.append("result_d", result_d);
    formData.append("result_e", result_e);
    formData.append("solution", solution);
  } else {
    url = "update";
    status = "Diubah";
    formData.append("id", $(this).data("id"));
    formData.append("text_question", text_question);
    formData.append("result_a", result_a);
    formData.append("result_b", result_b);
    formData.append("result_c", result_c);
    formData.append("result_d", result_d);
    formData.append("result_e", result_e);
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
