<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import BadgePopup from "@/components/BadgePopup.vue"
import { useRouter } from "vue-router"

const router = useRouter()

const route = useRoute()
const user = ref(null)
const loading = ref(true)
const username = ref("")
const unlockedBadge = ref(null)
const requestSent = ref(false)
const token = localStorage.getItem("token")
const currentUserId = Number(localStorage.getItem("userId"))

async function loadUser() {
  const res = await fetch(
    `http://backend.vm1.test/api/users/${route.params.id}`,
    {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  )

  user.value = await res.json()
}

async function loadFriendRequests() {
  if (!token || !user.value?.id) return

  const res = await fetch("http://backend.vm1.test/api/friend-requests", {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })

  const json = await res.json().catch(() => ({}))
  const sent = json.sent || []
  requestSent.value = sent.some(
    (r) => r.receiver?.id === user.value.id || r.receiver?.name === user.value.name
  )
}

onMounted(async () => {
  await loadUser()
  await loadFriendRequests()
  loading.value = false
})

function getAvatarUrl(image) {
  if (!image) return null
  const filename = image.split("/").pop()
  return `http://backend.vm1.test/api/avatar/${filename}`
}

function goBack() {
  window.history.length > 1
    ? router.back()
    : router.push("/leaderboard")
}
async function sendRequest() {
  if (requestSent.value) return

  const payload = { name: user.value.name }

  const res = await fetch("http://backend.vm1.test/api/friends", {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(payload)
  })

  if (!res.ok) {
    console.error("friend request failed", await res.text())
  } else {
    const data = await res.json().catch(() => ({}))
    requestSent.value = true
    if (data.badge) {
      unlockedBadge.value = data.badge
    }
  }
}
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-6 py-14">

    <div v-if="loading">Loading...</div>

    <div v-else-if="!user">User not found.</div>

    <div v-else class="space-y-8">
      <button
        @click="goBack"
        class="mb-6 px-5 py-2 rounded-xl
              bg-gray-200 dark:bg-gray-700
              text-gray-800 dark:text-gray-100
              font-semibold
              hover:bg-gray-300 dark:hover:bg-gray-600
              transition"
      >
        ← Back
      </button>
      <!-- HEADER -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <div class="flex items-center gap-6">

          <div
            class="w-28 h-28 rounded-full bg-blue-600 text-white
                   flex items-center justify-center text-5xl font-bold overflow-hidden"
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

          <div class="flex-1 space-y-3">

            <div class="flex justify-between items-center">
              <h2 class="text-2xl font-bold">
                {{ user.name }}
              </h2>

              <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-blue-500 dark:text-cyan-400">
                  Level {{ user.level_data?.level }}
                </span>

                <button
                  v-if="user.id !== currentUserId"
                  type="button"
                  @click="sendRequest"
                  :disabled="requestSent"
                  :class="[
                    'text-sm font-semibold px-5 py-2 rounded-xl transition',
                    requestSent
                      ? 'bg-gray-400 text-gray-700 cursor-not-allowed'
                      : 'bg-blue-600 hover:bg-blue-700 text-white'
                  ]"
                >
                  {{ requestSent ? 'Request Sent' : 'Add Friend' }}
                </button>
              </div>
            </div>

            <!-- PROGRESS -->
            <div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                <div
                  class="bg-blue-600 h-3 rounded-full transition-all"
                  :style="{ width: (user.level_data?.progress_percent ?? 0) + '%' }"
                ></div>
              </div>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ user.level_data?.current_level_xp ?? 0 }}
                /
                {{ user.level_data?.xp_needed ?? 0 }} XP
              </p>
            </div>

          </div>

        </div>
      </div>

      <!-- BIO -->
      <div v-if="user.bio"
           class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h3 class="text-lg font-semibold mb-2">About</h3>
        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
          {{ user.bio }}
        </p>
      </div>

      <!-- STATS -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
        <h3 class="font-semibold text-lg">Stats</h3>

        <div class="flex justify-between">
          <span>🏆 Achievements</span>
          <strong>{{ user.achievements_count }}</strong>
        </div>

        <div class="flex justify-between">
          <span>⭐ Total XP</span>
          <strong>{{ user.xp }}</strong>
        </div>

        <div class="flex justify-between">
          <span>🔥 Favorite Category</span>
          <strong>{{ user.favorite_category ?? 'None' }}</strong>
        </div>

        <div class="flex justify-between">
          <span>📅 Member Since</span>
          <strong>
            {{ new Date(user.created_at).toLocaleDateString() }}
          </strong>
        </div>

      </div>

    </div>
  </div>
  <BadgePopup
    v-if="unlockedBadge"
    :badge="unlockedBadge"
    @close="unlockedBadge = null"
  />
</template>
