<script type="text/javascript">
  (() => {
    Vue.http.options.root = '{{route('ibnujakaria.file-manager.index')}}'
    let app = new Vue({
      el: '#file-manager-app',
      data: {
        path: '',
        directories: [],
        files: [],
        selectedFiles: [],
        form: {
          directory: {name: null}
        }
      },
      mounted () {
        console.log('mounted!')
        this.getAllFilesAndDirectory()
      },
      methods: {
        getAllFilesAndDirectory () {
          this.$http.get('list-all-files', {params: {path: this.path}}).then(response => {
            this.directories = response.body.directories
            this.files = response.body.files
          }, response => {
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
        selectFile (file) {
          console.log('selectFile: ' + file)
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
        openModal (id) {
          $('#' + id).modal('show')
        },
        closeModal (id) {
          $('#' + id).modal('hide')
        }
      }
    })
  })()
</script>