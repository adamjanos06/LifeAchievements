<script setup>
import { ref, onMounted } from "vue"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const users = ref([])
const currentUser = ref(null)
const loading = ref(true)
const animatedXp = ref({})

async function loadLeaderboard() {
  const res = await fetch("http://backend.vm1.test/api/leaderboard")
  users.value = await res.json()
}

async function loadCurrentUser() {
  const res = await fetch("http://backend.vm1.test/api/me", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })
  currentUser.value = await res.json()
}

/* XP animation */
function animateXpValues() {
  users.value.forEach(user => {
    animatedXp.value[user.id] = 0

    const target = user.xp
    const step = Math.ceil(target / 30)

    const interval = setInterval(() => {
      if (animatedXp.value[user.id] >= target) {
        animatedXp.value[user.id] = target
        clearInterval(interval)
      } else {
        animatedXp.value[user.id] += step
      }
    }, 20)
  })
}

/* Top 3 badge */
function getMedal(index) {
  if (index === 0) return "🥇"
  if (index === 1) return "🥈"
  if (index === 2) return "🥉"
  return null
}

function getAvatarUrl(image) {
  if (!image) return null
  const filename = image.split("/").pop()
  return `http://backend.vm1.test/api/avatar/${filename}`
}

onMounted(async () => {
  await Promise.all([loadLeaderboard(), loadCurrentUser()])
  animateXpValues()
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
        :class="[
          'rounded-xl shadow px-6 py-4 flex items-center justify-between transition',
          index === 0
            ? 'bg-yellow-100 dark:bg-yellow-500/10 border border-yellow-400 shadow-yellow-400/40'
            : 'bg-white dark:bg-gray-800',
          user.id === currentUser?.id
            ? 'ring-2 ring-blue-500'
            : ''
        ]"
      >

        <div class="flex items-center gap-4">

          <!-- Rank -->
          <span class="text-lg font-bold w-8 text-center">
            <span v-if="getMedal(index)">
              {{ getMedal(index) }}
            </span>
            <span v-else>
              {{ index + 1 }}
            </span>
          </span>

          <!-- Avatar -->
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

          <!-- Name + Level -->
          <div>
            <p class="font-semibold">
              {{ user.name }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Level {{ user.level_data?.level }}
            </p>
          </div>
        </div>

        <!-- XP -->
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
