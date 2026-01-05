<script setup>
import { ref } from 'vue'
import { toggleTheme } from "@/utils/theme"

const isOpen = ref(false)
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

      <!-- LOGO -->
      <div
        class="flex items-center gap-4 cursor-pointer select-none"
        @click="toggleTheme"
      >
        <div
          class="w-9 h-9 md:w-11 md:h-11 lg:w-12 lg:h-12
                 border-[5px] md:border-[6px] lg:border-[7px]
                 border-blue-700 dark:border-blue-400
                 rounded-full transition-colors"
        ></div>

        <RouterLink
          to="/catalog"
          class="font-bold text-xl md:text-2xl tracking-wide"
        >
          LIFE ACHIEVEMENTS
        </RouterLink>
      </div>

      <!-- DESKTOP MENU -->
      <div class="hidden lg:flex items-center gap-10">
        <RouterLink to="/achievements" class="font-semibold hover:underline">
          My achievements
        </RouterLink>

        <RouterLink to="/catalog" class="font-semibold hover:underline">
          Catalog
        </RouterLink>

        <RouterLink to="/profile" class="font-semibold hover:underline">
          Profile
        </RouterLink>

        <RouterLink to="/leaderboard" class="font-semibold hover:underline">
          Leaderboard
        </RouterLink>
      </div>

      <!-- MOBILE TOGGLE -->
      <button
        class="lg:hidden text-gray-900 dark:text-gray-100"
        @click="isOpen = !isOpen"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </nav>

    <!-- MOBILE MENU -->
    <div
      v-if="isOpen"
      class="lg:hidden border-t border-black/10 dark:border-white/10
             bg-white dark:bg-gray-900 transition-colors"
    >
      <div
        class="flex flex-col items-center gap-5 py-6
               text-gray-900 dark:text-gray-100"
      >
        <RouterLink to="/achievements" @click="isOpen = false">
          Achievements
        </RouterLink>

        <RouterLink to="/catalog" @click="isOpen = false">
          Catalog
        </RouterLink>

        <RouterLink to="/profile" @click="isOpen = false">
          Profile
        </RouterLink>

        <RouterLink to="/leaderboard" @click="isOpen = false">
          Leaderboard
        </RouterLink>
      </div>
    </div>
  </header>
</template>
