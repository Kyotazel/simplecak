var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
table_add = $('#table_add').DataTable({});
table_peserta = $('#table_peserta').DataTable({});

$(document).ready(function () {
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller + "list_data" + "?token=" + _token_user,
            "type": "POST",
        },
        "columns": [
            { "width": "10%" },
            { "width": "15%" },
            { "width": "20%" },
            { "width": "15%" },
            { "width": "15%" },
            { "width": "25%" },
        ],
        "columnDefs": [
            {
                "targets": 5,
                "className": "text-center"
            }
        ]
    })

    end_date = $("#end_date").val()
    var countDownDate = new Date(end_date).getTime();

    var x = setInterval(function() {

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
            $(".expired").addClass("d-block")
            $(".not_expired").addClass("d-none")
            document.getElementById('daftar').disabled = true;
          }
      
      }, 1000);

})

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formData = new FormData($('.form_input')[0]);
    var url;
    var status;
    save_method = $(this).data('method');
    var description = CKEDITOR.instances['description'].getData();
    if (save_method === 'add') {
        url = 'save';
        status = "Ditambahkan";
        formData.append('description', description);
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', $(this).data('id'));
        formData.append('description', description);
    }

    $.ajax({
        url: url_controller + url + '?token' + _token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                notif({
                    msg: `<b>Sukses : </b> Data berhasil ${status}`,
                    type: "success"
                })
                location.href = data.redirect;
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').next().html(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    console.log(id);
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
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url_controller + 'delete_data' + '?token=' + _token_user,
                    type: "POST",
                    dataType: "JSON",
                    data: { 'id': id },
                    success: function (data) {
                        if (data.status) {
                            notif({
                                msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                                type: "success"
                            })
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                })
            }
        }
    )
})

function modal_tambah(batch_course) {
    table_add.destroy();
    $("#modal_tambah").modal("show");
    table_add = $('#table_add').DataTable({
        "ajax": {
            "url": url_controller + "get_add" + "?token=" + _token_user,
            "type": "POST",
            "data": {id_batch_course: batch_course}
        }
    })
}

function modal_peserta(batch_course) {
    console.log("Tes Berhasil");
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
                "targets": 3,
                "className": "text-center"
            }
        ]
    })
}

function add_to_batch(account, batch) {
    $.ajax({
        url: url_controller + "add_account_batch" + "?token=" + _token_user,
        data: {id_account: account, id_batch: batch},
        type: "POST",
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                notif({
                    msg: `<b>Sukses : </b> Peserta berhasil ditambahkan`,
                    type: "success"
                })
                table.ajax.reload(null, false);
                $("#modal_tambah").modal("hide");
            } else {
                swal({
                    title: "Gagal Menambah",
                    text: "Tidak Bisa Menambahkan peserta karena akan melebihi total terdaftar",
                    type: "warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#modal_tambah").modal("hide");
                    }
                })
            }
        }
    })
}

$(document).on('click', '.btn_delete_peserta', function () {
    id = $(this).data("id");
    $.ajax({
        url: url_controller + "delete_peserta" + "?token=" + _token_user,
        type: "POST",
        dataType: "JSON",
        data: {id: id},
        success: function(data) {
            notif({
                msg: `<b>Sukses : </b> Peserta berhasil dihapus`,
                type: "success"
            })
            table_peserta.ajax.reload(null, false);
            table.ajax.reload(null, false);
        }
    })
})