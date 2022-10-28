function get_files(){
	return 'file_1='+first_day+'&file_2='+last_day+'&';
}

function get_view(){
	return 'view='+view+'&';
}

function get_link_for_count(){
	return link+get_search()+get_files()+get_view();
}

function get_link_for_files(){
	return link+get_search()+get_count()+get_view();
}

function get_link_for_view(){
	return link+get_files()+get_count()+get_search();
}

$(function(){

	//Redirect on file change
	const file_picker_select_1 = $('#show_data_begin');
	const file_picker_select_2 = $('#show_data_end');

	file_picker_select_1.change(onchange);
	file_picker_select_2.change(onchange);

	function onchange(){

		let selected_file_1 = file_picker_select_1.find("option:selected").attr('value');
		let selected_file_2 = file_picker_select_2.find("option:selected").attr('value');

		window.location.href = get_link_for_files()+'file_1='+selected_file_1+'&file_2='+selected_file_2;

	}

	//Change breadcrumb link
	const breadcrumb = $('#breadcrumb');
	const first_link = breadcrumb.find('li:first-child a');
	const last_link = breadcrumb.find('li:last-child a');
	first_link.click(function(){
		first_link.attr('href',get_link_for_view()+'view=0');
	});
	last_link.click(function(){
		last_link.attr('href',get_link_for_view()+'view=1');
	});

});