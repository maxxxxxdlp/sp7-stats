function update_stats(domains_count=null,
                      institutions_count=null,
                      disciplines_count = null,
                      collections_count = null,
                      reports_count = null){

	if(domains_count==null)
		[domains_count,institutions_count,disciplines_count,collections_count,reports_count] = fetch_stats();

	const stats = $('#stats');
	stats.html(domains_count+` domains<br>` +
		institutions_count+` institutions<br>` +
		disciplines_count+` disciplines<br>` +
		collections_count+` collections<br>` +
		reports_count+` reports`);

}

function fetch_stats(){

	let domains_count;
	let institutions_count;
	let disciplines_count;
	let collections_count;
	let reports_count = 0;

	if(search_mode === 'table'){

		const domains = $('tbody:not([style="display: none;"])');
		domains_count = domains.length;

		const institutions = domains.find('.institution');
		institutions_count = institutions.length;

		const disciplines = domains.find('.discipline');
		disciplines_count = disciplines.length;

		const collections = domains.find('[data-reports_count]');
		collections_count = collections.length;

		$.each(collections,function(key,element){

			const el = $(element);
			reports_count += parseInt(el.attr('data-reports_count'));

		});

	}
	else {

		const domains = $('ol:not(.breadcrumb) > li:not([style="display: none;"])');
		domains_count = domains.length;

		const institutions = domains.find('> ul > li');
		institutions_count = institutions.length;

		const disciplines = institutions.find('> ul > li');
		disciplines_count = disciplines.length;

		const collections = disciplines.find('[data-reports_count]');
		collections_count = collections.length;

		$.each(collections,function(key,element){

			const el = $(element);
			reports_count += parseInt(el.attr('data-reports_count'));

		});

	}

	return [domains_count,institutions_count,disciplines_count,collections_count,reports_count];

}

$(function(){

	update_stats(domain_count, institution_count,discipline_count,collection_count,report_count);

});