<script type="text/javascript">
  (() => {
    Vue.http.options.root = '{{route('ibnujakaria.file-manager.index')}}'
    let app = new Vue({
      el: '#file-manager-app',
      data: {
        path: '',
        directoriesAndFiles: [],
        selectedItems: [],
        loading: false,
        form: {
          directory: {name: null},
          upload: null
        }
      },
      mounted () {
        console.log('mounted!')
        this.getAllFilesAndDirectory()
      },
      computed: {
        latestSelectedItem () {
          if (this.selectedItems.length - 1) {
            return {path: null}
          }

          return this.selectedItems[this.selectedItems.length - 1]
        }
      },
      methods: {
        getAllFilesAndDirectory () {
          this.loadingStart()
          this.directoriesAndFiles = []
          this.$http.get('list-all-files', {params: {path: this.path}}).then(response => {
            this.directoriesAndFiles = response.body.directoriesAndFiles
            this.loadingStop()
          }, response => {
            this.loadingStop()
            alert('Error occured :(')
          })
        },
        openDirectory (directory) {
          console.log('openDirectory: ' + directory)
          this.path = directory

          if (this.path === '/') {
            this.path = ''
          }

          this.getAllFilesAndDirectory()
          this.selectedItems = []
        },
        openDirectoryByIndex (index) {
          console.log('openDirectoryByIndex: ' + index)

          let paths = this.path.split('/')
          let newPaths = []

          for (let i = 0; i <= index; i++) {
            newPaths.push(paths[i])
          }

          this.path = newPaths.join('/')

          console.log('new path: ' + this.path)

          this.getAllFilesAndDirectory()
        },
        selectItem (item) {
          console.log('selectItem() called with ' + JSON.stringify(item))
          console.log('selectedItems before is: ' + JSON.stringify(this.selectedItems))
          if (item.path !== this.latestSelectedItem.path) {
            this.selectedItems = []
            this.selectedItems.push(item)
            console.log('select ' + item)
            return
          }

          if (item.type === 'directory') {
            console.log('open ' + item)
            this.openDirectory(item.path)
          }
        },
        newDirectory () {
          let name = this.path + '/' + this.form.directory.name
          this.$http.post('add-directory', {name}).then(response => {
            this.form.directory.name = null
            this.closeModal('modal-new-folder')
            this.getAllFilesAndDirectory()
          }, response => {
            alert('Error occured :(')
          })
        },
        rename () {
          alert('Rename ' + JSON.stringify(this.selectedItems))
        },
        remove () {
          let directoriesToRemove = []
          let filesToRemove = []

          for (let directory of this.selectedItems.filter(item => item.type === 'directory')) {
            directoriesToRemove.push(directory.path)
          }

          for (let file of this.selectedItems.filter(item => item.type === 'file')) {
            filesToRemove.push(file.path)
          }

          this.$http.delete('delete-directories', {params: {directories: directoriesToRemove}}).then(response => {
            this.$http.delete('delete-files', {params: {files: filesToRemove}}).then(response => {
              this.getAllFilesAndDirectory()
              this.closeModal('modal-remove-file')
            }, response => {
              alert('error occured :(')
              this.closeModal('modal-remove-file')
            })
          }, response => {
            alert('error occured :(')
            this.closeModal('modal-remove-file')
          })
        },
        browseFile () {
          $('#input-file').click()
        },
        uploadFile () {
          let payload = new FormData()
          payload.append('files[]', document.getElementById('input-file').files[0])
          payload.append('path', this.path)

          this.loadingStart()
          this.$http.post('upload-files', payload).then(response => {
            console.log(response.body)
            this.getAllFilesAndDirectory()
          }, response => {
            alert('error')
            this.loadingStop()
          })
        },
        openModal (id) {
          $('#' + id).modal('show')
        },
        closeModal (id) {
          $('#' + id).modal('hide')
        },
        getClassItem (item) {
          let className = item.type === 'directory' ? 'fa-folder' : 'fa-file'
          let classes = {}

          classes.fa = true
          classes[className] = true

          return classes
        },
        isSelected (item) {
          return {
            'table-primary': this.selectedItems.find(selected => selected.path === item.path)
          }
        },
        loadingStart () {
          this.loading = true
          this.directoriesAndFiles = []
        },
        loadingStop () {
          this.loading = false
        }
      }
    })
  })()
</script>