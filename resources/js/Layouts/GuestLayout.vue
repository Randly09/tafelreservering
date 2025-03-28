<template>
    <!-- Full-height container with a vertical gradient -->
    <div class="min-h-screen bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 text-white flex flex-col">
      
      <!-- Center content with extra vertical padding -->
      <div class="flex flex-col items-center justify-center pt-10">
        
        <!-- Restaurant Logo -->
        <div >
          <!-- Update the src to your actual logo file in /public/images/ -->
          <img
            src="/images/logo.png"
            alt="Restaurant Logo"
            class="w-70 h-60 mx-auto rounded-xl"
          />
        </div>
  
        <!-- Form Container -->
        <div class="w-full max-w-md  rounded-xl">
          <!-- The slot is where Login/Register content goes -->
          <slot />
        </div>
  
      </div>
    </div>
  </template>
  
  <script setup>
  // No script needed unless you want additional props or logic
  </script>
  
  <style scoped>
  /* You can add custom CSS here, but the Tailwind classes above handle most spacing. */
  </style>