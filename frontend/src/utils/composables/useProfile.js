import { ref, computed } from "vue"
import { fetchCurrentUser, checkProfileBadge, fetchUserBadges } from "@/utils/api/user.js"
import { fetchMyAchievements } from "@/utils/api/achievements.js"

export function useProfile() {
  const unlockedBadge = ref(null)
  const user = ref(null)
  const imageUrl = ref(null)
  const completedAchievements = ref([])
  const earnedBadges = ref([])
  const loading = ref(true)
  const badgeShown = ref(false)

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

  async function initializeProfile() {
    try {
      await Promise.all([
        loadUser(),
        loadCompletedAchievements(),
        loadEarnedBadges()
      ])
    } finally {
      loading.value = false
    }
  }

  const achievementsUnlocked = computed(() => completedAchievements.value.length)
  const totalXp = computed(() => user.value?.xp ?? 0)

  return {
    // State
    unlockedBadge,
    user,
    imageUrl,
    completedAchievements,
    earnedBadges,
    loading,
    badgeShown,

    // Methods
    initializeProfile,

    // Computed
    achievementsUnlocked,
    totalXp
  }
}
