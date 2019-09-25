<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)" @click="openDirectory('/')"><i class="fa fa-home"></i></a>
      </li>
      <li class="breadcrumb-item" v-for="(p, key) of path.split('/')" :key="key">
        <a href="javascript:void(0)" @click="openDirectoryByIndex(key)">{{ p }}</a>
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
    ])
  },
  methods: {
    ...mapActions([
      'openDirectory',
      'openDirectoryByIndex'
    ])
  }
}
</script>