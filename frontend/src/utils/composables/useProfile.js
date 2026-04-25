import { ref, computed, watch } from "vue"
import { fetchCurrentUser, checkProfileBadge, fetchUserBadges } from "@/utils/api/user.js"
import { fetchMyAchievements } from "@/utils/api/achievements.js"
import { useBadgeStore } from "@/stores/BadgeStore.mjs"

export function useProfile() {
  const unlockedBadge = ref(null)
  const user = ref(null)
  const imageUrl = ref(null)
  const completedAchievements = ref([])
  const earnedBadges = ref([])
  const loading = ref(true)
  const badgeShown = ref(false)
  const badgeStore = useBadgeStore()

  watch(() => badgeStore.recentlyEarnedBadges, (newBadges) => {
    for (const badge of newBadges) {
      if (!earnedBadges.value.some(b => b.id === badge.id)) {
        earnedBadges.value.push(badge)
      }
    }
  }, { deep: true })

  async function loadUser() {
    try {
      user.value = await fetchCurrentUser()

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
        
        earnedBadges.value.push(data.badge)
        
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
    unlockedBadge,
    user,
    imageUrl,
    completedAchievements,
    earnedBadges,
    loading,
    badgeShown,

    initializeProfile,

    achievementsUnlocked,
    totalXp
  }
}
