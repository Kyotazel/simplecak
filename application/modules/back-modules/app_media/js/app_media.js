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
    // var type = $('.container_list').data('type');
    load_image('');
    // id_group = '';
    dropzone_upload_image(dir_location);
});

function dropzone_upload_image(dir_location) {
    if ($('div').hasClass('dropzone_main')) {
        Dropzone.autoDiscover = false;
        upload_main = new Dropzone(".dropzone_main",{
            url:url_controller+'upload_image'+'/?token='+_token_user,
            maxFiles: 15,   
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
        
        // upload_main.on("removedfile",function(file){
        //     file_name = file.previewElement.id
        //     dir_location = $(document).find('.location_directory').data('location');
        //     $.ajax({
        //         type:"post",
        //         data:{'name':file_name,'location':dir_location},
        //         url:url_controller+'delete_file'+'/?token='+_token_user,
        //         cache:false,
        //         dataType: 'json',
        //         success: function(response){
        //             if(response.status){
        //                 const index = detail_image.indexOf(file_name);
        //                 if (index > -1) {
        //                     detail_image.splice(index, 1);
        //                 }
        //                 // load_image(dir_location);
        //             }
        //         },
        //         error: function(){
        //             console.log("Error");
        //         }
        //     });
        // });
    }
}


function load_image(dir) {
    showLoading();
    $.ajax({
        url: url_controller+'load_image'+'/?token='+_token_user,
        type: "POST",
        data:{'dir':dir},
        dataType :"JSON",
        success: function (data) {
            hideLoading();
            if(data.status){
                $('.html_image_countainer').html(data.html_respon);
                // directory = $(document).find('.location_directory').data('dir');
                dir_location = $(document).find('.location_directory').data('location');
                
                upload_main.destroy();
                dropzone_upload_image(dir_location);
            } 
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
}

$(document).on('click', '.item-folder', function () { 
    var location = $(this).data('location');
    load_image(location);
});


$(document).on('click', '.btn_upload_file', function () {
    dir_location = $(document).find('.current_folder').data('location');
    $('#modal_upload_file').modal('show');
});
$("#modal_upload_file").on("hidden.bs.modal", function () {
    // put your default event here
    dir_location = $(document).find('.current_folder').data('location');
    load_image(dir_location);
});

$(document).on('click', '.btn_upload_folder', function () {
    save_method = 'add';
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    $('.form-create-folder')[0].reset();
    $('#modal_create_folder').modal('show');
});

$(document).on('click', '.btn_create_folder', function (e) { 
    e.preventDefault();
    showLoading();
	$('.form-group').removeClass('has-danger');
    $('.help-block').empty();
    dir_location = $(document).find('.current_folder').data('location');
    // save_method = $(this).data('method');
	  //defined form
    var formData = new FormData($('.form-create-folder')[0]);
    formData.append('location', dir_location);
    var url;
    if(save_method=='add'){
        url = 'create_folder';
    }else{
        url = 'update_folder';
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
                load_image(dir_location);
                $('#modal_create_folder').modal('hide');
            } else{
                $(document).find('.text-folder').text(data.message);
            }
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            hideLoading();
        }
	});//end ajax
});

$(document).on('click', '.btn-delete-file', function () { 
    var type = $(this).data('type');
    var location = $(this).data('location');
    var message = '';
    if (type == 'file') {
        message = 'file ini akan dihapus permanen';
    } else {
        message = 'folder dan sub folder akan dihapus permanen';
    }

    swal({
        title: "Apakah anda yakin?",
        text: message,
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
                data:{'type':type,'location':location},
                success: function (data) {
                    dir_location = $(document).find('.current_folder').data('location');
                    load_image(dir_location);
                    notif_success('Berhasil dihapus');
                },
                error:function(jqXHR, textStatus, errorThrown)
                {
                }

            });//end ajax
        }
    });
});



//================== ckeditor =============================
$(document).on('click', '.item-image', function () { 
    var src = $(this).data('src');
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });
      // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
    let value = params.CKEditorFuncNum; // "some_value"
    
    if (parseInt(value) >= 1 ) {
        var fileUrl = src;
        window.opener.CKEDITOR.tools.callFunction(value, fileUrl);
        window.close();
    }
    
});