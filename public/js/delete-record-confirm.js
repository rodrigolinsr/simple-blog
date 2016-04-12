$('a.delete-record').on('click', function(e) {
  var form = $(this).parent().next('form');
  e.preventDefault();
  $('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
    .one('click', '#do-delete', function (e) {
      form.trigger('submit');
    });
});

$('input[type="checkbox"].check-all').click(function() {
  var allChecked = $(this).get(0).checked;

  $(this).closest('table').find('input[type="checkbox"]').not('.check-all').each(function() {
    $(this).get(0).checked = allChecked;
  });
});
