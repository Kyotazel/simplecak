var url_controller = baseUrl + "/" + prefix_folder_admin + "/" + _controller + "/";
var save_method;
var id_use = 0;
var table;
var table_peserta = $("#table_peserta").DataTable({});

$(document).ready(function () {
  table = $("#table_data").DataTable({
    ajax: {
      url: url_controller + "list_data" + "?token=" + _token_user,
      type: "POST",
    },
    "columnDefs": [
        {
            "targets": 2,
            "className": "text-center"
        }
    ]
  });
});

function modal_peserta(batch_course) {
    table_peserta.destroy();
    $("#modal_peserta").modal("show");
    table_peserta = $("#table_peserta").DataTable({
        "ajax" : {
            "url": url_controller + "get_peserta" + "?token=" + _token_user,
            "type": "POST",
            "data": {id_batch_course: batch_course}
        },
        "columnDefs": [
            {
                "targets": [2, 3],
                "className": "text-center"
            }
        ]
    })
}

$(document).on('click', '#confirm_account', function () {
    id = $(this).data('id');
    $.ajax({
        url: url_controller + "update_confirm" + "?token=" + _token_user,
        type: "POST",
        data: {id: id},
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                notif({
                    msg: `<b>Sukses : </b> Peserta berhasil Dikonfirmasi`,
                    type: "success"
                })
                table_peserta.ajax.reload(null, false);
                table.ajax.reload(null, false);
            }
        }
    })
})

$(document).on('click', '.btn_delete_peserta', function () {
    id = $(this).data("id");
    $.ajax({
        url: url_controller + "delete_peserta" + "?token=" + _token_user,
        type: "POST",
        dataType: "JSON",
        data: {id: id},
        success: function(data) {
            notif({
                msg: `<b>Sukses : </b> Peserta berhasil Ditolak`,
                type: "success"
            })
            table_peserta.ajax.reload(null, false);
            table.ajax.reload(null, false);
        }
    })
})

function modal_detail(id) {
    $("#modal_detail_account").modal("show");
    $.ajax({
        url: url_controller + "detail_peserta" + "?token=" + _token_user,
        type: "POST",
        dataType: "HTML",
        data: {id: id},
        success: function(data) {
            $("#detail_peserta").html(data);
        }
    })
}