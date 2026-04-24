import { computed, onMounted, ref } from "vue"
import { fetchMyAchievements } from "@/utils/api/achievements.js"

export function useAchievementsPage() {
  const achievements = ref([])
  const isLoading = ref(false)
  const selectedAchievement = ref(null)
  const showModal = ref(false)

  async function loadMyAchievements() {
    try {
      isLoading.value = true
      achievements.value = await fetchMyAchievements()
    } catch (error) {
      console.error("Failed to load achievements:", error)
    } finally {
      isLoading.value = false
    }
  }

  function openAchievement(achievement) {
    selectedAchievement.value = achievement
    showModal.value = true
  }

  const selectedIcon = computed(() => selectedAchievement.value?.category?.icon || selectedAchievement.value?.category_icon || "")

  onMounted(loadMyAchievements)

  return {
    achievements,
    isLoading,
    selectedAchievement,
    showModal,
    selectedIcon,
    openAchievement,
  }
}
