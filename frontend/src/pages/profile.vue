<script setup>
import { ref, onMounted, computed } from "vue"
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const router = useRouter()

const user = ref(null)
const completedAchievements = ref([])
const loading = ref(true)

/* -------- LOAD DATA -------- */

async function loadUser() {
  const res = await fetch("http://backend.vm1.test/api/me", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })
  user.value = await res.json()
}

async function loadCompletedAchievements() {
  const res = await fetch(
    "http://backend.vm1.test/api/my-achievements",
    {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  )

  const json = await res.json()
  completedAchievements.value = json.data?.data ?? json.data
}

onMounted(async () => {
  try {
    await Promise.all([
      loadUser(),
      loadCompletedAchievements(),
    ])
  } finally {
    loading.value = false
  }
})

/* -------- COMPUTED STATS -------- */

const achievementsUnlocked = computed(() =>
  completedAchievements.value.length
)

const totalXp = computed(() =>
  completedAchievements.value.reduce(
    (sum, a) => sum + (a.achievement?.xp ?? 0),
    0
  )
)

const XP_PER_LEVEL = 600

const level = computed(() =>
  Math.floor(totalXp.value / XP_PER_LEVEL) + 1
)

const currentLevelXp = computed(() =>
  totalXp.value % XP_PER_LEVEL
)

const progressPercent = computed(() =>
  Math.min((currentLevelXp.value / XP_PER_LEVEL) * 100, 100)
)

const recentActivity = computed(() =>
  [...completedAchievements.value]
    .sort(
      (a, b) =>
        new Date(b.completion_date).getTime() -
        new Date(a.completion_date).getTime()
    )
    .slice(0, 3)
)

/* -------- LOGOUT -------- */

function logout() {
  localStorage.removeItem("token")
  router.push("/")
}
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-6 py-14
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h1 class="text-3xl font-bold mb-8">
      PROFILE
    </h1>

    <p v-if="loading">Loading...</p>

    <div
      v-else-if="!user"
      class="text-center text-gray-500 dark:text-gray-400"
    >
      You need to log in to view your profile.
    </div>

    <div v-else class="space-y-8">

      <!-- ================= PROFILE HEADER ================= -->

      <div
        class="bg-white dark:bg-gray-800
               rounded-2xl shadow
               p-6 flex items-center gap-6
               transition-colors"
      >
        <!-- AVATAR -->
        <div
          class="w-24 h-24 rounded-full
                 bg-blue-600 text-white
                 flex items-center justify-center
                 text-4xl font-bold overflow-hidden"
        >
          <img
            v-if="user.avatar"
            :src="user.avatar"
            class="w-full h-full object-cover"
          />
          <span v-else>
            {{ user.name[0].toUpperCase() }}
          </span>
        </div>

        <!-- INFO -->
        <div class="flex-1 space-y-2">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">
              {{ user.username ?? user.name }}
            </h2>

            <span class="font-semibold text-gray-700 dark:text-gray-300">
              Level {{ level }}
            </span>
          </div>

          <!-- XP BAR -->
          <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div
              class="bg-blue-600 h-3 rounded-full transition-all"
              :style="{ width: progressPercent + '%' }"
            ></div>
          </div>

          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ currentLevelXp }} / {{ XP_PER_LEVEL }} XP
          </p>

          <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 text-sm">
            📧 {{ user.email }}
          </div>
        </div>

        <!-- ACTIONS -->
        <div class="flex flex-col gap-2">
          <button
            class="border border-gray-300 dark:border-gray-600
                   px-4 py-2 rounded-lg font-semibold
                   hover:bg-gray-100 dark:hover:bg-gray-700
                   transition"
          >
            ✏️ Edit Profile
          </button>

          <button
            @click="logout"
            class="bg-red-600 hover:bg-red-700
                   text-white px-4 py-2
                   rounded-lg font-semibold transition"
          >
            Log Out
          </button>
        </div>
      </div>

      <!-- ================= STATS + ACTIVITY ================= -->

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- STATS -->
        <div
          class="bg-white dark:bg-gray-800
                 rounded-2xl shadow p-6 space-y-4
                 transition-colors"
        >
          <h3 class="font-semibold text-lg">
            Stats
          </h3>

          <div class="flex justify-between">
            <span>🏆 Achievements Unlocked</span>
            <strong>{{ achievementsUnlocked }}</strong>
          </div>

          <div class="flex justify-between">
            <span>⭐ Total XP</span>
            <strong>{{ totalXp }}</strong>
          </div>

          <div class="flex justify-between">
            <span>📅 Member Since</span>
            <strong>2025</strong>
          </div>
        </div>

        <!-- RECENT ACTIVITY -->
        <div
          class="md:col-span-2
                 bg-white dark:bg-gray-800
                 rounded-2xl shadow p-6 space-y-4
                 transition-colors"
        >
          <h3 class="font-semibold text-lg">
            Recent Activity
          </h3>

          <div
            v-for="a in recentActivity"
            :key="a.id"
            class="flex justify-between items-center
                   border border-gray-200 dark:border-gray-700
                   rounded-xl px-4 py-3"
          >
            <div>
              <p class="font-medium">
                Completed: {{ a.achievement.name }}
              </p>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ new Date(a.completion_date).toLocaleDateString() }}
              </p>
            </div>

            <span class="text-green-600 font-semibold">
              +{{ a.achievement.xp }} XP
            </span>
          </div>

          <p
            v-if="recentActivity.length === 0"
            class="text-gray-500 dark:text-gray-400 text-sm"
          >
            No recent activity yet.
          </p>
        </div>

      </div>
    </div>
  </div>
</template>
