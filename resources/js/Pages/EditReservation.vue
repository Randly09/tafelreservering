<template>
    <div>
      <h1>Edit Reservation</h1>
      <form @submit.prevent="update">
        <div>
          <label>Date</label>
          <input type="date" v-model="form.date" />
        </div>
        <div>
          <label>Time</label>
          <input type="time" v-model="form.time" />
        </div>
        <!-- etc. for phone_number, Occasion, status... -->
  
        <button type="submit">Save</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { usePage } from '@inertiajs/vue3'
  import axios from 'axios'
  
  // Grab the reservation prop
  const page = usePage()
  const reservation = page.props.reservation
  
  // Initialize form with existing data
  const form = ref({
    date: reservation.date,
    time: reservation.time,
    phone_number: reservation.phone_number,
    Occasion: reservation.Occasion,
    status: reservation.status
  })
  
  function update() {
    axios.put(route('reservations.update', { id: reservation.id }), form.value)
  }
  </script>