<script>
	const chart_background_colors = JSON.parse('<?=json_encode(chart_background_colors)?>');
	const chart_border_colors = JSON.parse('<?=json_encode(chart_border_colors)?>');

	const default_options = {
		responsive: true,
			scales : {
			yAxes : [ {
				ticks : {
					beginAtZero : true,
				},
			} ],
		},
	};

	function create_chart(chart,label='',labels=[],data=[],options=[]){
		return new Chart( chart, {
			type : "bar",
			data : {
				labels : labels,
				datasets : [ {
					label : label,
					data : data,
					backgroundColor : chart_background_colors,
					borderColor : chart_border_colors,
					borderWidth : 1,
				} ],
			},
			options : Object.assign(default_options,options),
		} );
	}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>