var url_controller =
  baseUrl + "/" + prefix_folder_admin + "/" + _controller + "/";
var save_method;
var id_use = 0;

$(document).ready(function () {
  //-----------success toast --------
  //showSuccessToast('data berhasil');
  //----------info toast-----------
  //showInfoToast('this is info');
  //-----------warning  toast-----------
  //showWarningToast('this is warning toast');
  //----------danger toast------
  //showDangerToast('this is danger toast');
  hitung();
  // setInterval('autoRefreshPage()', 10000);
  get_question_exam(1);
  check_status_exam();
});

var jam = parseInt($("#hour_exam").val());
var menit = parseInt($("#minute_exam").val());
var detik = parseInt($("#second_exam").val());
function hitung(time) {
  /** setTimout(hitung, 1000) digunakan untuk
   * mengulang atau merefresh halaman selama 1000 (1 detik)
   */

  /** Jika waktu kurang dari 10 menit maka Timer akan berubah menjadi warna merah */
  if (menit == 10 && jam == 0 && detik == 0) {
    alert_error("Waktu anda Kurang 10 menit lagi");
  }

  /** Menampilkan Waktu Timer pada Tag #Timer di HTML yang tersedia */
  if (jam < 0) {
    $("#timer").text("waktu habis");

    $.ajax({
      url: url_controller + "timeout" + "?token" + _token_user,
      type: "POST",
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function (data) {
        $("#modal-timeout-exam").modal("show");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
    });
  } else {
    $("#timer").text(jam + " jam : " + menit + " menit : " + detik + " detik");
    setTimeout(hitung, 1000);
  }

  /** Melakukan Hitung Mundur dengan Mengurangi variabel detik - 1 */
  detik--;

  /** Jika var detik < 0
   * var detik akan dikembalikan ke 59
   * Menit akan Berkurang 1
   */
  if (detik < 0) {
    detik = 59;
    menit--;

    /** Jika menit < 0
     * Maka menit akan dikembali ke 59
     * Jam akan Berkurang 1
     */
    if (menit < 0) {
      menit = 59;
      jam--;

      /** Jika var jam < 0
       * clearInterval() Memberhentikan Interval dan submit secara otomatis
       */

      if (jam < 0) {
        clearInterval(hitung);
        // $('#modal-finish-exam').modal('show');
      }
    }
  }
}

var number_page = 1;
function get_question_exam(page_request) {
  $.ajax({
    url: url_controller + "/get_question_examination/" + page_request,
    type: "GET",
    dataType: "HTML",
    success: function (data) {
      $("#html_question").html(data);
      show_pagination(page_request);
      number_page = page_request;
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("failed load question");
    },
  });
}

function show_pagination(page_request) {
  $.ajax({
    url: url_controller + "/show_pagination",
    type: "GET",
    dataType: "HTML",
    success: function (data) {
      $(".pagination-html").html(data);
      $("#pagination_" + page_request).addClass("active");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("failed load question");
    },
  });
}

function control_page(status) {
  var count_all_question = parseInt($("#count_all_paging").val());
  if (status == 1) {
    if (number_page == count_all_question) {
      request_number_page = number_page;
    } else {
      request_number_page = number_page + 1;
    }
  } else {
    if (number_page == 1) {
      request_number_page = number_page;
    } else {
      request_number_page = number_page - 1;
    }
  }

  //show page
  get_question_exam(request_number_page);
}

function save_answer(id_question, answer) {
  var PostData = { id_question: id_question, answer: answer };
  $.ajax({
    url: url_controller + "/save_answer_examination?token=" + _token_user,
    type: "POST",
    data: PostData,
    dataType: "JSON",
    success: function (data) {
      notif_success("Jawaban disimpan");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("error process");
    },
  }); //end ajax
}

function show_resume_answer() {
  $(".modal-title").text("RANGKUMAN JAWABAN SOAL");
  $.ajax({
    url: url_controller + "/list_resume_answer",
    type: "GET",
    dataType: "HTML",
    success: function (data) {
      $(".html_resume_answer").html(data);
      $("#table-resume-answer").DataTable();
      $("#modal-check-question").modal("show");
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("failed load question");
    },
  });
}

function finish_agreement() {
  swal(
    {
      title: "Apakah anda yakin?",
      text: "Klik Tombol Dibawah apabila sudah yakin!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Simpan Ujian",
      cancelButtonText: "Batal",
      closeOnConfirm: true,
      closeOnCancel: true,
    },
    function (isConfirm) {
      finish_exam();
    }
  );
}

function finish_exam() {
  $.ajax({
    url: url_controller + "/finish_examination",
    type: "POST",
    dataType: "JSON",
    success: function (data) {
      window.location.href = baseUrl + "/member-area?token=" + _token_user;
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("failed process");
    },
  });
}

function check_status_exam() {
  setTimeout(check_status_exam, 60000);
  $.ajax({
    url: url_controller + "/check_status_exam" + "?token=" + _token_user,
    type: "POST",
    dataType: "JSON",
    success: function (data) {
      if (data.status) {
        $("#modal-blocking-exam").modal("show");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("failed process");
    },
  });
}
