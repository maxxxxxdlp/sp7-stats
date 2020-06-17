$(function(){

	const count = $('#count');
	count.change(function(){

		window.location.href = link+'hide='+count.val();

	});

});