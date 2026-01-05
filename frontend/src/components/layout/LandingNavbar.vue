<script setup>
import { ref } from 'vue'
import { toggleTheme } from "@/utils/theme";

const isOpen = ref(false)
</script>

<template>
  <header
    class="w-full border-b border-black/20 dark:border-white/10
           bg-white dark:bg-gray-900 transition-colors"
  >
    <nav
      class="w-full px-12 h-16 flex items-center justify-between
             text-gray-900 dark:text-gray-100 transition-colors"
    >

      <!-- LOGO -->
      <div
        class="flex items-center gap-3 cursor-pointer select-none"
        @click="toggleTheme"
      >
        <div
          class="w-9 h-9 border-6 rounded-full
                 border-blue-700 dark:border-blue-400
                 transition-colors"
        ></div>

        <span class="font-bold text-lg tracking-wide">
          LIFE ACHIEVEMENTS
        </span>
      </div>

      <!-- DESKTOP MENU -->
      <div class="hidden md:flex items-center gap-6">
        <RouterLink
          to="/login"
          class="text-sm font-semibold hover:underline
                 text-gray-900 dark:text-gray-100"
        >
          Log In
        </RouterLink>

        <RouterLink
          to="/signup"
          class="bg-blue-600 hover:bg-blue-700
                 text-white px-4 py-2 rounded-full
                 text-sm font-semibold transition"
        >
          Sign Up
        </RouterLink>
      </div>

      <!-- MOBILE TOGGLE -->
      <button
        class="md:hidden text-gray-900 dark:text-gray-100"
        @click="isOpen = !isOpen"
        aria-label="Menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </nav>

    <!-- MOBILE MENU -->
    <div
      v-if="isOpen"
      class="md:hidden border-t border-black/10 dark:border-white/10
             bg-white dark:bg-gray-900 transition-colors"
    >
      <div
        class="flex flex-col items-center gap-4 py-6
               text-gray-900 dark:text-gray-100"
      >
        <RouterLink to="/login" class="text-sm font-semibold hover:underline">
          Log In
        </RouterLink>

        <RouterLink
          to="/signup"
          class="bg-blue-600 hover:bg-blue-700
                 text-white px-4 py-2 rounded-full
                 text-sm font-semibold transition"
        >
          Sign Up
        </RouterLink>
      </div>
    </div>
  </header>
</template>
