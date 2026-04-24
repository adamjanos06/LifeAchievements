import { computed, onMounted, ref } from "vue"
import { fetchGoals, removeGoal } from "@/utils/api/goals.js"
import { markAchievementCompleted } from "@/utils/catalog.js"

export function useGoalsPage() {
  const goals = ref([])
  const isLoading = ref(false)
  const selectedGoal = ref(null)
  const showModal = ref(false)
  const unlockedBadge = ref(null)

  async function loadGoals() {
    try {
      isLoading.value = true
      goals.value = await fetchGoals()
    } catch (error) {
      console.error("Failed to load goals:", error)
    } finally {
      isLoading.value = false
    }
  }

  function openGoal(achievement) {
    selectedGoal.value = achievement
    showModal.value = true
  }

  function closeModal() {
    selectedGoal.value = null
    showModal.value = false
  }

  const completionButtonText = computed(() => {
    if (!selectedGoal.value) return "MARK AS COMPLETED"
    if (selectedGoal.value.completed) {
      return selectedGoal.value.repeatable ? "COMPLETE AGAIN" : "COMPLETED"
    }
    return "MARK AS COMPLETED"
  })

  const completionButtonDisabled = computed(() => {
    if (!selectedGoal.value) return false
    return selectedGoal.value.completed && !selectedGoal.value.repeatable
  })

  async function removeSelectedGoal(closeAfter = true) {
    if (!selectedGoal.value) return

    try {
      await removeGoal(selectedGoal.value.id)
      await loadGoals()
      if (closeAfter) {
        closeModal()
      }
    } catch (error) {
      console.error("Failed to remove goal:", error)
    }
  }

  async function markSelectedAsCompleted() {
    if (!selectedGoal.value) return
    if (!selectedGoal.value.repeatable && selectedGoal.value.completed) return

    try {
      const data = await markAchievementCompleted(selectedGoal.value.id)
      if (data.badge) {
        unlockedBadge.value = data.badge
      }

      if (selectedGoal.value.repeatable) {
        selectedGoal.value.completed = true
        selectedGoal.value.completions = (Number(selectedGoal.value.completions) || 0) + 1
      } else {
        selectedGoal.value.completed = true
      }

      await removeSelectedGoal()
    } catch (error) {
      console.error("Failed to mark achievement as completed:", error)
    }
  }

  const selectedIcon = computed(() => selectedGoal.value?.category?.icon || selectedGoal.value?.category_icon || "")

  onMounted(loadGoals)

  return {
    goals,
    isLoading,
    selectedGoal,
    showModal,
    unlockedBadge,
    completionButtonText,
    completionButtonDisabled,
    selectedIcon,
    openGoal,
    closeModal,
    removeSelectedGoal,
    markSelectedAsCompleted,
  }
}
