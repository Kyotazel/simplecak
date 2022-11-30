var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method, min_salary, max_salary, experience;
var id_use = 0;

$(document).ready(function () {
    $('#education').select2({
		placeholder: 'Tidak dibatasi',
		searchInputPlaceholder: 'Tidak dibatasi',
		 width: '100%'
	});
    $('#work_field').select2({
		placeholder: 'Bidang pekerjaan yang dikerjakan di lowongan ini',
		searchInputPlaceholder: 'Bidang pekerjaan yang dikerjakan di lowongan ini',
		 width: '100%'
	});
    $('#employment_status').select2({
		placeholder: 'Jenis pekerjaan di lowongan ini',
		searchInputPlaceholder: 'Jenis pekerjaan di lowongan ini',
		 width: '100%'
	});
    $('#applicant_gender').select2({
		placeholder: 'Lowongan ini dikhususkan untuk gender',
		searchInputPlaceholder: 'Lowongan ini dikhususkan untuk gender',
		 width: '100%'
	});
    $('#job_skill').select2({
		placeholder: 'Keahlian yang diperlukan di lowongan ini',
		searchInputPlaceholder: 'Keahlian yang diperlukan di lowongan ini',
		 width: '100%'
	});
    min_salary = new Cleave('#min_salary', {
        numeral: true,
        prefix: 'Rp ',
        delimiter: '.',
        numeralDecimalMark: ',',
    });
    max_salary = new Cleave('#max_salary', {
        numeral: true,
        prefix: 'Rp ',
        delimiter: '.',
        numeralDecimalMark: ',',
    });
    experience = new Cleave('#experience', {
        numeral: true,
        prefix: ' Tahun',
        tailPrefix: true,
        delimiter: '.',
        numeralDecimalMark: ',',
    });
});

$('#education').change(function (e) {
    if ($(this).val().length > 1 && $(this).val().find(element => element == 0) == 0) {
        $('#education').val(0).trigger('change');
    }
})

$(document).on('click', '.change_status', function () {
    var selector = $(this);
    $(this).toggleClass('on');
    update_status(selector)
    
});

$('.btn_save').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#min_salary').val(min_salary.getRawValue().replace('Rp ', ''));
    $('#max_salary').val(max_salary.getRawValue().replace('Rp ', ''));
    $('#experience').val(experience.getRawValue().replace(' Tahun', ''));
    var formData = new FormData($('.form_input')[0]);
    var url;
    var status;
    save_method = $(this).data('method');
    var job_desc = CKEDITOR.instances['job_desc'].getData();
    if (save_method === 'add') {
        url = 'save';
        status = "Ditambahkan";
        formData.append('job_desc', job_desc);
    } else {
        url = 'update';
        status = "Diubah";
        formData.append('id', $(this).data('id'));
        formData.append('job_desc', job_desc);
    }

    $.ajax({
        url: url_controller + url + '?token=' + _token_user,
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
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').addClass('d-block');
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').text(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})

$(document).on('click', '.btn_edit', function () {
    $('.modal-title').text('EDIT DATA');
    $(".form-group").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    id = $(this).data('id');
    id_use = id;
    save_method = 'edit';
    $.ajax({
        url: url_controller + 'get_data' + '?token=' + _token_user,
        type: "POST",
        dataType: "JSON",
        data: { 'id': id },
        success: function (data) {
            if (data.status) {
                $('[name="name"]').val(data.course.name);
                $('[name="description"]').val(data.course.description);
                $('[name="id_category_course"]').val(data.course.id_category_course);
                $('[name="skill"]').val(data.skill.id_skill);
                $('#modal_form').modal('show');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { }
    })
})


$('.btn_delete').click(function (e) {
    var id = $(this).data('id');
    swal({
        title: "Apakah anda yakin?",
        text: "data akan dihapus!",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya , Lanjutkan",
        cancelButtonText: "Batal",
        closeOnConfirm: true,
        closeOnCancel: true,
        dangerMode: true
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url_controller + 'delete' + '?token=' + _token_user,
                    type: "POST",
                    dataType: "JSON",
                    data: { 'id': id },
                    success: function (data) {
                        if (data.status) {
                            notif({
                                msg: "<b>Sukses : </b> Data Berhasil Dihapus",
                                type: "success"
                            })

                            location.href = url_controller;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                })
            }
        }
    )
})

function update_status(selector) {
    var id = selector.data('id');
    var field = selector.data('status');
    active_status = selector.hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id,'status':active_status,'field':field},
        success: function(data){
            if (data.status) {
                notif({
                    msg: "<b>Sukses :</b> Data berhasil diupdate",
                    type: "success"
                });
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
        }

    });//end ajax
}
