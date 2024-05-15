<!-- eslint-disable vue/multi-word-component-names -->
<script lang="ts" setup>
import type TodoEntry from '@/types/TodoEntry'
import ListElement from './ListElement.vue'
import AddToDoButton from './AddToDoButton.vue'
import { ref } from 'vue'
const props = defineProps<{
  initEntries: Array<TodoEntry>
}>()
const emit = defineEmits(['delete-todo-event'])
const todoEntries = ref<Array<TodoEntry>>([...props.initEntries])
const addTodoItem = (newTodoItem: TodoEntry) => {
  todoEntries.value = [...todoEntries.value, newTodoItem]
}
const deleteTodoItem = (toDoId: number) => {
  todoEntries.value = todoEntries.value.filter((item) => item.id !== toDoId)
}
</script>
<template>
  <h1>ToDo Liste!</h1>
  <ul>
    <li :key="item.id" v-for="item in todoEntries">
      <ListElement :todo-item="item" @delete-todo-event="deleteTodoItem(item.id)" />
    </li>
  </ul>
  <AddToDoButton @add-to-do-object="addTodoItem"></AddToDoButton>
</template>
<style></style>
