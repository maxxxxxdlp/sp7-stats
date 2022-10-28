$(function(){

	const search = $('#search');
	const search_field = search.find('input');
	let targets = null;

	if(search_mode==='table')
		targets = $('tbody');
	else
		targets = $('ol:not(.breadcrumb) > li');

	search.bind('input',filter);

	function filter(){

		search_query = search_field.val();

		if(search_query==='')
			targets.show();
		else {

			const regex = new RegExp(search_query,"i");

			$.each(targets,function(key,el){

				el = $(el);

				const text = el.text();

				if(text.match(regex)!==null)
					el.show();
				else
					el.hide();

			});
		}

		if(typeof search_callback === "function")
			search_callback();

	}

	filter();

});