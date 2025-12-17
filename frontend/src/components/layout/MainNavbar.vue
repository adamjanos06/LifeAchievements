<script setup>
import { ref } from 'vue'

const isOpen = ref(false)
</script>

<template>
  <header class="w-full border-b border-black/20 bg-white">
    <nav class="w-full px-12 h-16 flex items-center justify-between">

      <!-- LOGO -->
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 border-[6px] border-blue-700 rounded-full"></div>
        <RouterLink
          to="/"
          class="font-bold text-lg tracking-wide"
        >
          LIFE ACHIEVEMENTS
        </RouterLink>
      </div>

      <!-- DESKTOP MENU -->
      <div class="hidden md:flex items-center gap-8">
        <RouterLink
          to="/achievements"
          class="text-sm font-semibold hover:underline"
        >
          Achievements
        </RouterLink>

        <RouterLink
          to="/catalog"
          class="text-sm font-semibold hover:underline"
        >
          Catalog
        </RouterLink>

        <RouterLink
          to="/profile"
          class="text-sm font-semibold hover:underline"
        >
          Profile
        </RouterLink>

        <RouterLink
          to="/leaderboard"
          class="text-sm font-semibold hover:underline"
        >
          Leaderboard
        </RouterLink>
      </div>

      <!-- MOBILE TOGGLE -->
      <button
        class="md:hidden"
        @click="isOpen = !isOpen"
        aria-label="Menu"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-7 h-7"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </button>

    </nav>

    <!-- MOBILE MENU -->
    <div
      v-if="isOpen"
      class="md:hidden border-t border-black/10 bg-white"
    >
      <div class="flex flex-col items-center gap-5 py-6">

        <RouterLink
          to="/achievements"
          class="text-base font-semibold"
          @click="isOpen = false"
        >
          Achievements
        </RouterLink>

        <RouterLink
          to="/catalog"
          class="text-base font-semibold"
          @click="isOpen = false"
        >
          Catalog
        </RouterLink>

        <RouterLink
          to="/profile"
          class="text-base font-semibold"
          @click="isOpen = false"
        >
          Profile
        </RouterLink>

        <RouterLink
          to="/leaderboard"
          class="text-base font-semibold"
          @click="isOpen = false"
        >
          Leaderboard
        </RouterLink>

      </div>
    </div>
  </header>
</template>