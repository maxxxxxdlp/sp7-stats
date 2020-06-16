$(function(){

	const count = $('#count');
	count.change(function(){

		window.location.href = link+'hide='+count.val();

	});

	const active_menu_button = $('#menu a:nth-child('+active_menu+')');
	active_menu_button.addClass('active disabled');
	active_menu_button.removeAttr('href');

});