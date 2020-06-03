
$(function(){

	const file_picker_select = $('#show_data_for');

	file_picker_select.change(function(){

		const selected_file = file_picker_select.find("option:selected").attr('name');

		if(current_file !== selected_file){

			if(selected_file==='0')
				window.location.href = link;
			else
				window.location.href = link+'?file='+selected_file;
		}

	});

});