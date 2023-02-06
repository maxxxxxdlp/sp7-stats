function update_stats(
  institutions_count = null,
  disciplines_count = null,
  collections_count = null,
  reports_count = null
) {
  if (institutions_count == null)
    [institutions_count, disciplines_count, collections_count, reports_count] =
      fetch_stats();

  const stats = $('#stats');
  stats.html(
    institutions_count +
      ` institutions<br>` +
      disciplines_count +
      ` disciplines<br>` +
      collections_count +
      ` collections<br>` +
      reports_count +
      ` captures`
  );
}

function fetch_stats() {
  let institutions_count = 0;
  let disciplines_count = 0;
  let collections_count = 0;
  let reports_count = 0;

  if (search_mode === 'table') {
    const institutions = $('tbody:not([style="display: none;"])');
    institutions_count = institutions.length;

    const disciplines = institutions.find('.discipline');
    disciplines_count = disciplines.length;

    const collections = institutions.find('[data-reports_count]');
    collections_count = collections.length;

    $.each(collections, function (key, element) {
      const el = $(element);

      reports_count += parseInt(el.attr('data-reports_count'));
    });
  } else {
    const institutions = $(
      'ol:not(.breadcrumb) > li:not([style="display: none;"])'
    );
    institutions_count = institutions.length;

    const disciplines = institutions.find('> ul > li');
    disciplines_count = disciplines.length;

    const collections = disciplines.find('[data-reports_count]');
    collections_count = collections.length;

    $.each(collections, function (key, element) {
      const el = $(element);

      reports_count += parseInt(el.attr('data-reports_count'));
    });
  }

  return [
    institutions_count,
    disciplines_count,
    collections_count,
    reports_count,
  ];
}

$(function () {
  update_stats(
    institution_count,
    discipline_count,
    collection_count,
    report_count
  );
});
