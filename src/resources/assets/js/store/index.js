import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'
import axios from 'axios'


// set axios root url
const baseURL = Cookies.get('file-manager-base-url')
const http = axios.create({
  baseURL
})

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    path: '',
    directoriesAndFiles: [],
    selectedItems: [],
    loading: {
      loadingDirectoriesAndFiles: false,
      uploadingFiles: false,
      creatingDirectory: false,
      renamingFileOrDirectory: false,
      deleting: false
    }
  },
  getters: {
    latestSelectedItem (state) {
      if (state.selectedItems.length - 1) {
        return { path: null }
      }

      return state.selectedItems[state.selectedItems.length - 1]
    }
  },
  mutations: {
    SET_PATH (state, path) {
      state.path = path
    },
    SET_DIRECTORIES_AND_FILES (state, directoriesAndFiles) {
      state.directoriesAndFiles = directoriesAndFiles
    },
    SET_SELECTED_ITEMS (state, selectedItems) {
      state.selectedItems = selectedItems
    },
    SET_LOADING (state, { key, value }) {
      state.loading[key] = value
    }
  },
  actions: {
    async getAllFilesAndDirectory ({ state, commit }) {
      commit('SET_LOADING', { key: 'loadingDirectoriesAndFiles', value: true })

      try {
        let { data } = await http.get('list-all-files', { params: { path: state.path } })
        commit('SET_DIRECTORIES_AND_FILES', data.directoriesAndFiles)
      } catch (error) {
        alert(error)
      } finally {
        commit('SET_LOADING', { key: 'loadingDirectoriesAndFiles', value: false })
      }
    },
    async openDirectory ({ dispatch, commit }, directory) {
      console.log('openDirectory: ' + directory)
      commit('SET_PATH', directory === '/' ? '' : directory)

      await dispatch('getAllFilesAndDirectory')
      commit('SET_SELECTED_ITEMS', [])
    },
    openDirectoryByIndex ({ state, commit, dispatch }, index) {
      console.log('openDirectoryByIndex: ' + index)

      let paths = state.path.split('/')
      let newPaths = []

      for (let i = 0; i <= index; i++) {
        newPaths.push(paths[i])
      }

      commit('SET_PATH', newPaths.join('/'))
      dispatch('getAllFilesAndDirectory')
    },
    selectItem ({ commit, getters, state, dispatch }, item) {
      console.log('selectItem() called with ' + JSON.stringify(item))
      console.log('selectedItems before is: ' + JSON.stringify(state.selectedItems))
      
      if (item.path !== getters.latestSelectedItem.path) {
        commit('SET_SELECTED_ITEMS', [item])
        console.log('select ' + item)
        return
      }

      if (item.type === 'directory') {
        console.log('open ' + item)
        dispatch('openDirectory', item.path)
      }
    },
    async newDirectory ({ state, dispatch, commit }, name) {
      name = state.path + '/' + name
      commit('SET_LOADING', { key: 'creatingDirectory', value: true })

      try {
        await http.post('add-directory', { name })
        await dispatch('getAllFilesAndDirectory')
      } catch (error) {
        throw error
      } finally {
        commit('SET_LOADING', { key: 'creatingDirectory', value: false })
      }
    },
    rename () {
      alert('Rename ' + JSON.stringify(this.selectedItems))
    },
    async uploadFiles ({ state, commit, dispatch }, files) {
      commit('SET_LOADING', { key: 'uploadingFiles', value: false })
      
      try {
        let payload = new FormData()
        payload.append('path', state.path)

        for (let file of files) {
          payload.append('files[]', file)
        }
        await http.post('upload-files', payload)
        dispatch('getAllFilesAndDirectory')
      } catch (error) {
        throw error
      } finally {
        commit('SET_LOADING', { key: 'uploadingFiles', value: false })
      }
    },
    async delete ({ state, commit, dispatch }) {
      let directoriesToRemove = []
      let filesToRemove = []

      for (let directory of state.selectedItems.filter(item => item.type === 'directory')) {
        directoriesToRemove.push(directory.path)
      }

      for (let file of state.selectedItems.filter(item => item.type === 'file')) {
        filesToRemove.push(file.path)
      }

      try {
        commit('SET_LOADING', { key: 'deleting', value: false })
        if (directoriesToRemove.length) {
          await http.delete('delete-directories', { params: { directories: directoriesToRemove } })
        }
  
        if (filesToRemove.length) {
          await http.delete('delete-files', { params: { files: filesToRemove } })
        }
  
        dispatch('getAllFilesAndDirectory')
      } catch (error) {
        throw error
      } finally {
        commit('SET_LOADING', { key: 'deleting', value: false })
      }
    },
  }
})

export default store