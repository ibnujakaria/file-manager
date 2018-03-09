<div class="modal" tabindex="-1" role="dialog" id="modal-remove-file">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Remove</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this file or folder?</p>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" @click="remove()">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>