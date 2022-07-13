var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

var detail_image = [];
var image_upload = '';
// var directory = '';
var dir_location = '';
var upload_main;


Dropzone.autoDiscover = false;
$(document).ready(function () {
    
    table = $('#table_data').DataTable({
        "ajax": {
            "url": url_controller+"list_data"+'/?token='+_token_user,
            "type": "POST",
        },
        "columns": [
            { "width": "10%" },
            { "width": "30%" },
            { "width": "45%" },
            { "width": "15%" }
        ]
    });



    // dropzone_upload_image(dir_location);
    if ($('div').hasClass('dropzone_main')) {
        Dropzone.autoDiscover = false;
        upload_main = new Dropzone(".dropzone_main",{
            url:url_controller+'upload_image'+'/?token='+_token_user,
            maxFiles: 1,   
            method: "post",
            params: {
                'dir': dir_location
            },
            acceptedFiles:"image/*",
            paramName:"upload_file",
            dictInvalidFileType:"Type file ini tidak dizinkan",
            addRemoveLinks:true
        });

        upload_main.on('success', function(file,response) {
            // Look at the output in you browser console, if there is something interesting
            obj = JSON.parse(response);
            detail_image.push(obj.file_name);
            file.previewElement.id = obj.file_name;
            // load_image(dir_location);
        });
        
        upload_main.on("removedfile",function(file){
            file_name = file.previewElement.id
            dir_location = $(document).find('.location_directory').data('location');
            $.ajax({
                type:"post",
                data:{'name':file_name,'location':dir_location},
                url:url_controller+'delete_file'+'/?token='+_token_user,
                cache:false,
                dataType: 'json',
                success: function(response){
                    if(response.status){
                        const index = detail_image.indexOf(file_name);
                        if (index > -1) {
                            detail_image.splice(index, 1);
                        }
                        // load_image(dir_location);
                    }
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
    }

});

function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}


$('.btn_add').click(function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
 	$('.help-block').empty();
 	$('#form-data')[0].reset();
	$('.modal-title').text('TAMBAH DATA');
    $('#modal_form').modal('show');
});

function load_data() {
    showLoading();
    $.ajax({
        url: url_controller+'load_data/?token='+_token_user,
        type: "POST",
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $('.html_respon').html(data.html_respon);
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}


$('.btn_save').click(function (e) {
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    save_method = $(this).data('method');    
    // save_method = $(this).data('method');
	  //defined form
    var content  =  CKEDITOR.instances['content_profile'].getData();
    var formData = new FormData($('#form-data')[0]);
    var url;
    formData.append('image', detail_image);
    formData.append('content', content);

    if(save_method=='add'){
        url = 'save';
    } else {
        id_use = $(this).data('id');
        url = 'update';
        formData.append('id', id_use);
    }
    $.ajax({
        url: url_controller+url+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                notif({
                    msg: "<b>Sukses :</b> Data berhasil disimpan",
                    type: "success"
                });
                location.href = data.redirect;
            } else{
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('.notif_'+data.inputerror[i]).parent().addClass('has-danger');
                    $('.notif_'+data.inputerror[i]).text(data.error_string[i]);
                }
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});

$(document).on('click', '.btn_edit', function () {
    showLoading();
    $('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('#form-data')[0].reset();
    id = $(this).data('id');
    save_method = 'update';
    $.ajax({
        url: url_controller+'get_data'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id},
        success: function (data) {
            hideLoading();
            console.log(data);
            id_use = data.id;
            $('[name="name"]').val(data.name);
            $('[name="description"]').val(data.description);
            $('[name="link"]').val(data.link);
            $('#modal_form').modal('show');
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }

    });//end ajax

});


$(document).on('click', '.btn_delete', function () {
    id = $(this).data('id');
    var redirect = $(this).data('redirect');
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
                url: url_controller+'delete_data'+'/?token='+_token_user,
                type: "POST",
                dataType: "JSON",
                data:{'id':id,'status_group':true},
                success: function(data){
                    if (data.status) {
                        notif({
                            msg: "<b>Sukses :</b> Data berhasil dihapus",
                            type: "success"
                        });

                        if (redirect == 1) {
                            location.href = url_controller;
                        } else {
                            reload_table();
                        }
                    } 
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }

            });//end ajax
        }
    });
    
});

$(document).on('click', '.change_status', function () {
    var selector = $(this);
    $(this).toggleClass('on');
    var id = selector.data('id');
    active_status = selector.hasClass('on') ? 1 : 0;
    $.ajax({
        url: url_controller+'update_status'+'/?token='+_token_user,
        type: "POST",
        dataType: "JSON",
        data:{'id':id,'status':active_status},
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
});
