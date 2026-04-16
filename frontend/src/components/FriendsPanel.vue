<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from "vue-router"
import BadgePopup from "@/components/BadgePopup.vue"

const router = useRouter()

const show = ref(false)
const friends = ref([])
const requests = ref([])
const sentRequests = ref([])
const username = ref("")
const activeTab = ref("friends")
const unlockedBadge = ref(null)

const token = localStorage.getItem("token")

function getAvatarUrl(image) {
  if (!image) return null
  const filename = image.split("/").pop()
  return `http://backend.vm1.test/api/avatar/${filename}`
}

function toggle() {
  show.value = !show.value
  if (show.value && token) loadAll()
}

function goToProfile(id) {
  const me = localStorage.getItem("userId")
  if (me && id === Number(me)) {
    router.push("/profile")
  } else {
    router.push(`/users/${id}`)
  }
}

async function loadAll() {
  await Promise.all([
    loadFriends(),
    loadRequests()
  ])
}

async function loadFriends() {
  const res = await fetch("http://backend.vm1.test/api/friends", {
    headers: { Authorization: `Bearer ${token}` }
  })
  const json = await res.json()
  friends.value = json.data
}

async function loadRequests() {
  const res = await fetch("http://backend.vm1.test/api/friend-requests", {
    headers: { Authorization: `Bearer ${token}` }
  })
  const json = await res.json()

  requests.value = json.incoming || []
  sentRequests.value = json.sent || []
}

async function sendRequest() {
  if (!username.value.trim()) return

  const payload = { name: username.value }
  const res = await fetch("http://backend.vm1.test/api/friends", {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(payload)
  })

  if (!res.ok) {
    console.error('friend request failed', await res.text())
  } else {
    const data = await res.json().catch(() => ({}))
    if (!sentRequests.value.some(r => r.receiver?.name === username.value)) {

      sentRequests.value.push({
        id: data.id || Math.random(),
        receiver: { name: username.value }
      })
    }

    if (data.badge) {
      unlockedBadge.value = data.badge
    }
  }

  username.value = ""
  loadRequests()
}

async function acceptRequest(id) {
  await fetch(`http://backend.vm1.test/api/friend-requests/${id}/accept`, {
    method: "POST",
    headers: { Authorization: `Bearer ${token}` }
  })
  loadAll()
}

async function cancelRequest(id) {
  await fetch(`http://backend.vm1.test/api/friend-requests/${id}`, {
    method: "DELETE",
    headers: { Authorization: `Bearer ${token}` }
  })
  loadAll()
}

onMounted(() => {
  if (token) loadAll()
})
</script>

<template>
  <!-- FLOATING BUTTON -->
  <div class="fixed bottom-6 right-6 z-60">
    <button
      @click="toggle"
      class="bg-blue-600 hover:bg-blue-700
             text-white px-5 py-3 rounded-full shadow-lg
             transition hover:scale-105 relative"
    >
      Friends
      <div
        v-if="requests.length > 0"
        class="absolute -top-2 -right-2 bg-red-500 text-white
               text-xs font-bold rounded-full w-6 h-6
               flex items-center justify-center shadow-lg"
      >
        {{ requests.length }}
      </div>
    </button>
  </div>

  <!-- MODAL -->
  <div
    v-if="show"
    class="fixed inset-0 bg-black/60 flex items-center justify-center z-65"
  >
    <div
      class="bg-white dark:bg-gray-800
             w-full max-w-lg mx-4 p-8 rounded-3xl
             text-gray-900 dark:text-gray-100
             shadow-2xl
             dark:shadow-[0_0_50px_rgba(255,255,255,0.18)]"
    >

      <!-- HEADER -->
      <div class="flex items-center justify-between mb-8">
        <div class="flex gap-2 bg-gray-200 dark:bg-gray-700 p-1.5 rounded-2xl">

          <button @click="activeTab='friends'"
            class="px-4 py-2 rounded-xl text-sm font-semibold transition"
            :class="activeTab==='friends'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'">
            Friends
          </button>

          <button @click="activeTab='requests'"
            class="px-4 py-2 rounded-xl text-sm font-semibold transition"
            :class="activeTab==='requests'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'">
            Requests
          </button>

          <button @click="activeTab='add'"
            class="px-4 py-2 rounded-xl text-sm font-semibold transition"
            :class="activeTab==='add'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'">
            Add
          </button>

        </div>

        <button @click="toggle" class="text-2xl opacity-70 hover:opacity-100">
          ×
        </button>
      </div>

      <!-- FRIENDS -->
      <div v-if="activeTab==='friends'" class="space-y-4 max-h-96 overflow-y-auto">
        <div
          v-for="f in friends"
          :key="f.id"
          class="p-5 rounded-2xl
                 bg-gray-100 dark:bg-gray-700
                 hover:bg-gray-200 dark:hover:bg-gray-600
                 transition cursor-pointer flex items-center gap-4"
          @click="goToProfile(f.id)"
        >
          <!-- AVATAR -->
          <div class="w-12 h-12 rounded-full overflow-hidden
                      bg-blue-600 text-white
                      flex items-center justify-center text-lg font-bold">
            <img
              v-if="getAvatarUrl(f.image)"
              :src="getAvatarUrl(f.image)"
              class="w-full h-full object-cover"
            />
            <span v-else>
              {{ f.name[0].toUpperCase() }}
            </span>
          </div>

          <span class="font-semibold text-blue-600">
            {{ f.name }}
          </span>
        </div>
      </div>

      <!-- REQUESTS -->
      <div v-if="activeTab==='requests'" class="space-y-4 max-h-96 overflow-y-auto">

        <div
          v-for="r in requests"
          :key="r.id"
          class="p-5 rounded-2xl
                 bg-gray-100 dark:bg-gray-700
                 flex justify-between items-center"
        >
          <span>{{ r.sender?.name }}</span>
          <button
            @click="acceptRequest(r.id)"
            class="bg-green-600 hover:bg-green-700
                   text-white px-4 py-2 rounded-xl"
          >
            Accept
          </button>
        </div>

        <template v-if="sentRequests.length">
          <hr class="my-3 border-gray-300 dark:border-gray-600" />

          <div
            v-for="r in sentRequests"
            :key="r.id"
            class="p-5 rounded-2xl
                   bg-gray-100 dark:bg-gray-700
                   flex justify-between items-center"
          >
            <span>To: {{ r.receiver?.name }}</span>
            <button
              @click="cancelRequest(r.id)"
              class="bg-red-600 hover:bg-red-700
                     text-white px-4 py-2 rounded-xl"
            >
              Cancel
            </button>
          </div>
        </template>
      </div>

      <!-- ADD -->
      <div v-if="activeTab==='add'" class="space-y-5">
        <input
          v-model="username"
          placeholder="Username"
          class="w-full px-4 py-3 rounded-xl
                 bg-gray-100 dark:bg-gray-700
                 border border-gray-300 dark:border-gray-600"
        />

        <button
          @click="sendRequest"
          class="w-full bg-blue-600 hover:bg-blue-700
                 text-white py-3 rounded-xl font-semibold"
        >
          Send Request
        </button>
      </div>
    </div>
  </div>

  <BadgePopup
    v-if="unlockedBadge"
    :badge="unlockedBadge"
    @close="unlockedBadge = null"
  />
</template>