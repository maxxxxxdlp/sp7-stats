$(function(){

	const file_picker_select = $('#show_data_for');
	if(file_picker_select.length!==0){
		file_picker_select.change(function(){

			const selected_file = file_picker_select.find("option:selected").attr('value');

			if(current_file !== selected_file){

				if(selected_file==='0')
					window.location.href = file_less_link;
				else
					window.location.href = file_less_link+'file='+selected_file;
			}

		});
	}


	if(typeof menu_button !== "undefined"){

		$('#menu a:nth-child('+menu_button+')').addClass('active disabled').removeAttr('href');

	}

});