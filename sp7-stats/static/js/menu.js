$(function () {
  if (typeof active_menu !== 'undefined') {
    const active_menu_button = $('#menu a:nth-child(' + active_menu + ')');
    active_menu_button.addClass('active disabled');
    active_menu_button.removeAttr('href');
  }
});
