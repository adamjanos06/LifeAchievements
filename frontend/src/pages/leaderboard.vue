<script setup>
import { ref, onMounted } from "vue"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const users = ref([])
const loading = ref(true)

const XP_PER_LEVEL = 600

async function loadLeaderboard() {
  const res = await fetch("http://backend.vm1.test/api/leaderboard")
  users.value = await res.json()
}

function getLevel(xp) {
  return Math.floor(xp / XP_PER_LEVEL) + 1
}

function getAvatarUrl(image) {
  if (!image) return null
  const filename = image.split("/").pop()
  return `http://backend.vm1.test/api/avatar/${filename}`
}

onMounted(async () => {
  await loadLeaderboard()
  loading.value = false
})
</script>

<template>
  <MainNavbar />

  <div class="max-w-4xl mx-auto px-6 py-14 space-y-8">
    <h1 class="text-3xl font-bold">
      Leaderboard
    </h1>

    <div v-if="loading">
      Loading...
    </div>

    <div v-else class="space-y-4">

      <div
        v-for="(user, index) in users"
        :key="user.id"
        class="bg-white dark:bg-gray-800
               rounded-xl shadow
               px-6 py-4
               flex items-center justify-between
               transition hover:scale-[1.01]"
      >
        <div class="flex items-center gap-4">

          <span class="text-lg font-bold w-6">
            {{ index + 1 }}
          </span>

          <div
            class="w-12 h-12 rounded-full bg-blue-600
                   flex items-center justify-center
                   text-white font-bold overflow-hidden"
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
              Level {{ getLevel(user.xp) }}
            </p>
          </div>
        </div>

        <!-- XP -->
        <div class="text-right">
          <p class="font-bold text-blue-600">
            {{ user.xp }} XP
          </p>
        </div>
      </div>

    </div>
  </div>
</template>
