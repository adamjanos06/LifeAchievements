<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import ProfileRecentActivity from "@/components/profile/ProfileRecentActivity.vue"
import ProfileHeader from "@/components/profile/ProfileHeader.vue"
import ProfileEditModal from "@/components/profile/ProfileEditModal.vue"
import ProfileStats from "@/components/profile/ProfileStats.vue"
import ProfileBio from "@/components/profile/ProfileBio.vue"
import ProfileBadgeModal from "@/components/profile/ProfileBadgeModal.vue"
import BadgePopup from "@/components/BadgePopup.vue"
import { useProfile } from "@/utils/composables/useProfile.js"

const router = useRouter()

const {
  unlockedBadge,
  user,
  imageUrl,
  completedAchievements,
  earnedBadges,
  loading,
  achievementsUnlocked,
  totalXp,
  initializeProfile
} = useProfile()

const showEditModal = ref(false)
const showBadgeModal = ref(false)

function openBadgeModal() {
  showBadgeModal.value = true
}

function closeBadgeModal() {
  showBadgeModal.value = false
}

function goToMyAchievements() {
  router.push("/achievements")
}

function logout() {
  localStorage.removeItem("token")
  router.push("/")
}

function openEditModal() {
  showEditModal.value = true
}

function handleModalClose() {
  showEditModal.value = false
}

function handleModalSave(data) {
  user.value = data.user
  imageUrl.value = data.imageUrl
  showEditModal.value = false
}

import { onMounted } from "vue"

onMounted(() => {
  initializeProfile()
})
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
      <ProfileBio :bio="user.bio" />

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <ProfileStats
          :user="user"
          :achievementsUnlocked="achievementsUnlocked"
          :totalXp="totalXp"
          @achievements-click="goToMyAchievements"
          @badges-click="openBadgeModal"
        />
        <ProfileEditModal
          :show="showEditModal"
          :user="user"
          :imageUrl="imageUrl"
          @close="handleModalClose"
          @save="handleModalSave"
        />
        <div class="md:col-span-2">
          <ProfileRecentActivity
            :completedAchievements="completedAchievements"
            :earnedBadges="earnedBadges"
          />
        </div>
      </div>
      <ProfileBadgeModal v-if="showBadgeModal" @close="closeBadgeModal" />
    </div>
  </div>
  <BadgePopup v-if="unlockedBadge" :badge="unlockedBadge" @close="unlockedBadge = null" />
</template>
