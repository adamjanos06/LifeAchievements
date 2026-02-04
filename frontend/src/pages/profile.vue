<script setup>
import { ref, onMounted, computed } from "vue"
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import axios from "axios"

const router = useRouter()

const user = ref(null)
const imageUrl = ref(null)
const completedAchievements = ref([])
const loading = ref(true)


async function loadUser() {
  const res = await fetch("http://backend.vm1.test/api/me", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })
  user.value = await res.json()
}

async function loadCompletedAchievements() {
  const res = await fetch("http://backend.vm1.test/api/my-achievements", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })
  const json = await res.json()
  completedAchievements.value = json.data?.data ?? json.data
}

onMounted(async () => {
  try {
    await Promise.all([loadUser(), loadCompletedAchievements()])
  } finally {
    loading.value = false
  }
})


const achievementsUnlocked = computed(() => completedAchievements.value.length)

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

const currentLevelXp = computed(() => totalXp.value % XP_PER_LEVEL)

const progressPercent = computed(() =>
  Math.min((currentLevelXp.value / XP_PER_LEVEL) * 100, 100)
)

const recentActivity = computed(() =>
  [...completedAchievements.value]
    .sort(
      (a, b) =>
        new Date(b.completion_date) - new Date(a.completion_date)
    )
    .slice(0, 3)
)


function logout() {
  localStorage.removeItem("token")
  router.push("/")
}


const showEditModal = ref(false)
const saving = ref(false)
const errorMsg = ref("")

const editName = ref("")
const editBio = ref("")
const editImage = ref(null)
const imagePreview = ref(null)

function openEditModal() {
  editName.value = user.value.name
  editBio.value = user.value.bio ?? ""
  editImage.value = null
  imagePreview.value = imageUrl.value ?? null

  errorMsg.value = ""
  showEditModal.value = true
}

function onImageChange(e) {
  const file = e.target.files[0]
  if (!file) return

  editImage.value = file
  imagePreview.value = URL.createObjectURL(file)
}

async function saveProfile() {
  if (!editName.value.trim()) return

  saving.value = true
  errorMsg.value = ""

  const form = new FormData()
  form.append("_method", "PUT")
  form.append("name", editName.value)
  form.append("bio", editBio.value)

  if (editImage.value) {
    form.append("image", editImage.value)
  }

  try {
    const res = await axios.post(
      "http://backend.vm1.test/api/me",
      form,
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    )

    user.value = res.data.user || res.data
    imageUrl.value = res.data.image_url || null
    showEditModal.value = false
  } catch (err) {
    errorMsg.value =
      err.response?.data?.message ?? "Failed to update profile."
  } finally {
    saving.value = false
  }
}
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-6 py-14 text-gray-900 dark:text-gray-100">
    <h1 class="text-3xl font-bold mb-8">PROFILE</h1>

    <p v-if="loading">Loading...</p>

    <div v-else-if="!user" class="text-center text-gray-500">
      You need to log in.
    </div>

    <div v-else class="space-y-8">

      <!-- HEADER -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex gap-6">
        <div
          class="w-24 h-24 rounded-full bg-blue-600 text-white
                 flex items-center justify-center text-4xl font-bold overflow-hidden"
        >
          <img
            v-if="imageUrl"
            :src="imageUrl"
            class="w-full h-full object-cover"
          />
          <span v-else>{{ user?.name?.[0]?.toUpperCase() }}</span>
        </div>

        <div class="flex-1 space-y-2">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">{{ user.name }}</h2>
            <span class="text-gray-500">Level {{ level }}</span>
          </div>

          <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div
              class="bg-blue-600 h-3 rounded-full"
              :style="{ width: progressPercent + '%' }"
            ></div>
          </div>

          <p class="text-sm text-gray-500">
            {{ currentLevelXp }} / {{ XP_PER_LEVEL }} XP
          </p>

          <p class="text-sm text-gray-500">📧 {{ user.email }}</p>
        </div>

        <div class="flex flex-col gap-2">
          <button
            @click="openEditModal"
            class="border px-4 py-2 rounded-lg font-semibold
                   hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            ✏️ Edit Profile
          </button>

          <button
            @click="logout"
            class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold"
          >
            Log Out
          </button>
        </div>
      </div>

      <!-- STATS + ACTIVITY -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
          <h3 class="font-semibold text-lg">Stats</h3>
          <div class="flex justify-between">
            <span>🏆 Achievements</span>
            <strong>{{ achievementsUnlocked }}</strong>
          </div>
          <div class="flex justify-between">
            <span>⭐ Total XP</span>
            <strong>{{ totalXp }}</strong>
          </div>
        </div>

        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
          <h3 class="font-semibold text-lg">Recent Activity</h3>

          <div
            v-for="a in recentActivity"
            :key="a.id"
            class="border rounded-xl px-4 py-3 flex justify-between"
          >
            <div>
              <p class="font-medium">{{ a.achievement.name }}</p>
              <p class="text-sm text-gray-500">
                {{ new Date(a.completion_date).toLocaleDateString() }}
              </p>
            </div>
            <span class="text-green-600 font-semibold">
              +{{ a.achievement.xp }} XP
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- EDIT MODAL -->
    <div
      v-if="showEditModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 w-full max-w-md space-y-4">
        <h3 class="text-xl font-bold">Edit Profile</h3>

        <div class="flex justify-center">
          <img
            v-if="imagePreview"
            :src="imagePreview"
            class="w-24 h-24 rounded-full object-cover"
          />
        </div>

        <input type="file" @change="onImageChange" />

        <input
          v-model="editName"
          placeholder="Name"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700"
        />

        <textarea
          v-model="editBio"
          placeholder="Bio"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700"
        ></textarea>

        <p v-if="errorMsg" class="text-red-500 text-sm">
          {{ errorMsg }}
        </p>

        <div class="flex justify-end gap-2">
          <button @click="showEditModal = false">Cancel</button>
          <button
            @click="saveProfile"
            :disabled="saving || !editName.trim()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold disabled:opacity-50"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
