$(function(){

	const backgroundColor = ["rgba(86,206,255,0.2)", "rgba(162,235,54,0.2)", "rgba(86,255,206,0.2)", "rgba(235,54,162,0.2)", "rgba(54,162,235,0.2)", "rgba(192,192,75,0.2)", "rgba(162,54,235,0.2)", "rgba(255,206,86,0.2)", "rgba(75,192,192,0.2)", "rgba(99,255,132,0.2)", "rgba(206,255,86,0.2)", "rgba(255,99,132,0.2)", "rgba(153,255,102,0.2)", "rgba(64,159,255,1", "rgba(235,162,54,0.2)", "rgba(64,255,159,0.2)", "rgba(99,132,255,0.2)", "rgba(153,102,255,0.2)", "rgba(192,192,75,0.2)", "rgba(192,75,192,0.2)", "rgba(255,132,99,0.2)", "rgba(255,86,206,0.2)", "rgba(255,102,153,0.2)", "rgba(132,99,255,0.2)", "rgba(159,64,255,0.2)", "rgba(255,64,159,0.2)", "rgba(102,255,153,0.2)", "rgba(54,235,162,0.2)", "rgba(255,153,102,0.2)", "rgba(75,192,192,0.2)", "rgba(255,159,64,0.2)", "rgba(159,255,64,0.2)", "rgba(192,75,192,0.2)", "rgba(132,255,99,0.2)", "rgba(102,153,255,0.2)", "rgba(206,86,255,0.2)"];
	const borderColor = ["rgba(86,206,255,1)", "rgba(162,235,54,1)", "rgba(86,255,206,1)", "rgba(235,54,162,1)", "rgba(54,162,235,1)", "rgba(192,192,75,1)", "rgba(162,54,235,1)", "rgba(255,206,86,1)", "rgba(75,192,192,1)", "rgba(99,255,132,1)", "rgba(206,255,86,1)", "rgba(255,99,132,1)", "rgba(153,255,102,1)", "rgba(64,159,255,1", "rgba(235,162,54,1)", "rgba(64,255,159,1)", "rgba(99,132,255,1)", "rgba(153,102,255,1)", "rgba(192,192,75,1)", "rgba(192,75,192,1)", "rgba(255,132,99,1)", "rgba(255,86,206,1)", "rgba(255,102,153,1)", "rgba(132,99,255,1)", "rgba(159,64,255,1)", "rgba(255,64,159,1)", "rgba(102,255,153,1)", "rgba(54,235,162,1)", "rgba(255,153,102,1)", "rgba(75,192,192,1)", "rgba(255,159,64,1)", "rgba(159,255,64,1)", "rgba(192,75,192,1)", "rgba(132,255,99,1)", "rgba(102,153,255,1)", "rgba(206,86,255,1)"];

	const year_select = $('#year_select');
	const month_select = $('#month_select');

	const year_keys = [];
	const year_values = [];
	const month_keys = [];
	const month_values = [];
	const day_keys = [];
	const day_values = [];

	const days_chart = document.getElementById( "days_chart" ).getContext( "2d" );
	const months_char = document.getElementById( "months_chart" ).getContext( "2d" );
	const years_chart = document.getElementById( "years_chart" ).getContext( "2d" );

	$.each(days,function(year,month){

		year_select.append('<option value="'+year+'">'+year+'</option>');

		$.each(month,function(month){

			month_select.append('<option value="'+month+'">'+month+'</option>');
			month_keys.push(month);

		});

	});

	$.each(years,function(year,count){

		year_keys.push(year);
		year_values.push(count);

	});

	new Chart( years_chart, {
		type : "bar",
		data : {
			labels : [year_keys],
			datasets : [ {
				label : "Years Chart",
				data : [year_values],
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

	year_select.change(function(){

		const selected_year = year_select.find('option:selected').val();

		$.each(month_keys,function(year,months){

			if(year===selected_year){

				month_keys.length = 0;
				month_values.length = 0;

				$.each(months,function(month,count){

					month_keys.push(month);
					month_values.push(count);

				});

				month_select.html('');

				$.each(month_keys,function(month){

					month_select.append('<option value="'+month+'">'+month+'</option>');

				});

				return false;
			}

		});

	});

	month_select.change(month_change_function);

	function month_change_function(){

		const selected_month = month_select.find('option:selected').val();

		$.each(day_keys,function(month,days){

			if(month===selected_month){

				day_keys.length = 0;
				day_values.length = 0;

				$.each(days,function(day,count){

					day_keys.push(day);
					day_values.push(count);

				});

				return false;
			}

		});

	}


});