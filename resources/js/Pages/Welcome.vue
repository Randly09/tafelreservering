<template>
    <GuestLayout>
      <Head title="Welcome to TafelReservering" />
      <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-900">
        <div class="text-center px-4">
          <!-- Logo / App Name -->
          <img src="/Images/logo.png" alt="TafelReservering Logo" class="w-70 h-60 mx-auto mb-4" />
          <h1 class="text-4xl font-bold mb-2 text-gray-800 dark:text-white">
            Welcome to TafelReservering
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
            Easily reserve your table at your favorite restaurant in Amsterdam.
          </p>
          <!-- Call to Action Buttons -->
          <div class="flex justify-center space-x-4">
            <Link
              v-if="canLogin"
              :href="route('login')"
              class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
            >
              Log In
            </Link>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
            >
              Register
            </Link>
          </div>
        </div>
      </div>
    </GuestLayout>
  </template>
  
  <script setup>
  import { Head, Link } from '@inertiajs/vue3';
  
  defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
  });
  </script>
  
  <style scoped>
  /* You can add any custom styles here */
  </style>
