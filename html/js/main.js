$(document).ready(function() {

/*
 * Javascript init bootstrap-datetimepickers
 * for User Input
 */


	$('#datetimestart').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		defaultDate: moment().subtract(1, 'hours'),
		useCurrent: false,
		minDate: '2017-07-17 00:00:00'
	});
	$('#datetimeend').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		defaultDate: moment(),
		useCurrent: false,
		maxDate: moment()
	});
	ajaxRequest();

	$("#datetimeend").on("dp.change", function (e) {
            $('#datetimestart').data("DateTimePicker").maxDate(e.date);
    });
	$("#datetimestart").on("dp.change", function (e) {
            $('#datetimeend').data("DateTimePicker").minDate(e.date);
    });

	$("#location, #parameter").change( function(e) {
		e.preventDefault();
		ajaxRequest();
	});
	$("#submitdate").on("click", function(e) {
		e.preventDefault();
		ajaxRequest();
	});

});

/*
 * Handle submit click for datatransfer
 * with AJAX and jQuery
 */
function ajaxRequest( ) {

	$( ".loading-overlay" ).show();
	$('#loading').show();
	$.ajax({
		url : "includes/ajax.php?action=dashboardform",
		type : "POST",
		data : $("#nodes").serialize(),
		dataType: "json",
		cache : false,
		success: function( data ) {
			console.log( data );
			drawChart( data.chart_data );
			currentGauge( data.current_data.current );
			tableMaxMin( data.maxmin_data );
			tableAvgDays( data.avg_data );
			$('#loading').hide();
			$( ".loading-overlay" ).hide();
		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nERROR: "+ err);
		}
	});
}
/*
 * function to draw a Chart with the selected
 * parameter, node, and timestep.
 * @param: data -- contains all JSONs from server
 */

function drawChart( chartdata ) {

	console.dir(chartdata);
	var labelArray 	= [];										//X-axis of chart  	[Time]
	var seriesArray = [];										//Y-axis of chart	[parameter]
	var parameter = $("#parameter").val();		//parameter of userinput
/*
 * get all x and Y values
 */

	labelArray  = chartdata.datetime;
	seriesArray = chartdata[parameter];

/*
 * creation and design of chart by using Chartist.js
 */
	$("#mychart").replaceWith('<canvas id="mychart" ></canvas>');
	var ctx = $("#mychart");
	var myChart = new Chart(ctx.empty(), {
		type: 'line',
		data: {
			labels: labelArray,
			datasets: [{
				label: parameter,
				data: seriesArray,
				borderColor: '#337ab7',
				borderWidth: 2
			}]
		},
		options: {
			responsive: true
			// scales: {
				// yAxes: [{
					// display: true,
					// ticks: {
						// beginAtZero: true
					// }
				// }]
			// }
		}
	});
}
/*
 * function to create Gauges of the
 * selected node.
 * @param: data -- contains all JSONs from server
 */

function currentGauge( currentdata ) {
  $('#jg1').empty();
  $('#jg2').empty();
  $('#jg3').empty();
  $('#jg4').empty();

  var parameters = [
    'Humidity',
    'Battery Status',
    'Pressure',
    'Temperature'
  ];
  if(!!currentdata.ID){
	  var gHumidity = new JustGage({
		id: "jg1",
		value: currentdata.humidity,
		min: 0,
		max: 100,
		title: parameters[0],
		label: " [%]"
	  });

	  var gCharge = new JustGage({
		id: "jg2",
		value: (currentdata.voltage/3.2)*100,
		min: 0,
		max: 100,
		title: parameters[1],
		label: " [%]"
	  });

	  var gPressure = new JustGage({
		id: "jg3",
		value: currentdata.pressure,
		min: 950,
		max: 1050,
		title: parameters[2],
		label: " [hPa]"
	  });

	  var gTemperature = new JustGage({
		id: "jg4",
		value: currentdata.temperature,
		min: -30,
		max: 70,
		title: parameters[3],
		label: " [C°]"
	  });
  }else{
	  window.alert("No current measures for this sensornode! Please check the connection");
  }
}
/*
 * function to create table of the
 * max and min values of selected node.
 * @param: data -- contains all JSONs from server
 */
function tableMaxMin( maxmindata ) {

	$('#table1').bootstrapTable('destroy');
	$('#table1').bootstrapTable({
		columns: [{
			field: 'param',
			title: 'Parameter'
		}, {
			field: 'max',
			title: 'Maximum'
		}, {
			field: 'max_date',
			title: 'Time'
		}, {
			field: 'min',
			title: 'Minimum'
		}, {
			field: 'min_date',
			title: 'Time'
		}],
		data: [{
			param: 'Temperature',
			max: maxmindata.max.temperature.temperature,
			max_date: maxmindata.max.temperature.tdate,
			min: maxmindata.min.temperature.temperature,
			min_date: maxmindata.min.temperature.tdate
		}, {
			param: 'Humidity',
			max: maxmindata.max.humidity.humidity,
			max_date: maxmindata.max.humidity.hdate,
			min: maxmindata.min.humidity.humidity,
			min_date: maxmindata.min.humidity.hdate
		}, {
			param: 'Pressure',
			max: maxmindata.max.pressure.pressure,
			max_date: maxmindata.max.pressure.pdate,
			min: maxmindata.min.pressure.pressure,
			min_date: maxmindata.min.pressure.pdate
		}]
	});
}
function tableAvgDays( avgdata ) {

	$('#table2').bootstrapTable('destroy');
	$('#table2').bootstrapTable({
		columns: [{
			field: 'param',
			title: 'Parameter'
		}, {
			field: 'today',
			title: 'Today'
		}, {
			field: 'yesterday',
			title: moment().subtract(1, 'days').format('dddd')
		}, {
			field: 'yyday',
			title:  moment().subtract(2, 'days').format('dddd')
		}, {
			field: 'yyyday',
			title:  moment().subtract(3, 'days').format('dddd')
		}],
		data: [{
			param: 'Temperature',
			today: avgdata.today.temperature,
			yesterday: avgdata.yday.temperature,
			yyday: avgdata.yyday.temperature,
			yyyday: avgdata.yyyday.temperature
		}, {
			param: 'Humidity',
			today: avgdata.today.humidity,
			yesterday: avgdata.yday.humidity,
			yyday:avgdata.yyday.humidity,
			yyyday: avgdata.yyyday.humidity
		}, {
			param: 'Pressure',
			today: avgdata.today.pressure,
			yesterday: avgdata.yday.pressure,
			yyday:avgdata.yyday.pressure,
			yyyday: avgdata.yyyday.pressure
		}]
	});

}
