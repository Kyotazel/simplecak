var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var telp;

$(document).ready(function () {
    $('#sector').select2({
		placeholder: 'Sektor perusahaan',
		searchInputPlaceholder: 'Sektor perusahaan',
		 width: '100%'
	});
    telp = new Cleave('#phone', {
        phone: true,
        phoneRegionCode: 'ID',
        delimiter: '-',
    });
});

Dropzone.options.uploadForms = { // The camelized version of the ID of the form element

    // The configuration we've talked about above
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 100,
  
    // The setting up of the dropzone
    init: function() {
      var myDropzone = this;
  
      // First change the button to actually tell Dropzone to process the queue.
      this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
      });
  
      // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
      // of the sending event because uploadMultiple is set to true.
      this.on("sendingmultiple", function() {
        // Gets triggered when the form is actually being sent.
        // Hide the success button or the complete form.
      });
      this.on("successmultiple", function(files, response) {
        // Gets triggered when the files have successfully been sent.
        // Redirect user or notify of success.
      });
      this.on("errormultiple", function(files, response) {
        // Gets triggered when there was an error sending the files.
        // Maybe show form again, and notify user of error
      });
    }
   
  }
  $('.btn_update').click(function (e) {
    e.preventDefault();
    $(".form-control").removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#phone').val(telp.getRawValue());
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
        formData.append('description', description);
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
                telp = new Cleave('#phone', {
                    phone: true,
                    phoneRegionCode: 'ID',
                    delimiter: '-',
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.btn_save_group').button('reset');
        }
    })
})
