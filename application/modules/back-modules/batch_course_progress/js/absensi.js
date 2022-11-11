var url_controller = baseUrl + '/' + prefix_folder_admin + '/';
var save_method;
var id_batch_course_attendance = 0;
var id_batch_course_account = 0;
var table;
table = $('#table_absensi').DataTable({})


$(document).ready(function () {
    table.destroy();
    table = $('#table_absensi').DataTable({
        "ajax": {
            "url": url_controller + "batch_course_progress/schedule/list_peserta" + "?token=" + _token_user,
            "type": "POST",
            "data": { 'id': $("#id").val() }
        },
        "columnDefs": [
            {
                "targets": 2,
                "className": "text-center"
            }
        ]
    })
})

$(document).on('click', '.popupqrcode', function (e) {
    e.preventDefault();
    // console.log("Tes Ok");
    $('.modal img').attr('src', $(this).attr('src'))
    $('#popup').modal('show');
})

$(document).on('click', '.btn_absensi', function () {
    id_batch_course_schedule = $(this).data('idschedule');
    id_batch_course_account = $(this).data('idaccount');
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#modal_absensi').modal('show');
})

$(".btn_save").on("click", function () {
    $.ajax({
        'url': url_controller + "batch_course_progress/schedule/add_attendance" + "?token=" + _token_user,
        type: "POST",
        dataType: "JSON",
        data: { id_batch_course_account: id_batch_course_account, id_batch_course_schedule: id_batch_course_schedule, status: $("#status_attendance").val() },
        success: function (data) {
            if (data.status) {
                $('#modal_absensi').modal('hide');
                notif({
                    msg: "<b>Sukses : </b> Berhasil Melakukan Absensi",
                    type: "success"
                })
                table.ajax.reload();
                $( "#here" ).load(window.location.href + " #here" ); 
            }
        }
    })
})

$(document).on('click', '.btn_delete_absensi', function () {
    id_batch_course_schedule = $(this).data('idschedule');
    id_batch_course_account = $(this).data('idaccount');
    swal({
        title: "Apakah anda yakin?",
        text: "data akan dihapus!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya , Lanjutkan",
        cancelButtonText: "Batal",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url_controller+'batch_course_progress/schedule/delete_data_absensi'+'?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data: {'id_batch_course_schedule': id_batch_course_schedule, 'id_batch_course_account' : id_batch_course_account},
                success: function(data) {
                    if(data.status) {
                        notif({
                            msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                            type: "success"
                        })
                        table.ajax.reload();
                        $( "#here" ).load(window.location.href + " #here" ); 
                    }
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }
            })
        }
    }
    )
})