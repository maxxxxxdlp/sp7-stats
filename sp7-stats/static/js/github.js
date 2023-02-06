$(function () {
  //change the role of the 'Refresh Data' button
  const refresh_data = $('#refresh');
  refresh_data
    .attr('href', link + repository + '&refresh_data=true')
    .removeAttr('target');

  //redirect on repository change
  const repository_select = $('#repository');
  repository_select.change(function () {
    const selected_repository = repository_select.find('option:selected').val();
    window.location.href = link + selected_repository;
  });
});
