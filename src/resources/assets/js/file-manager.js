import Vue from 'vue'
import App from './components/App'
import store from './store/index'
import router from './router/routes'


class FileManager {

  constructor (el, options) {
    this._defaultOptions = {
    }

    this.el = el
    this._options = { ...this._defaultOptions, options }
  }

  _buildVue () {
    this._app = new Vue({
      el: this.el,
      store,
      router,
      render: h => h(App)
    })

    console.log(this._app)
  }

  show () {
    this._buildVue()
  }
}

window.FileManager = FileManager

export default FileManager
