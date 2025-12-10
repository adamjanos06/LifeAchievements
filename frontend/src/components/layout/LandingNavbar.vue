<script setup>
import { ref } from 'vue'

const isOpen = ref(false)
</script>

<template>
  <header class="w-full border-b border-black/20 bg-white">
    <nav class="w-full px-12 h-16 flex items-center justify-between">

      <div class="flex items-center gap-3">
        <div class="w-9 h-9 border-7 border-blue-700 rounded-full"></div>
        <span class="font-bold text-lg tracking-wide">LIFE ACHIEVEMENTS</span>
      </div>

      <div class="hidden md:flex items-center gap-6">
        <button class="text-black hover:underline">
            <RouterLink to="/login" class="text-sm font-semibold hover:underline">
              Log In
            </RouterLink>
        </button>

         <button class="text-lg font-medium">
            <RouterLink to="/signup" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-blue-700 transition">
              Sign Up
            </RouterLink>
        </button>
      </div>

      <button
        class="md:hidden"
        @click="isOpen = !isOpen"
        aria-label="Menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </nav>
    <!-- MOBILE MENU -->
    <div v-if="isOpen" class="md:hidden border-t border-black/10 bg-white">
      <div class="flex flex-col items-center gap-4 py-6">

        <button class="text-lg font-medium">
            <RouterLink to="/login" class="text-sm font-semibold hover:underline">
              Log In
            </RouterLink>
        </button>
         <button class="text-lg font-medium">
            <RouterLink to="/signup" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-blue-700 transition">
              Sign Up
            </RouterLink>
        </button>
      </div>
    </div>
  </header>
</template>