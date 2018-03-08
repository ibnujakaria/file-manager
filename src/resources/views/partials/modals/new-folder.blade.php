<div class="modal" tabindex="-1" role="dialog" id="modal-new-folder">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form @submit.prevent="newDirectory()">
          <div class="form-group">
            <label>Name</label>
            <input v-model="form.directory.name" class="form-control" placeholder="Folder name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" @click="newDirectory">Create</button>
        </div>
      </div>
    </div>
  </div>
</div>