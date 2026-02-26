<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

const show = ref(false)
const friends = ref([])
const requests = ref([])
const sentRequests = ref([])
const username = ref("")
const activeTab = ref("friends")

const token = localStorage.getItem("token")

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
  <button
    @click="toggle"
    class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700
           text-white px-5 py-3 rounded-full shadow-lg z-60"
  >
    Friends
  </button>

  <div
    v-if="show"
    class="fixed inset-0 bg-black/60 flex items-center justify-center z-65"
  >
    <div
      class="bg-white dark:bg-gray-800
             w-full max-w-md mx-4 p-6 rounded-2xl
             text-gray-900 dark:text-gray-100"
    >
      <div class="flex justify-between mb-6">
        <button @click="activeTab='friends'"
          :class="activeTab==='friends'
            ? 'font-bold text-blue-600'
            : ''">
          Friends
        </button>

        <button @click="activeTab='requests'"
          :class="activeTab==='requests'
            ? 'font-bold text-blue-600'
            : ''">
          Requests
        </button>

        <button @click="activeTab='add'"
          :class="activeTab==='add'
            ? 'font-bold text-blue-600'
            : ''">
          Add
        </button>

        <button @click="toggle">×</button>
      </div>

      <div v-if="activeTab==='friends'" class="space-y-3 max-h-80 overflow-y-auto">
        <div v-for="f in friends" :key="f.id"
             class="p-3 border rounded-lg">
          <span
            class="cursor-pointer text-blue-600 hover:underline"
            @click="goToProfile(f.id)"
          >
            {{ f.name }}
          </span>
        </div>
      </div>

      <div v-if="activeTab==='requests'" class="space-y-3 max-h-80 overflow-y-auto">
        <!-- incoming requests -->
        <div v-for="r in requests" :key="r.id"
             class="p-3 border rounded-lg flex justify-between items-center">
          <span>{{ r.sender ? r.sender.name : '...' }}</span>
          <button
            @click="acceptRequest(r.id)"
            class="bg-green-600 hover:bg-green-700
                   text-white px-3 py-1 rounded"
          >
            Accept
          </button>
        </div>

        <!-- outgoing requests -->
        <template v-if="sentRequests.length">
          <hr class="my-2" />
          <div v-for="r in sentRequests" :key="`sent-${r.id}`"
               class="p-3 border rounded-lg flex justify-between items-center">
            <span>To: {{ r.receiver ? r.receiver.name : '...' }}</span>
            <button
              @click="cancelRequest(r.id)"
              class="bg-red-600 hover:bg-red-700
                     text-white px-3 py-1 rounded"
            >
              Cancel
            </button>
          </div>
        </template>
      </div>

      <div v-if="activeTab==='add'" class="space-y-4">
        <input
          v-model="username"
          placeholder="Username"
          class="w-full px-3 py-2 border rounded-lg"
        />
        <button
          @click="sendRequest"
          class="w-full bg-blue-600 hover:bg-blue-700
                 text-white py-2 rounded-lg"
        >
          Send Request
        </button>
      </div>
    </div>
  </div>
</template>
