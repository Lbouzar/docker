<!-- eslint-disable vue/no-mutating-props -->
<!-- eslint-disable vue/no-dupe-keys -->
<script lang="ts" setup>
import type TodoEntry from '@/types/TodoEntry'
import axios from 'axios'
const props = defineProps<{
  todoItem: TodoEntry
}>()
const emit = defineEmits(['delete-todo-event'])
const taskCompleted = async () => {
  const newCompletedStatus = !props.todoItem.completed;
  try {
    await axios.patch(`/api/todo-items/${props.todoItem.id}/toggle-completion`, {
      completed: newCompletedStatus
    });
    props.todoItem.completed = newCompletedStatus; // Update local state only after successful server update
  } catch (error) {
    console.error('Failed to update task completion:', error);
  }
}
</script>
<template>
  <div :class="{ completed: todoItem.completed }">
    <div class="container">
      <input type="checkbox" @click="taskCompleted()" />
      <div class="smallContainer">
        <p>{{ todoItem.title }}</p>
        <br />
        <p class="description">{{ todoItem.description }}</p>
     
      </div>
      <button @click="emit('delete-todo-event', todoItem.id)">
        <img src="../assets/delete.png" alt="supprimer" />
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
input {
  border: none;
}
.container {
  display: flex;
  flex-direction: row;
  gap: 2em;
}

.completed {
  background-color: #6d335c;
}
button {
  width: 3em;
  height: 3em;
  border: none;
  background-color: transparent;

  img {
    width: 70%;
    height: 70%;
  }
}
.smallContainer {
  display: flex;
  flex-direction: column;
}
.description {
  margin-top: -1em;
}
</style>
