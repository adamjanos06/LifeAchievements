<script setup>
import { ref, onMounted, computed } from "vue"
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import ProfileRecentActivity from "@/components/profile/ProfileRecentActivity.vue"
import ProfileBadges from "@/components/profile/ProfileBadges.vue"
import ProfileHeader from "@/components/profile/ProfileHeader.vue"
import axios from "axios"
import BadgePopup from "@/components/BadgePopup.vue"
import { fetchCurrentUser, checkProfileBadge, fetchUserBadges } from "@/utils/api/user.js"
import { fetchMyAchievements } from "@/utils/api/achievements.js"

const unlockedBadge = ref(null)
const router = useRouter()

const user = ref(null)
const imageUrl = ref(null)
const completedAchievements = ref([])
const earnedBadges = ref([])
const loading = ref(true)
const badgeShown = ref(false)

function goToMyAchievements() {
  router.push("/achievements")
}

async function loadUser() {
  try {
    user.value = await fetchCurrentUser()

    // Check for profile visited badge
    await checkProfileBadgeVisited()

    if (user.value?.image) {
      const filename = user.value.image.split("/").pop()
      imageUrl.value = `http://backend.vm1.test/api/avatar/${filename}`
    } else {
      imageUrl.value = null
    }
  } catch (error) {
    console.error("Failed to load user:", error)
  }
}

async function checkProfileBadgeVisited() {
  try {
    const data = await checkProfileBadge()

    if (data.badge && !badgeShown.value) {
      badgeShown.value = true
      setTimeout(() => {
        unlockedBadge.value = data.badge
      }, 300)
    }
  } catch (err) {
    console.error("Error checking profile badge:", err)
  }
}

async function loadCompletedAchievements() {
  try {
    completedAchievements.value = await fetchMyAchievements()
  } catch (error) {
    console.error("Failed to load achievements:", error)
  }
}

async function loadEarnedBadges() {
  try {
    earnedBadges.value = await fetchUserBadges()
  } catch (error) {
    console.error("Failed to load badges:", error)
  }
}

onMounted(async () => {
  try {
    await Promise.all([loadUser(), loadCompletedAchievements(), loadEarnedBadges()])
  } finally {
    loading.value = false
  }
})


const achievementsUnlocked = computed(() => completedAchievements.value.length)
const totalXp = computed(() => user.value?.xp ?? 0)


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
  editName.value = user.value?.name ?? ""
  editBio.value = user.value?.bio ?? ""
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

    if (user.value?.image) {
      const filename = user.value.image.split("/").pop()
      imageUrl.value = `http://backend.vm1.test/api/avatar/${filename}`
    } else {
      imageUrl.value = null
    }

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

    <div v-else-if="!user" class="text-center text-gray-500">You need to log in.</div>

    <div v-else class="space-y-8">
      <ProfileHeader 
        :user="user" 
        :imageUrl="imageUrl"
        @edit="openEditModal"
        @logout="logout"
      />

      <!-- BIO -->
      <div v-if="user.bio" class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h3 class="text-lg font-semibold mb-2">About</h3>
        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
          {{ user.bio }}
        </p>
      </div>
      <!-- STATS + ACTIVITY -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
          <h3 class="font-semibold text-lg">Stats</h3>
          <ProfileBadges />
          <div
            @click="goToMyAchievements"
            class="flex justify-between hover:text-blue-600 dark:hover:text-cyan-400 cursor-pointer transition"
          >
            <span>🏆 Achievements</span>
            <strong>{{ achievementsUnlocked }}</strong>
          </div>

          <div class="flex justify-between">
            <span>⭐ Total XP</span>
            <strong>{{ totalXp }}</strong>
          </div>
          <div class="flex justify-between">
            <span>🔥 Favorite Category</span>
            <strong>
              {{ user.favorite_category ?? "None" }}
            </strong>
          </div>
          <div class="flex justify-between">
            <span>📅 Member Since</span>
            <strong>
              {{ new Date(user.created_at).toLocaleDateString() }}
            </strong>
          </div>
        </div>
        <!-- EDIT MODAL -->
        <div
          v-if="showEditModal"
          class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
          <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 w-full max-w-md space-y-4"
          >
            <h3 class="text-xl font-bold">Edit Profile</h3>

            <div class="flex justify-center">
              <img
                v-if="imagePreview"
                :src="imagePreview"
                class="w-24 h-24 rounded-full object-cover"
              />
            </div>

            <input
              ref="fileInput"
              type="file"
              class="hidden"
              accept="image/*"
              @change="onImageChange"
            />

            <div
              @click="$refs.fileInput.click()"
              class="cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
            >
              <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                Click to upload a profile picture
              </p>

              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                PNG or JPG up to 5MB
              </p>
            </div>

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
        <div class="md:col-span-2">
          <ProfileRecentActivity
            :completedAchievements="completedAchievements"
            :earnedBadges="earnedBadges"
          />
        </div>
      </div>
    </div>
  </div>
  <BadgePopup v-if="unlockedBadge" :badge="unlockedBadge" @close="unlockedBadge = null" />
</template>
