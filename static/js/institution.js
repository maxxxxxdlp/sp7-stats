$(function(){

	const backgroundColor = ["rgba(86,206,255,0.2)", "rgba(162,235,54,0.2)", "rgba(86,255,206,0.2)", "rgba(235,54,162,0.2)", "rgba(54,162,235,0.2)", "rgba(192,192,75,0.2)", "rgba(162,54,235,0.2)", "rgba(255,206,86,0.2)", "rgba(75,192,192,0.2)", "rgba(99,255,132,0.2)", "rgba(206,255,86,0.2)", "rgba(255,99,132,0.2)", "rgba(153,255,102,0.2)", "rgba(64,159,255,0.2)", "rgba(235,162,54,0.2)", "rgba(64,255,159,0.2)", "rgba(99,132,255,0.2)", "rgba(153,102,255,0.2)", "rgba(192,192,75,0.2)", "rgba(192,75,192,0.2)", "rgba(255,132,99,0.2)", "rgba(255,86,206,0.2)", "rgba(255,102,153,0.2)", "rgba(132,99,255,0.2)", "rgba(159,64,255,0.2)", "rgba(255,64,159,0.2)", "rgba(102,255,153,0.2)", "rgba(54,235,162,0.2)", "rgba(255,153,102,0.2)", "rgba(75,192,192,0.2)", "rgba(255,159,64,0.2)", "rgba(159,255,64,0.2)", "rgba(192,75,192,0.2)", "rgba(132,255,99,0.2)", "rgba(102,153,255,0.2)", "rgba(206,86,255,0.2)"];
	const borderColor = ["rgba(86,206,255,1)", "rgba(162,235,54,1)", "rgba(86,255,206,1)", "rgba(235,54,162,1)", "rgba(54,162,235,1)", "rgba(192,192,75,1)", "rgba(162,54,235,1)", "rgba(255,206,86,1)", "rgba(75,192,192,1)", "rgba(99,255,132,1)", "rgba(206,255,86,1)", "rgba(255,99,132,1)", "rgba(153,255,102,1)", "rgba(64,159,255,1)", "rgba(235,162,54,1)", "rgba(64,255,159,1)", "rgba(99,132,255,1)", "rgba(153,102,255,1)", "rgba(192,192,75,1)", "rgba(192,75,192,1)", "rgba(255,132,99,1)", "rgba(255,86,206,1)", "rgba(255,102,153,1)", "rgba(132,99,255,1)", "rgba(159,64,255,1)", "rgba(255,64,159,1)", "rgba(102,255,153,1)", "rgba(54,235,162,1)", "rgba(255,153,102,1)", "rgba(75,192,192,1)", "rgba(255,159,64,1)", "rgba(159,255,64,1)", "rgba(192,75,192,1)", "rgba(132,255,99,1)", "rgba(102,153,255,1)", "rgba(206,86,255,1)"];

	const year_select = $('#year_select');
	const month_select = $('#month_select');

	const days_chart = document.getElementById( "days_chart" ).getContext( "2d" );
	const months_chart = document.getElementById( "months_chart" ).getContext( "2d" );

	const days_chart_object = new Chart( days_chart, {
		type : "bar",
		data : {
			labels : [],
			datasets : [ {
				label : "Sessions per day",
				data : [],
				backgroundColor : backgroundColor,
				borderColor : borderColor,
				borderWidth : 1,
			} ],
		},
		options : {
			scales : {
				yAxes : [ {
					ticks : {
						beginAtZero : true,
					},
				} ],
			},
		},
	} );

	const months_chart_object = new Chart( months_chart, {
		type : "bar",
		data : {
			labels : [],
			datasets : [ {
				label : "Sessions per month",
				data : [],
				backgroundColor : backgroundColor,
				borderColor : borderColor,
				borderWidth : 1,
			} ],
		},
		options : {
			scales : {
				yAxes : [ {
					ticks : {
						beginAtZero : true,
					},
				} ],
			},
		},
	} );

	year_select.change(year_change_function);

	function year_change_function(){

		const selected_year = year_select.find('option:selected').val();
		month_select.html('');

		$.each(months[selected_year][0],function(keys,months){
			month_select.append('<option value="'+months+'">'+months+'</option>');
		});

		month_change_function();

		months_chart_object.tooltip._chart.config.data.labels = months[selected_year][0];
		months_chart_object.tooltip._chart.config.data.datasets[0].data = months[selected_year][1];
		months_chart_object.update();

	}

	year_change_function();


	month_select.change(month_change_function);

	function month_change_function(){

		const selected_year = year_select.find('option:selected').val();
		const selected_month = month_select.find('option:selected').val();

		days_chart_object.tooltip._chart.config.data.labels = days[selected_year][selected_month][0];
		days_chart_object.tooltip._chart.config.data.datasets[0].data = days[selected_year][selected_month][1];
		days_chart_object.update();

	}


});