<template>
  <div>
    <div class="dropdown" style="display: inline-block;">
      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 47px">
        <i class="fa fa-plus"></i> New
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100%">
        <a class="dropdown-item" href="#" @click="openModal('modal-new-folder')"><i style="width: 20px" class="fa fa-folder"></i> Folder</a>
        <a class="dropdown-item" href="#" @click="browseFile()"><i style="width: 20px" class="fa fa-upload"></i> File Upload</a>
      </div>
    </div>
    <div class="btn-group" v-if="selectedItems.length">
      <button class="btn btn-dark" style="height: 47px" @click="rename()"><i class="fa fa-pencil"></i> Rename</button>
      <button class="btn btn-dark" @click="openModal('modal-delete')"><i class="fa fa-trash"></i> Delete</button>
    </div>

    <div>
      <input @change="uploadFile" ref="inputFile" type="file" name="upload" style="display: none;" multiple>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState([
      'selectedItems'
    ])
  },
  methods: {
    browseFile () {
      this.$refs.inputFile.click()
    },
    async uploadFile () {
      try {
        await this.$store.dispatch('uploadFiles', this.$refs.inputFile.files)
        this.$refs.inputFile.value = null
      } catch (error) {
        alert(error)
      }
    },
    openModal (id) {
      this.$emit('openModal', id)
    }
  }
}
</script>
