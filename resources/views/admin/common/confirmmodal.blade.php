<div id="confirm-delete" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Are you sure you want to delete this record?</p>
        <p class="text-danger"><strong>This action can't be undone!</strong></p>
        {!! $additionalMessage ?? "" !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="do-delete">Delete</button>
      </div>
    </div>
  </div>
</div>
