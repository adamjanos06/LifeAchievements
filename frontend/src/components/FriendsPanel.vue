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
const popupMessage = ref("")
const popupType = ref("error")

let popupTimer = null

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

function showPopupMessage(message, type = "error") {
  popupMessage.value = message
  popupType.value = type

  if (popupTimer) {
    clearTimeout(popupTimer)
  }

  popupTimer = setTimeout(() => {
    popupMessage.value = ""
  }, 4200)
}

function normalized(value) {
  return value.trim().toLowerCase()
}

function alreadyFriendsByName(name) {
  const target = normalized(name)
  return friends.value.some(f => normalized(f.name || "") === target)
}

function alreadySentByName(name) {
  const target = normalized(name)
  return sentRequests.value.some(r => normalized(r.receiver?.name || "") === target)
}

function hasIncomingByName(name) {
  const target = normalized(name)
  return requests.value.some(r => normalized(r.sender?.name || "") === target)
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
  const targetName = username.value.trim()
  if (!targetName) return

  if (alreadyFriendsByName(targetName)) {
    showPopupMessage("You are already friends with this user.")
    return
  }

  if (alreadySentByName(targetName)) {
    showPopupMessage("You already sent a friend request to this user.")
    return
  }

  if (hasIncomingByName(targetName)) {
    showPopupMessage("This user has already sent you a friend request.")
    return
  }

  const payload = { name: targetName }
  const res = await fetch("http://backend.vm1.test/api/friends", {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(payload)
  })

  if (!res.ok) {
    const errorData = await res.json().catch(() => ({}))
    const backendMessage = errorData?.message

    if (res.status === 400) {
      showPopupMessage("You cannot send a friend request to yourself.")
    } else if (res.status === 404) {
      showPopupMessage("User does not exist.")
    } else if (res.status === 409) {
      if (alreadyFriendsByName(targetName)) {
        showPopupMessage("You are already friends with this user.")
      } else {
        showPopupMessage("You already sent a friend request to this user.")
      }
    } else {
      showPopupMessage(backendMessage || "Failed to send friend request.")
    }
  } else {
    const data = await res.json().catch(() => ({}))
    if (!alreadySentByName(targetName)) {

      sentRequests.value.push({
        id: data.id || Math.random(),
        receiver: { name: targetName }
      })
    }

    if (data.badge) {
      unlockedBadge.value = data.badge
    }

    showPopupMessage("Friend request sent.", "success")
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

  <div
    v-if="show"
    class="fixed inset-0 bg-black/60 flex items-center justify-center z-65"
  >
    <div
      v-if="popupMessage"
      class="absolute top-14 left-1/2 -translate-x-1/2 px-4 py-3 rounded-xl shadow-lg border text-sm font-semibold z-10"
      :class="popupType === 'success'
        ? 'bg-green-50 border-green-300 text-green-800 dark:bg-green-900/25 dark:border-green-700 dark:text-green-200'
        : 'bg-red-50 border-red-300 text-red-800 dark:bg-red-900/25 dark:border-red-700 dark:text-red-200'"
    >
      {{ popupMessage }}
    </div>

    <div
      class="bg-white dark:bg-gray-800
             w-[35vw] min-w-[420px] max-w-[650px]
             h-[420px]
             p-8 rounded-3xl
             text-gray-900 dark:text-gray-100
             shadow-2xl
             dark:shadow-[0_0_50px_rgba(255,255,255,0.18)]
             flex flex-col"
    >

      <div class="flex items-center justify-between mb-6 shrink-0">
        <div class="flex gap-2 bg-gray-200 dark:bg-gray-700 p-1.5 rounded-2xl">

          <button
            @click="activeTab='friends'"
            class="px-4 py-2 rounded-xl font-semibold transition"
            :class="activeTab==='friends'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'"
          >
            Friends
          </button>

          <button
            @click="activeTab='requests'"
            class="px-4 py-2 rounded-xl font-semibold transition"
            :class="activeTab==='requests'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'"
          >
            Requests
          </button>

          <button
            @click="activeTab='add'"
            class="px-4 py-2 rounded-xl font-semibold transition"
            :class="activeTab==='add'
              ? 'bg-white dark:bg-gray-800 shadow text-blue-600'
              : 'text-gray-600 dark:text-gray-300 hover:text-blue-500'"
          >
            Add
          </button>

        </div>

        <button
          @click="toggle"
          class="text-2xl opacity-70 hover:opacity-100 transition"
        >
          ×
        </button>
      </div>

      <div class="flex-1 overflow-hidden">

        <div
          v-if="activeTab==='friends'"
          class="space-y-4 overflow-y-auto h-full"
        >

          <div
            v-if="friends.length === 0"
            class="h-full flex items-center justify-center text-center px-6"
          >
            <p class="text-gray-500 dark:text-gray-400 text-lg">
              You don't have any friends yet.<br />
              Start by adding someone in the Add tab.
            </p>
          </div>

          <template v-else>
            <div
              v-for="f in friends"
              :key="f.id"
              class="p-5 rounded-2xl
                     bg-gray-100 dark:bg-gray-700
                     hover:bg-gray-200 dark:hover:bg-gray-600
                     transition cursor-pointer flex items-center gap-4"
              @click="goToProfile(f.id)"
            >
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
          </template>
        </div>

        <div
          v-if="activeTab==='requests'"
          class="space-y-4 overflow-y-auto h-full"
        >

          <div
            v-if="requests.length === 0 && sentRequests.length === 0"
            class="h-full flex items-center justify-center text-center px-6"
          >
            <p class="text-gray-500 dark:text-gray-400 text-lg">
              You have no pending requests at the moment.<br />
              When someone sends you a request, it will appear here.
            </p>
          </div>

          <template v-else>

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

          </template>
        </div>

        <div
          v-if="activeTab==='add'"
          class="flex flex-col h-full justify-between"
        >

          <div class="flex-1 flex items-center justify-center text-center px-6">
            <p class="text-gray-500 dark:text-gray-400 text-lg">
              You can add friends by entering their username.<br />
              Once they accept your request, they will appear in your friends list.
            </p>
          </div>

          <div class="space-y-4">
            <input
              v-model="username"
              placeholder="Username"
              class="w-full px-4 py-3 rounded-xl
                     bg-gray-100 dark:bg-gray-700
                     border border-gray-300 dark:border-gray-600
                     focus:outline-none focus:ring-2 focus:ring-blue-600"
            />

            <button
              @click="sendRequest"
              class="w-full bg-blue-600 hover:bg-blue-700
                     text-white py-3 rounded-xl font-semibold
                     transition shadow-lg"
            >
              Send Request
            </button>
          </div>

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