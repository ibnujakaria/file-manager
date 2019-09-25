import Vue from 'vue'
import App from './components/App'
import ModalWrapper from './components/ModalWrapper'
import store from './store/index'
import router from './router/routes'

var pickerInstance = 0
class FileManager {

  constructor (el, options) {
    this._defaultOptions = {
    }

    this.el = el
    this._options = { ...this._defaultOptions, options }
  }

  _buildVue ({ showInModal }) {
    let payload = {
      el: this.el,
      store,
      router
    }
    
    if (!showInModal) {
      payload.render = h => h(App)
    } else {
      
      // create new div in the very bottom of document
      let root = document.createElement('div')
      root.setAttribute('id', `file-manager-picker-${++pickerInstance}`)
      document.body.appendChild(root)
      
      payload.el = `#file-manager-picker-${pickerInstance}`
      payload.render = h => {
        let self = this // instance of file manager

        return h(ModalWrapper, {
          props: {
            id: `modal-file-manager-${pickerInstance}`
          },
          on: {
            'on-select-clicked' (files) {
              self._app.$emit('on-select-clicked', files)
            }
          }
        })
      }
    }

    this._app = new Vue(payload)
  }

  show () {
    this._buildVue({})
  }

  /**
   * Pick on file
   *
   * @returns string
   * @memberof FileManager
   */
  pickFile () {
    return new Promise((resolve, reject) => {
      this._buildVue({
        showInModal: true
      })
  
      // listen event ketika tombol select modal wrapper ditekan
      this._app.$on('on-select-clicked', files => {
        resolve(files ? (files.length ? files[0] : null) : null)
        // jangan lupa clear dulu this._app nya :)
        this._app = null
      })

    })
  }


  /**
   * Pick multiple file
   *
   * @returns array
   * @memberof FileManager
   */
  pickFiles () {
    return new Promise((resolve, reject) => {
      this._buildVue({
        showInModal: true
      })

      // listen event ketika tombol select modal wrapper ditekan
      this._app.$on('on-select-clicked', files => {
        resolve(files || [])
        // jangan lupa clear dulu this._app nya :)
        this._app = null
      })

    })
  }
}

window.FileManager = FileManager

export default FileManager
