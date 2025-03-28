<template>
    <!-- Full-screen dark gradient background -->
    <div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white flex flex-col">
      <div class="flex flex-col items-center justify-center pt-20 pb-20">
        
        <!-- Company Logo -->
        <div class="mb-8">
          <!-- Update src to your actual logo path in /public/images/ -->
          <img src="/images/logo.png" alt="Restaurant Logo" class="w-70 h-40 mx-auto" />
        </div>
  
        <!-- Main Card Container -->
        <div class="w-full max-w-2xl bg-blue-900/80 rounded-xl shadow-xl px-8 py-10 mx-4">
          <h1 class="text-3xl font-bold mb-6 text-center">Available Tables</h1>
  
          <!-- Filter Form -->
          <form @submit.prevent="fetchTables" class="mb-6">
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
              <!-- Date Picker -->
              <input
                type="date"
                v-model="date"
                :min="minDate"
                class="p-2 border border-gray-300 rounded w-full sm:w-auto text-gray-800"
              />
  
              <!-- Time Selection (15-min increments) -->
              <select
                v-model="time"
                class="p-2 border border-gray-300 rounded w-full sm:w-auto text-gray-800"
              >
                <option value="" disabled>Select time</option>
                <option v-for="option in timeOptions" :key="option" :value="option">
                  {{ option }}
                </option>
              </select>
  
              <!-- Submit Button -->
              <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
              >
                Check Availability
              </button>
            </div>
          </form>
  
          <!-- Loading & Error Messages -->
          <div v-if="loading" class="mb-4 text-gray-100">Loading...</div>
          <div v-if="error" class="mb-4 text-red-300">{{ error }}</div>
  
          <!-- Display Available Tables -->
          <div v-if="tables.length">
            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
              <div
                v-for="table in tables"
                :key="table.id"
                class="p-4 border border-gray-200 rounded bg-white text-gray-800"
              >
                <h2 class="text-xl font-semibold mb-1">{{ table.name }}</h2>
                <p class="mb-1">Capacity: {{ table.capacity }}</p>
                <p class="mb-4">Location: {{ table.location }}</p>
                <!-- Book Table Button -->
                <Link
                :href="`/book-table/${table.id}?date=${date}&time=${time}`"
                  class="block text-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                >
                  Book Table
                </Link>
              </div>
            </div>
          </div>
          <div v-else-if="!loading" class="text-gray-100">
            No available tables found.
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { Link } from '@inertiajs/vue3';
  
  const date = ref('');
  const time = ref('');
  const tables = ref([]);
  const loading = ref(false);
  const error = ref('');
  

  const minDate = new Date().toISOString().split('T')[0];
  

  const timeOptions = [];
  const startHour = 17;
  const endHour = 20;
  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minutes = 0; minutes < 60; minutes += 15) {
      const h = hour.toString().padStart(2, '0');
      const m = minutes.toString().padStart(2, '0');
      timeOptions.push(`${h}:${m}`);
    }
  }
  
  async function fetchTables() {
    loading.value = true;
    error.value = '';
    try {
      const response = await axios.get('/api/tables/availability', {
        params: {
          date: date.value,
          time: time.value,
        },
      });
      tables.value = response.data;
    } catch (err) {
      console.error(err);
      error.value = 'Failed to fetch available tables.';
    } finally {
      loading.value = false;
    }
  }
  </script>
  
  <style scoped>
  /* Additional custom styles if needed */
  </style>