<template>
  <div>
    <div class="row">
      <div class="col-sm-8">
        <breadcrumb></breadcrumb>
      </div>
      <div class="col-sm-4">
        <controls
          @openModal="openModal"></controls>
      </div>
    </div>
    <div>
      <div class="row">
        <div :class="{'col-sm-8': showImage, 'col-sm-12': !showImage}">
          <table class="table table-hover">
            <thead class="thead-dark">
              <th>Name</th>
              <th>Last Modified</th>
              <th>Size</th>
            </thead>
            <tbody>
              <tr 
                v-for="(item, i) in directoriesAndFiles" 
                @click="selectItem(item)" 
                :class="isSelectedClasses(item)"
                :key="`${path}-${i}`">
                <td>
                  <i :class="getClassItem(item)" style="width: 20px"></i> {{item.name}}
                </td>
                <td>{{item.last_modified}}</td>
                <td>{{item.size || '-'}}</td>
              </tr>
              <tr v-if="!directoriesAndFiles.length && !loading.loadingDirectoriesAndFiles">
                <td colspan="3" class="text-center">
                  Tidak ada apa pun.
                </td>
              </tr>
              <tr v-else-if="loading.loadingDirectoriesAndFiles">
                <td colspan="3" class="text-center">
                  Loading...
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-sm-4" v-if="showImage">
          <table class="table">
            <thead class="thead-dark">
              <th>Detail</th>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input type="text" class="form-control" :value="latestSelectedItem.public_path">
                  <div style="margin-top: 20px">
                    <img :src="latestSelectedItem.public_path" width="50%">
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <modal-new-folder ref="modal-new-folder"></modal-new-folder>
    <modal-delete ref="modal-delete"></modal-delete>
  </div>
</template>

<script>
import Vue from 'vue'
import { mapState, mapActions } from 'vuex'
import Breadcrumb from './Top/Breadcrumb'
import Controls from './Top/Controls'
import ModalNewFolder from './Modals/NewFolder'
import ModalDelete from './Modals/Delete'

export default {
  computed: {
    ...mapState([
      'path',
      'directoriesAndFiles',
      'selectedItems',
      'loading'
    ]),
    latestSelectedItem () {
      if (this.selectedItems.length - 1) {
        return { path: null }
      }

      return this.selectedItems[this.selectedItems.length - 1]
    },
    showImage () {
      return this.latestSelectedItem.type === 'file' && this.selectedItems.length === 1
    }
  },
  mounted () {
    console.log('mounted!')
    let path = this.$route.path
    this.$store.commit('SET_PATH', path)
    this.$store.dispatch('getAllFilesAndDirectory')
  },
  methods: {
    ...mapActions([
      'openDirectory'
    ]),
    selectItem (item) {
      if (this.isSelected(item) && item.type === 'directory') {
        this.$router.push(`/${item.path}`)
      } else {
        this.$store.dispatch('selectItem', item)
      }
    },
    openModal (id) {
      this.$refs[id].show()
    },
    getClassItem (item) {
      let className = item.type === 'directory' ? 'fa-folder' : 'fa-file'
      let classes = {}

      classes.fa = true
      classes[className] = true

      return classes
    },
    isSelected (item) {
      return this.selectedItems.find(selected => selected.path === item.path)
    },
    isSelectedClasses (item) {
      return {
        'table-primary': this.isSelected(item)
      }
    }
  },
  watch: {
    '$route' () {
      console.log('route changed', this.$route.path)
      this.openDirectory(this.$route.path)
    }
  },
  components: { Breadcrumb, Controls, ModalNewFolder, ModalDelete }
}
</script>
