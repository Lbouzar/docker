<script setup lang="ts">
import List from './components/List.vue'
import type TodoEntry from '../src/types/TodoEntry'
import { ref } from 'vue'

const todoEntries = ref<Array<TodoEntry>>([
  {
    id: 1,
    title: 'aaaaaaaa',
    description: 'aaaaaaaaaaa',
    completed: false
  },
  {
    id: 2,
    title: 'aaaaaaaaaaaaaaaaaaaaaaaa',
    description: 'aaaaaaaaaaa',
    completed: false
  },
  {
    id: 3,
    title: 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
    description: 'aaaaaaaaaaa',
    completed: false
  }
])
</script>

<template>
  <div id="app">
    <List :init-entries="todoEntries" />
    <List :init-entries="[]" />
  </div>
</template>

<style scoped>
/* body */
#app {
  overflow: hidden;
  height: 100vh;
  width: 100vw;
  background: #4d244e;
  font-family: sans-serif;
  border-top: 5px solid #aa8e8d;
}
</style>
