var url_controller = baseUrl + '/' + prefix_folder_admin + '/' + _controller + '/';
var save_method;
var id_use = 0;
var table;

$(document).ready(function () {
    $('.chosen').chosen();
   // show_chart_resume_invoice();
    show_resume_invoice();
    show_resume_cost();

});

$(document).on('click', '#btn_search_chart_resume_invoice', function (e) { 
    e.preventDefault();
    show_resume_invoice();
});

function show_resume_invoice() {
    var formData = new FormData($('.form_resume_bs')[0]);
    // showLoading();
    $('#container_bar_invoice').html(`
        <div class="text-center" style="padding:30px 0px;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `);

    $.ajax({
        url: url_controller+'show_resume_invoice'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType: "JSON",
        success: function (data) {

            $('#container_bar_invoice').html('');
            console.log(data);
            $('.text-invoice-freight').text('Rp.'+money_function(data.resume.freight.toString()));
            $('.text-invoice-lc').text('Rp.'+money_function(data.resume.lc.toString()));
            $('.text-invoice-thc').text('Rp.'+money_function(data.resume.thc.toString()));
            $('.text-invoice-activity').text('Rp.' + money_function(data.resume.activity.toString()));
            
            console.log(data.data_chart);

            show_chart_resume_invoice('#container_bar_invoice',data.label,data.data_chart);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('#container_bar_invoice').html('');
        }
    });//end ajax
}

function show_chart_resume_invoice(container,label,data_chart) {
    /* Apexcharts (#bar) */
	var optionsBar = {
        chart: {
          height: 249,
          type: 'bar',
          toolbar: {
             show: false,
          },
          fontFamily: 'Nunito, sans-serif',
          // dropShadow: {
          //   enabled: true,
          //   top: 1,
          //   left: 1,
          //   blur: 2,
          //   opacity: 0.2,
          // }
        },
       colors: ["#0162e8", '#fbbc0b','#ee335e' ,'#22c03c'],
       plotOptions: {
                    bar: {
                    dataLabels: {
                        enabled: false
                    },
                        columnWidth: '42%',
                        endingShape: 'rounded',
                    }
                },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            endingShape: 'rounded',
            colors: ['transparent'],
        },
        responsive: [{
            breakpoint: 576,
            options: {
                    stroke: {
                    show: true,
                    width: 1,
                    endingShape: 'rounded',
                    colors: ['transparent'],
                },
            },
        }],
        series: data_chart,
        xaxis: {
            categories: label,
        },
        fill: {
            opacity: 0.8
        },
        legend: {
            show: false,
            floating: true,
            position: 'top',
            horizontalAlign: 'center',
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "Rp. " + money_function(val.toString()) 
                }
            }
        }
    }
    new ApexCharts(document.querySelector(container), optionsBar).render();
      /* Apexcharts (#bar) closed */
}

$(document).on('click', '.btn_search_cost', function (e) { 
    e.preventDefault();
    show_resume_cost();
});

function show_resume_cost() {
    var formData = new FormData($('.form_search_cost')[0]);
    // showLoading();
    $('.container_line_cost').html(`
        <div class="text-center" style="padding:30px 0px;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `);

    $.ajax({
        url: url_controller+'show_resume_cost'+'/?token='+_token_user,
        type: "POST",
        data: formData,
        contentType: false,
        processData : false,
        dataType: "JSON",
        success: function (data) {
            $('.container_line_cost').html('');
            $('.container_line_cost').append('<canvas id="line_cost"></canvas>');
            console.log(data.data_chart);
            show_chart_resume_cost('#line_cost',data.label,data.data_chart);
        },
        error:function(jqXHR, textStatus, errorThrown)
        {
            $('.container_line_cost').html('');
        }
    });//end ajax
}


function show_chart_resume_cost(container,label,data_chart) {
    var ctx8 = $(document).find(container);
	new Chart(ctx8, {
		type: 'line',
		data: {
			labels: label,
            datasets: [
                {
                    data: data_chart,
                    borderColor: '#f7557a',
                    borderWidth: 1,
                    fill: false
                }
            ]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
				labels: {
					display: false
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 10,
						// max: 80,
						fontColor: "rgba(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}],
				xAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 11,
						fontColor: "rgba(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}]
			}
		}
	});
}




$(document).on('keyup', '.rupiah', function () {
    var new_val = money_function($(this).val());
    $(this).val(new_val);
});

function clear_dot_value(value) {
    var array_value = value.split('.');
    var count_array = array_value.length;
    payment_value = value;
    for (var i = 0; i < count_array; i++) {
        payment_value = payment_value.replace('.', '');
    };
    return payment_value;
}

function money_function(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}