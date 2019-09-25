<template>
  <div class="modal" id="modal-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this?
        </div>
        <div class="modal-footer">
          <button 
            type="button" 
            class="btn btn-secondary" 
            data-dismiss="modal"
            :disabled="loading.deleting">
            Cancel
          </button>
          <button
            @click="remove"
            class="btn btn-primary"
            :disabled="loading.deleting">
            {{ loading.deleting ? 'Deleting..' : 'Delete' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState([
      'loading'
    ])
  },
  methods: {
    show () {
      window.$('#modal-delete').modal('show')
    },
    hide () {
      window.$('#modal-delete').modal('hide')
    },
    async remove () {
      try {
        await this.$store.dispatch('delete')
      } catch (error) {
        alert(error)
      } finally {
        this.hide()
      }
    }
  }
}
</script>