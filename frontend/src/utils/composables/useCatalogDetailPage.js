import { computed, onMounted, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import { isDark } from "@/utils/theme"
import { fetchCategories } from "@/utils/api/categories.js"
import { fetchAchievements } from "@/utils/api/achievements.js"
import { fetchGoals, addGoal, removeGoal } from "@/utils/api/goals.js"
import { loadConfetti, fireConfetti } from "@/utils/confetti.js"
import { getSafeColor, markAchievementCompleted } from "@/utils/catalog.js"

export function useCatalogDetailPage() {
  const route = useRoute()
  const router = useRouter()
  const categoryId = Number(route.params.id)

  const unlockedBadge = ref(null)
  const categories = ref([])
  const achievements = ref([])
  const goals = ref([])
  const selected = ref(null)
  const showModal = ref(false)
  const isLoading = ref(true)

  let confettiFunc = null

  function isLoggedIn() {
    return !!localStorage.getItem("token")
  }

  function isGoal(achievementId) {
    return goals.value.some((g) => Number(g.id) === Number(achievementId))
  }

  function goBackToCategories() {
    router.push("/catalog")
  }

  async function loadCategoriesData() {
    try {
      categories.value = await fetchCategories()
    } catch (error) {
      console.error("Failed to load categories:", error)
    }
  }

  async function loadAchievementsData() {
    try {
      achievements.value = await fetchAchievements()
    } catch (error) {
      console.error("Failed to load achievements:", error)
    }
  }

  async function loadGoalsData() {
    if (!isLoggedIn()) return

    try {
      goals.value = await fetchGoals()
    } catch (error) {
      console.error("Failed to load goals:", error)
    }
  }

  const category = computed(() => categories.value.find((c) => c.id === categoryId) ?? null)
  const filteredAchievements = computed(() => achievements.value.filter((a) => Number(a.category_id) === categoryId))
  const categoryName = computed(() => (category.value ? category.value.name.toUpperCase() : ""))
  const icon = computed(() => (category.value ? category.value.icon : ""))

  const categoryColor = computed(() => {
    if (isDark.value && categoryId === 8) return "#3b82f6"
    return getSafeColor(category.value?.color)
  })

  const completionButtonText = computed(() => {
    if (!selected.value) return "MARK AS COMPLETED"
    if (selected.value.completed) {
      return selected.value.repeatable ? "COMPLETE AGAIN" : "COMPLETED"
    }
    return "MARK AS COMPLETED"
  })

  const completionButtonDisabled = computed(() => {
    if (!selected.value) return false
    return selected.value.completed && !selected.value.repeatable
  })

  function openModal(achievement) {
    selected.value = achievement
    showModal.value = true
  }

  function closeModal() {
    selected.value = null
    showModal.value = false
  }

  async function saveGoalData() {
    if (!selected.value) return

    try {
      const data = await addGoal(selected.value.id)
      if (data.badge) {
        unlockedBadge.value = data.badge
      }
      await loadGoalsData()
    } catch (error) {
      console.error("Failed to save goal:", error)
    }
  }

  async function removeGoalData() {
    if (!selected.value) return

    try {
      await removeGoal(selected.value.id)
      await loadGoalsData()
    } catch (error) {
      console.error("Failed to remove goal:", error)
    }
  }

  async function toggleGoalData() {
    if (!selected.value) return

    if (isGoal(selected.value.id)) {
      await removeGoalData()
    } else {
      await saveGoalData()
    }
  }

  async function markAsCompleted() {
    if (!selected.value) return

    const wasCompleted = selected.value.completed

    if (!selected.value.repeatable && selected.value.completed) return

    try {
      const data = await markAchievementCompleted(selected.value.id)

      if (data.badge) {
        unlockedBadge.value = data.badge
      }

      if (selected.value.repeatable) {
        selected.value.completed = true
        selected.value.completions = (Number(selected.value.completions) || 0) + 1
      }

      const idx = achievements.value.findIndex((a) => a.id === selected.value.id)

      if (idx !== -1) {
        if (selected.value.repeatable) {
          achievements.value[idx].completions = selected.value.completions
          achievements.value[idx].completed = true
        } else {
          achievements.value[idx].completed = true
        }
      }

      if (isGoal(selected.value.id)) {
        await removeGoalData()
      }

      await loadAchievementsData()

      if (!wasCompleted && confettiFunc) {
        fireConfetti(confettiFunc)
      }
    } catch (error) {
      console.error("Failed to mark achievement as completed:", error)
    }
  }

  onMounted(async () => {
    try {
      await Promise.all([loadCategoriesData(), loadAchievementsData()])
      confettiFunc = await loadConfetti()

      if (isLoggedIn()) {
        await loadGoalsData()
      }
    } finally {
      isLoading.value = false
    }
  })

  return {
    unlockedBadge,
    selected,
    showModal,
    isLoading,
    filteredAchievements,
    categoryName,
    icon,
    categoryColor,
    completionButtonText,
    completionButtonDisabled,
    isLoggedIn,
    isGoal,
    goBackToCategories,
    openModal,
    closeModal,
    toggleGoalData,
    markAsCompleted,
  }
}
