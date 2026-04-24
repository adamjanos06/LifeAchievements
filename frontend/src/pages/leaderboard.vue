<script setup>
import { useLeaderboardPage } from "@/utils/composables/useLeaderboardPage.js"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const {
  users,
  currentUser,
  loading,
  animatedXp,
  mode,
  searchQuery,
  filteredUsers,
  goToProfile,
  getMedal,
  getAvatarUrl,
} = useLeaderboardPage()
</script>

<template>
  <MainNavbar />

  <div class="max-w-4xl mx-auto px-6 py-14 space-y-6">

    <h1 class="text-3xl font-bold text-center">
      Leaderboard
    </h1>

    <div class="flex justify-center mt-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search people..."
        class="w-full max-w-md px-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
    </div>

    <div class="flex justify-center mt-3">

      <div class="bg-gray-200 dark:bg-gray-700 p-1 rounded-full flex">

        <button
          @click="mode = 'global'"
          :class="mode === 'global'
            ? 'bg-white dark:bg-gray-900 shadow text-blue-600'
            : 'text-gray-600 dark:text-gray-300'"
          class="px-6 py-2 rounded-full font-semibold transition"
        >
          Global
        </button>

        <button
          @click="mode = 'friends'"
          :class="mode === 'friends'
            ? 'bg-white dark:bg-gray-900 shadow text-blue-600'
            : 'text-gray-600 dark:text-gray-300'"
          class="px-6 py-2 rounded-full font-semibold transition"
        >
          Friends
        </button>

      </div>

    </div>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
      {{ mode === 'friends' ? 'Friends leaderboard' : 'Global leaderboard' }}
    </p>

    <div v-if="loading" class="text-center">
      Loading...
    </div>

    <div v-else class="space-y-4">

      <div
        v-for="(user, index) in filteredUsers"
        :key="user.id"
        @click="goToProfile(user.id)"
        class="cursor-pointer"
        :class="[
          'rounded-xl shadow px-6 py-4 flex items-center justify-between transition hover:scale-[1.01]',
          index === 0
            ? 'bg-yellow-100 dark:bg-yellow-500/10 border border-yellow-400 shadow-yellow-400/40'
            : 'bg-white dark:bg-gray-800',
          user.id === currentUser?.id
            ? 'ring-2 ring-blue-500'
            : ''
        ]"
      >
        <div class="flex items-center gap-4">

          <span class="text-lg font-bold w-8 text-center">
            <span v-if="getMedal(index)">
              {{ getMedal(index) }}
            </span>
            <span v-else>
              {{ index + 1 }}
            </span>
          </span>

          <div
            :class="[
              'w-12 h-12 rounded-full flex items-center justify-center text-white font-bold overflow-hidden',
              index === 0
                ? 'bg-yellow-500 shadow-lg shadow-yellow-400/60'
                : 'bg-blue-600'
            ]"
          >
            <img
              v-if="getAvatarUrl(user.image)"
              :src="getAvatarUrl(user.image)"
              class="w-full h-full object-cover"
            />
            <span v-else>
              {{ user.name[0].toUpperCase() }}
            </span>
          </div>

          <div>
            <p class="font-semibold">
              {{ user.name }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Level {{ user.level_data?.level }}
            </p>
          </div>
        </div>

        <div class="text-right">
          <p
            :class="[
              'font-bold text-lg',
              index === 0
                ? 'text-yellow-500 drop-shadow-[0_0_6px_rgba(234,179,8,0.8)]'
                : 'text-blue-600 dark:text-blue-400'
            ]"
          >
            {{ animatedXp[user.id] ?? 0 }} XP
          </p>
        </div>

      </div>

    </div>

  </div>
</template>