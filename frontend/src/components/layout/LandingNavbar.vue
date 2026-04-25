<script setup>
import { ref } from 'vue'
import { toggleTheme, isDark } from "@/utils/theme";

const isOpen = ref(false);
</script>

<template>
  <header
    class="w-full border-b border-black/20 dark:border-white/10
           bg-white dark:bg-gray-900 transition-colors"
  >
    <nav
      class="w-full px-4 sm:px-8 lg:px-16
             h-16 md:h-20 lg:h-24
             flex items-center justify-between
             text-gray-900 dark:text-gray-100 transition-colors"
    >

      <div
        class="flex items-center gap-4 cursor-pointer select-none"
        
      >
        <div
          class="w-9 h-9 md:w-11 md:h-11 lg:w-12 lg:h-12
                 border-[5px] md:border-[6px] lg:border-[7px]
                 border-blue-700 dark:border-blue-400
                 rounded-full transition-colors"
        ></div>

        <span class="font-bold text-xl md:text-2xl tracking-wide">
          LIFE ACHIEVEMENTS
        </span>
      </div>

      <div class="hidden md:flex items-center gap-8">

        <RouterLink
          to="/login"
          class="text-base font-semibold hover:underline"
        >
          Log In
        </RouterLink>

        <RouterLink
          to="/signup"
          class="bg-blue-600 hover:bg-blue-700
                 text-white px-5 py-2.5 rounded-full
                 text-base font-semibold transition"
        >
          Sign Up
        </RouterLink>

        <button
          @click="toggleTheme"
          class="ml-2 p-2 rounded-full
                 hover:bg-black/10 dark:hover:bg-white/10
                 transition"
          aria-label="Toggle theme"
        >
          <svg
            v-if="!isDark"
            xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 12.79A9 9 0 1111.21 3
                 7 7 0 0021 12.79z"
            />
          </svg>
        
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="w-6 h-6 text-yellow-400"
          >
            <path
              fill-rule="evenodd"
              d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5
                 0v-1.5A.75.75 0 0110 2zm0 13.5a.75.75 0
                 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75
                 0 01.75-.75zM4.22 4.22a.75.75 0 011.06 0l1.06
                 1.06a.75.75 0 11-1.06 1.06L4.22 5.28a.75.75 0
                 010-1.06zm9.44 9.44a.75.75 0 011.06 0l1.06
                 1.06a.75.75 0 11-1.06 1.06l-1.06-1.06a.75.75
                 0 010-1.06zM2 10a.75.75 0 01.75-.75h1.5a.75.75
                 0 010 1.5h-1.5A.75.75 0 012 10zm13.5 0a.75.75
                 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75
                 0 01-.75-.75zM4.22 15.78a.75.75 0
                 010-1.06l1.06-1.06a.75.75 0 111.06 1.06l-1.06
                 1.06a.75.75 0 01-1.06 0zM13.66 6.34a.75.75 0
                 010-1.06l1.06-1.06a.75.75 0 111.06 1.06l-1.06
                 1.06a.75.75 0 01-1.06 0zM10 6.25a3.75 3.75 0
                 100 7.5 3.75 3.75 0 000-7.5z"
              clip-rule="evenodd"
            />
          </svg>

        </button>

      </div>

      <button
        class="md:hidden text-gray-900 dark:text-gray-100"
        @click="isOpen = !isOpen"
        aria-label="Menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </nav>

    <div
      v-if="isOpen"
      class="md:hidden border-t border-black/10 dark:border-white/10
             bg-white dark:bg-gray-900 transition-colors"
    >
      <div
        class="flex flex-col items-center gap-5 py-6
               text-gray-900 dark:text-gray-100"
      >
        <RouterLink
          to="/login"
          class="text-base font-semibold hover:underline"
          @click="isOpen = false"
        >
          Log In
        </RouterLink>

        <RouterLink
          to="/signup"
          class="bg-blue-600 hover:bg-blue-700
                 text-white px-5 py-2.5 rounded-full
                 text-base font-semibold transition"
          @click="isOpen = false"
        >
          Sign Up
        </RouterLink>

        <button
          @click="toggleTheme"
          class="mt-4 flex items-center gap-2 font-semibold"
        >
          {{ isDark ? 'Light theme' : 'Dark theme' }}
        </button>

      </div>
    </div>
  </header>
</template>
