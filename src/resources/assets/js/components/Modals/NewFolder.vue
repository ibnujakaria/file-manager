<template>
  <div class="modal" id="modal-new-directory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-new-directory" @submit.prevent="submit">
            <div class="form-group">
              <label>Name</label>
              <input 
                ref="input"
                type="text" 
                class="form-control" 
                placeholder="Folder" 
                v-model="form.name" 
                :disabled="loading.creatingDirectory">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button 
            type="button" 
            class="btn btn-secondary" 
            data-dismiss="modal"
            :disabled="loading.creatingDirectory">
            Cancel
          </button>
          <button 
            type="submit" 
            form="form-new-directory" 
            class="btn btn-primary"
            :disabled="loading.creatingDirectory">
            {{ loading.creatingDirectory ? 'Creating..' : 'Create' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data: () => ({
    form: {
      name: null
    }
  }),
  computed: {
    ...mapState([
      'loading'
    ])
  },
  methods: {
    show () {
      window.$('#modal-new-directory').modal('show')
      setTimeout(() => {
        this.$refs.input.focus()
      }, 200)
    },
    hide () {
      window.$('#modal-new-directory').modal('hide')
    },
    async submit () {
      await this.$store.dispatch('newDirectory', this.form.name)
      this.form.name = null
      this.hide()
    }
  }
}
</script>