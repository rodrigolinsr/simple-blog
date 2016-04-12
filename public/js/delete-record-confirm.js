$('a.delete-record').on('click', function(e) {
  var form = $(this).parent().next('form');
  e.preventDefault();
  $('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
    .one('click', '#do-delete', function (e) {
      form.trigger('submit');
    });
});
