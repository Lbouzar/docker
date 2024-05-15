<script setup lang="ts">
import { v4 as uuidv4 } from 'uuid'
import axios from 'axios'
const title = defineModel()
//const newToDoObject = defineModel()
const emit = defineEmits(['add-to-do-object'])
const addToDo = async (event: Event) => {
  event.preventDefault()
  const newToDoObject = {
    //id: uuidv4(),
    title: title.value,
    completed: false
  }
  emit('add-to-do-object', newToDoObject)
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/todo-items/', newToDoObject);
    console.log('Response:', response.data);
  } catch (error) {
    console.error('Error posting data:', error);
  }
  title.value = ''
}
</script>
<template>
  <div>
    <form @submit="addToDo">
      <input type="text" v-model="title" name="title" />
      <button type="submit">Submit</button>
    </form>
  </div>
</template>
