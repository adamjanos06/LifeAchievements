<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import AchievementGrid from "@/components/AchievementGrid.vue"
import AchievementCard from "@/components/AchievementCard.vue"
import PaginationButtons from "@/components/PaginationButtons.vue"
import { isDark } from "@/utils/theme"
import BadgePopup from "@/components/BadgePopup.vue"
import { fetchCategories } from "@/utils/api/categories.js"
import { fetchAchievements } from "@/utils/api/achievements.js"
import { fetchGoals, addGoal, removeGoal } from "@/utils/api/goals.js"
import { loadConfetti, fireConfetti } from "@/utils/confetti.js"
import { getSafeColor, markAchievementCompleted } from "@/utils/catalog.js"
import { CircleX } from "@lucide/vue"

const route = useRoute()
const router = useRouter()
const categoryId = Number(route.params.id)

const unlockedBadge = ref(null)

const categories = ref([])
const achievements = ref([])
const goals = ref([])

const selected = ref(null)
const showModal = ref(false)

const currentPage = ref(1)
const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)
let handleResize = null

const searchQuery = ref("")

const perPage = computed(() => {
  if (windowWidth.value >= 1024) return 9
  if (windowWidth.value >= 640) return 6
  return 3
})

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

/* ---------------- FILTER & SEARCH ---------------- */

const filtered = computed(() => achievements.value.filter(a => Number(a.category_id) === categoryId))

const searched = computed(() => {
  if (!searchQuery.value.trim()) return filtered.value

  const q = searchQuery.value.toLowerCase()

  return filtered.value.filter(a =>
    a.name.toLowerCase().includes(q) ||
    a.description.toLowerCase().includes(q)
  )
})

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

const totalPages = computed(() => Math.max(1, Math.ceil(searched.value.length / perPage.value)))

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  return searched.value.slice(start, start + perPage.value)
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

function showCompletionIndicator(achievement) {
  return achievement.completed || Number(achievement.completions) > 0
}

function goToPage(page) {
  currentPage.value = page
}

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

function tryOpenFromQuery() {
  const openId = Number(route.query.open)

  if (!openId) return

  const found = achievements.value.find(a => a.id === openId)

  if (found) {
    openModal(found)
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
  handleResize = () => {
    windowWidth.value = window.innerWidth
    currentPage.value = 1
  }

  window.addEventListener("resize", handleResize)

  await Promise.all([loadCategoriesData(), loadAchievementsData()])

  confettiFunc = await loadConfetti()

  if (isLoggedIn()) {
    await loadGoalsData()
  }

  tryOpenFromQuery()
})

onBeforeUnmount(() => {
  if (handleResize) {
    window.removeEventListener("resize", handleResize)
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

    <div class="flex justify-center mb-4">
      <input
        v-model="searchQuery"
        @input="currentPage = 1"
        type="text"
        placeholder="Search achievements..."
        class="w-full max-w-md px-4 py-2
              rounded-xl border
              border-gray-300 dark:border-gray-600
              bg-white dark:bg-gray-800
              text-gray-900 dark:text-gray-100
              focus:outline-none focus:ring-2 focus:ring-blue-600"
      />
    </div>

    <div class="min-h-[420px]">
      <AchievementGrid
        :achievements="paginatedAchievements"
        grid-gap="gap-3 sm:gap-5 lg:gap-6"
        empty-message="No achievements found in this category."
        @achievement-click="openModal"
      >
        <template #achievement-card="{ achievement }">
          <AchievementCard
            :achievement="achievement"
            :show-completion-indicator="showCompletionIndicator(achievement)"
            :repeatable="achievement.repeatable"
            :completions="achievement.completions"
            :category-icon="icon"
            :emit-click="false"
          />
        </template>
      </AchievementGrid>
    </div>

    <!-- PAGINATION -->
    <PaginationButtons
      :total-pages="totalPages"
      :current-page="currentPage"
      container-class="flex justify-center gap-4 mt-8"
      :active-button-style="{
        backgroundColor: categoryColor,
        boxShadow: `0 0 20px ${categoryColor}66`
      }"
      @page-change="goToPage"
    />

    <!-- BACK BUTTON -->
    <div class="flex justify-center mt-8">
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
  <div
    v-if="showModal"
    class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
  >
    <div
      class="bg-white dark:bg-gray-800
             rounded-2xl p-8 w-full max-w-md relative mx-4
             text-gray-900 dark:text-gray-100
             transition-colors
             dark:shadow-[0_0_40px_rgba(255,255,255,0.25)]"
    >
      <button @click="closeModal" class="absolute top-4 right-4 text-2xl w-8 h-8">
        <CircleX />  
      </button>

      <div v-if="!isLoggedIn()" class="text-center space-y-4">
        <h2 class="text-xl font-bold">
          You must be logged in
        </h2>

        <RouterLink
          to="/login"
          class="inline-block bg-blue-600 hover:bg-blue-700
                 text-white px-4 py-2 rounded-lg font-semibold"
        >
          Go to Login
        </RouterLink>
      </div>

      <div v-else class="flex flex-col items-center text-center gap-4">
        <img v-if="icon" :src="icon" class="w-20 h-20 object-contain" />

        <h2 class="text-2xl font-bold">
          {{ selected?.name }}
        </h2>

        <p class="text-gray-600 dark:text-gray-400">
          {{ selected?.description }}
        </p>
        <p
          v-if="selected?.repeatable && selected?.completions"
          class="text-sm text-gray-500 dark:text-gray-400 mt-1"
        >
          Completed {{ selected.completions }} time<span v-if="selected.completions > 1">s</span>.
        </p>

        <div class="w-full mt-3">
          <!-- show disabled completed badge only for non-repeatable items -->
          <button
            v-if="selected?.completed && !selected?.repeatable"
            disabled
            class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold cursor-default
            border-2 border-green-400 dark:border-green-300 shadow-md dark:shadow-[0_0_15px_rgba(34,197,94,0.6)]"
          >
            COMPLETED
          </button>

          <!-- allow clicking for first-time or repeatable completions -->
          <button
            v-else
            @click="markAsCompleted"
            :disabled="completionButtonDisabled"
            class="w-full bg-blue-600 hover:bg-blue-800 text-white
            py-2 rounded-lg font-semibold transition cursor-pointer
            border-2 border-blue-400 dark:border-blue-300
            shadow-md dark:shadow-[0_0_15px_rgba(59,130,246,0.6)]"
          >
            {{ completionButtonText }}
          </button>

          <button
            v-if="!selected?.completed"
            @click="toggleGoalData"
            :class="isGoal(selected.id)
              ? 'bg-transparent text-amber-600 border-2 border-amber-500'
              : 'bg-amber-600 hover:bg-amber-800 text-white border-2 border-amber-400 shadow-md dark:shadow-[0_0_15px_rgba(251,191,36,0.6)]'
            "
            class="w-full my-5 py-2 rounded-lg font-semibold cursor-pointer transition"
          >
            {{ isGoal(selected.id)
                ? "REMOVE FROM GOALS"
                : "SAVE TO GOALS"
            }}
          </button>
        </div>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selected?.xp }} XP</p>
        </div>
      </div>
    </div>
  </div>
  <BadgePopup
    v-if="unlockedBadge"
    :badge="unlockedBadge"
    @close="unlockedBadge = null"
  />
</template>
