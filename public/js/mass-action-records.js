function massModerateComments(url, tokenField) {
  // Get the commentsIds
  var commentsIds = [];
  $("#table-records").find('input[type="checkbox"]').not('.check-all').each(function() {
    if($(this).get(0).checked) {
      commentsIds.push($(this).val());
    }
  });

  // Creating the form to be submitted
  var $form = $('<form />').attr('action', url)
               .attr('method', 'post');

  $form.append(
    $('<input />').attr('type', 'hidden')
                  .attr('name', '_token')
                  .attr('value', tokenField)
  );

  // Create the field to be append in the form
  $.each(commentsIds, function(idx, commentId) {
    $form.append(
      $('<input />').attr('type', 'hidden')
                    .attr('name', 'commentsIds[]')
                    .attr('value', commentId)
    );
  });

  $('body').append($form);
  $form.submit();
}
