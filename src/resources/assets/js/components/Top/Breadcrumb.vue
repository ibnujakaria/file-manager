<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <router-link to="/"><i class="fa fa-home"></i></router-link>
      </li>
      <li 
        class="breadcrumb-item" 
        :class="{ active: key === splittedPath.length - 1 }"
        v-for="(path, key) of splittedPath" 
        :key="key">
        <router-link :to="getLink(key)">{{ path }}</router-link>
      </li>
    </ol>
  </nav>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState([
      'path'
    ]),
    splittedPath () {
      let path = this.path
      if (path[0] === '/') {
        path = path.substr(1)
      }

      return path.split('/')
    }
  },
  methods: {
    getLink (key) {
      let paths = this.splittedPath
      let newPaths = []


      for (let i = 0; i <= key; i++) {
        newPaths.push(paths[i])
      }

      console.log('getLink', paths, key, newPaths.join('/'))
      return '/' + newPaths.join('/')
    }
  }
}
</script>