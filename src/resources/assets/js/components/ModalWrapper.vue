<template>
  <div>
    <div class="modal" :id="id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">File Manager</h5>
            <button type="button" class="close" @click="closeModalWithoudSelectingFiles">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <app></app>
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-primary"
              @click="select">
              Select
            </button>
          </div>
        </div>
      </div>
  </div>
  </div>
</template>

<script>
import App from './App'
import { mapState } from 'vuex'

export default {
  props: ['id'],
  computed: {
    ...mapState([
      'selectedItems'
    ])
  },
  mounted () {
    this.showModal()
  },
  methods: {
    select () {
      this.hideModal()
      this.$emit('on-select-clicked', [ ...this.selectedItems ])
    },
    closeModalWithoudSelectingFiles () {
      this.hideModal()
      this.$emit('on-select-clicked', [])
    },
    showModal () {
      window.$(`#${this.id}`).modal({
        backdrop: 'static'
      })
    },
    hideModal () {
      window.$(`#${this.id}`).modal('hide')
    }
  },
  components: { App }
}
</script>