$(function(){

	//Refresh Time warning message
	const last_refresh_alert = $('#last_refresh_alert');
	const current_time = Math.floor((new Date).getTime()/1000);
	const refresh_time = parseInt(last_refresh_alert.attr('data-refresh_date'));

	if(current_time - refresh_time > SHOW_DATA_OUT_OF_DATE_WARNING_AFTER){
		last_refresh_alert.addClass('alert-warning');
		last_refresh_alert.append(' You should probably refresh data now.');
	}
	else
		last_refresh_alert.addClass('alert-info');


	//Make correct button active
	if(typeof menu_button !== "undefined")
		$('#menu a:nth-child('+menu_button+')').addClass('active disabled').removeAttr('href');

});