$(function(){

	const count = $('#count');
	count.change(function(){

		window.location.href = link+'?hide='+count.val();

	})

	const stats = $('#stats');
	stats.append(disciplines_count+` disciplines<br>` +
		collections_count+` collections<br>` +
		reports_count+` reports`);

});