var list_courses = $('#list-courses');
var list_batch_courses = $('#list-batch-courses');
$(document).ready(function () {

    $('#skill').select2({
		placeholder: 'Pilih skill',
		searchInputPlaceholder: 'Cari Skill',
		 width: '100%'
	});
    $('#category').select2({
		placeholder: 'Pilih kategori keahlian',
		searchInputPlaceholder: 'Cari kategori',
		 width: '100%'
	});
});
$('.btn-filter').click(function (e) { 
    e.preventDefault();
    var formData = new FormData($('#filter-courses')[0]);
    $.ajax({
        type: "POST",
        url: baseUrl + '/kursus-pelatihan-kerja',
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                list_courses.html(data.data);
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').addClass('d-block');
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').text(data.error_string[i]);
                }
            }
        }
    });
});
$('#open_course').change(function (e) { 
    e.preventDefault();
    var formData = new FormData($('#filter-batch-courses')[0]);
    $.ajax({
        type: "POST",
        url: baseUrl + '/pendaftaran-pelatihan',
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (data) {
            if (data.status) {
                list_batch_courses.html(data.data);
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass("is-invalid");
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').addClass('d-block');
                    $('[name="' + data.inputerror[i] + '"]').siblings(':last').text(data.error_string[i]);
                }
            }
        }
    });
});