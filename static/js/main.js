function url_encode(str) {
	return encodeURIComponent(str).replace(/[.!~*'()]/g, function(c) {
		return '%' + c.charCodeAt(0).toString(16);
	});
}

function get_count(){
	return 'hide='+count+'&';
}

function get_search(){
	return 'search='+url_encode(search_query)+'&';
}

$(function(){

	const count = $('#count');
	count.change(function(){

		window.location.href = get_link_for_count()+'hide='+count.val();

	});

});