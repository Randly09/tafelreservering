<template>
    <div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white">
      <!-- Header Navigation -->
      <header class="bg-blue-800 shadow">
        <div class="container mx-auto flex items-center justify-between py-4 px-6">
          <!-- Logo and Title -->
          <div class="flex items-center">
            <img src="/Images/logo.png" alt="Logo" class="logoImage" />
            <span class="text-xl font-bold">Admin Dashboard</span>
          </div>
          <!-- Navigation Buttons -->
          <nav>
            <ul class="flex space-x-4">
              <li>
                <Link :href="route('beheerderReservations.index')" class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">
                  Reservations
                </Link>
              </li>
              <li>
                <Link :href="route('beheerderTables.index')" class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600">
                  Tables
                </Link>
              </li>
            </ul>
          </nav>
        </div>
      </header>
  
      <!-- Main Content -->
      <main class="py-8">
        <div class="container mx-auto">
          <h1 class="text-3xl font-bold mb-6 text-center">Most Recent Bookings</h1>
          
          <!-- Bookings Table -->
          <div v-if="reservations.length" class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full text-black">
              <thead class="bg-gray-200">
                <tr>
                  <th class="py-3 px-4 text-center">Reservation ID</th>
                  <th class="py-3 px-4 text-center">Table</th>
                  <th class="py-3 px-4 text-center">User</th>
                  <th class="py-3 px-4 text-center">Date</th>
                  <th class="py-3 px-4 text-center">Time</th>
                  <th class="py-3 px-4 text-center">Phone</th>
                  <th class="py-3 px-4 text-center">Occasion</th>
                  <th class="py-3 px-4 text-center">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="reservation in reservations"
                  :key="reservation.id"
                  class="border-b last:border-b-0"
                >
                  <td class="py-3 px-4 text-center">{{ reservation.id }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.table ? reservation.table.name : 'N/A' }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.user ? reservation.user.name : 'N/A' }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.date }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.time }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.phone_number }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.Occasion }}</td>
                  <td class="py-3 px-4 text-center">{{ reservation.status }}</td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <!-- Message for No Bookings -->
          <div v-else class="text-center mt-6">
            <p>No recent bookings available.</p>
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script setup>
  import { Head, Link, usePage } from '@inertiajs/vue3'
  import { computed } from 'vue'
  
  // Access the reservations prop passed from the route
  const { props } = usePage()
  const reservations = computed(() => props.reservations || [])
  </script>
  <style>

    .logoImage {
        width: 125px; /* Adjust the size as needed */
        height: 125px; /* Maintain aspect ratio */
        margin-right: 10px; /* Space between logo and title */
    }
</style>