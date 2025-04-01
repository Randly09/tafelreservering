<template>
    <div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white py-8">
      <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Table</h1>
        <form @submit.prevent="updateTable">
          <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" v-model="form.name" class="w-full p-2 border rounded text-black" />
          </div>
          <div class="mb-4">
            <label class="block mb-1">Capacity</label>
            <input type="number" v-model="form.capacity" class="w-full p-2 border rounded text-black" />
          </div>
          <div class="mb-4">
            <label class="block mb-1">Location</label>
            <select v-model="form.location" class="w-full p-2 border rounded text-black">
              <option value="Inside">Inside</option>
              <option value="Outside">Outside</option>
            </select>
          </div>
          <button
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
            Save Changes
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { usePage } from '@inertiajs/vue3'
  import axios from 'axios'
  
  const page = usePage()
const table = page.props.table

const form = ref({
  name: table.name,
  capacity: table.capacity,
  location: table.location,
})
  
  function updateTable() {
    axios.put(`/api/tables/${table.id}`, form.value)
      .then(() => {
        alert('Table updated successfully!')
        window.location.href = '/beheerder/tables'
      })
      .catch(error => {
        console.error('Error updating table:', error)
      })
  }
  </script>