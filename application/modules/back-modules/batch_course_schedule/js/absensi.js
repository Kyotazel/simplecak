var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;
table = $('#table_absensi').DataTable({})

console.log(url_controller);

$(document).ready(function () {
    table.destroy();
    table = $('#table_absensi').DataTable({
        "ajax": {
            "url": url_controller + "list_peserta" + "?token=" + _token_user,
            "type": "POST",
            "data": {'id': $("#id").val()}
        },
        "columnDefs" : [
            {
                "targets" : 2,
                "className" : "text-center"
            }
        ]
    })
})

function setAbsen(account, schedule) {
    console.log(account);
    console.log(schedule);
}