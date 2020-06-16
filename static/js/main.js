$(function(){

	//Redirect on file change
	const file_picker_select_1 = $('#show_data_begin');
	const file_picker_select_2 = $('#show_data_end');

	file_picker_select_1.change(onchange);
	file_picker_select_2.change(onchange);

	function onchange(){

		let selected_file_1 = file_picker_select_1.find("option:selected").attr('value');
		let selected_file_2 = file_picker_select_2.find("option:selected").attr('value');

		window.location.href = link+'file_1='+selected_file_1+'&file_2='+selected_file_2;

	}


	//Show institution/discipline/collection count
	const stats = $('#stats');
	stats[0].innerHTML += discipline_count + ' disciplines<br>'+
		collection_count + ' collections';

});