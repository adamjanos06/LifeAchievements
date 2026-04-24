<script setup>
import { computed, onMounted, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import AchievementBrowserSection from "@/components/achievements/AchievementBrowserSection.vue"
import AchievementDetailsModal from "@/components/achievements/AchievementDetailsModal.vue"
import { isDark } from "@/utils/theme"
import BadgePopup from "@/components/BadgePopup.vue"
import { fetchCategories } from "@/utils/api/categories.js"
import { fetchAchievements } from "@/utils/api/achievements.js"
import { fetchGoals, addGoal, removeGoal } from "@/utils/api/goals.js"
import { loadConfetti, fireConfetti } from "@/utils/confetti.js"
import { getSafeColor, markAchievementCompleted } from "@/utils/catalog.js"

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
  return goals.value.some(g => Number(g.id) === Number(achievementId))
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

const category = computed(() => categories.value.find(c => c.id === categoryId) ?? null)

const filteredAchievements = computed(() => achievements.value.filter(a => Number(a.category_id) === categoryId))

const categoryName = computed(() => {
  return category.value ? category.value.name.toUpperCase() : ""
})

const icon = computed(() => {
  return category.value ? category.value.icon : ""
})

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

function openModal(a) {
  selected.value = a
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
  }
  else {
    await saveGoalData()
  }
}

async function markAsCompleted() {
  if (!selected.value) return

  const wasCompleted = selected.value.completed

  if (!selected.value.repeatable && selected.value.completed) return;

  try {
    const data = await markAchievementCompleted(selected.value.id)

    if (data.badge) {
      unlockedBadge.value = data.badge
    }

    if (selected.value.repeatable) {
      selected.value.completed = true
      selected.value.completions = (Number(selected.value.completions) || 0) + 1
    }

    const idx = achievements.value.findIndex(a => a.id === selected.value.id)

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
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-4
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-3xl font-bold tracking-wide mb-4">
      {{ categoryName }}
    </h2>

    <AchievementBrowserSection
      :achievements="filteredAchievements"
      :is-loading="isLoading"
      :show-completion-indicators="true"
      :clickable="true"
      :large-text="true"
      :category-icon="icon"
      card-height-class="h-[8.75rem] max-h-[8.75rem] sm:h-[9.5rem] sm:max-h-[9.5rem] lg:h-[9.5rem] lg:max-h-[9.5rem]"
      grid-gap="gap-3 sm:gap-5 lg:gap-6"
      pagination-container-class="flex justify-center gap-4 mt-2"
      :pagination-active-button-style="{
        backgroundColor: categoryColor,
        boxShadow: `0 0 20px ${categoryColor}66`
      }"
      content-min-height-class="min-h-[32rem] sm:min-h-[35.25rem] lg:min-h-[35.75rem]"
      searchable
      search-placeholder="Search achievements..."
      responsive-page-size
      empty-message="No achievements found in this category."
      @select="openModal"
    />

    <!-- BACK BUTTON -->
    <div class="flex justify-center mt-2">
      <button
        @click="goBackToCategories"
        class="px-8 py-3 text-white font-semibold rounded-xl
        transition transform duration-300 cursor-pointer hover:scale-120"
        :style="{
          backgroundColor: categoryColor,
          boxShadow: `0 0 20px ${categoryColor}66`
        }"
      >
        ← Back to Categories
      </button>
    </div>
  </div>

  <!-- MODAL -->
  <AchievementDetailsModal
    :open="showModal"
    :achievement="selected"
    :icon="isLoggedIn() ? icon : ''"
    :show-details="isLoggedIn()"
    @close="closeModal"
  >
    <template v-if="!isLoggedIn()">
      <div class="text-center space-y-4">
        <h2 class="text-xl font-bold">
          You must be logged in
        </h2>

        <RouterLink
          to="/login"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold"
        >
          Go to Login
        </RouterLink>
      </div>
    </template>

    <template v-else>
      <div class="w-full mt-3">
        <button
          v-if="selected?.completed && !selected?.repeatable"
          disabled
          class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold cursor-default border-2 border-green-400 dark:border-green-300 shadow-md dark:shadow-[0_0_15px_rgba(34,197,94,0.6)]"
        >
          COMPLETED
        </button>

        <button
          v-else
          @click="markAsCompleted"
          :disabled="completionButtonDisabled"
          class="w-full bg-blue-600 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold transition cursor-pointer border-2 border-blue-400 dark:border-blue-300 shadow-md dark:shadow-[0_0_15px_rgba(59,130,246,0.6)]"
        >
          {{ completionButtonText }}
        </button>

        <button
          v-if="!selected?.completed"
          @click="toggleGoalData"
          :class="isGoal(selected.id)
            ? 'bg-transparent text-amber-600 border-2 border-amber-500'
            : 'bg-amber-600 hover:bg-amber-800 text-white border-2 border-amber-400 shadow-md dark:shadow-[0_0_15px_rgba(251,191,36,0.6)]'"
          class="w-full mt-3 py-2 rounded-lg font-semibold transition cursor-pointer"
        >
          {{ isGoal(selected.id) ? "REMOVE GOAL" : "MARK AS GOAL" }}
        </button>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selected?.xp }} XP</p>
        </div>
      </div>
    </template>
  </AchievementDetailsModal>
  <BadgePopup
    v-if="unlockedBadge"
    :badge="unlockedBadge"
    @close="unlockedBadge = null"
  />
</template>
