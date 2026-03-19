<script setup>
import { ref, onMounted, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import { isDark } from "@/utils/theme"
import BadgePopup from "@/components/BadgePopup.vue"
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
const perPage = 9

const searchQuery = ref("")

function isLoggedIn() {
  return !!localStorage.getItem("token");
}

function isGoal(achievementId) {
  return goals.value.some(g => g.id === achievementId)
}

function goBackToCategories() {
  router.push("/catalog")
}

/* ---------------- DATA LOAD ---------------- */

async function loadCategories() {
  const res = await fetch("http://backend.vm1.test/api/categories")
  const json = await res.json()
  categories.value = json.data
}

async function loadAchievements() {
  const token = localStorage.getItem("token");

  const res = await fetch("http://backend.vm1.test/api/achievements", {
    headers: token ? { Authorization: `Bearer ${token}` } : {}
  });

  const json = await res.json();
  achievements.value = (json.data || []).map(a => ({
    ...a,
    repeatable: a.repeatable ?? false,
    completions: Number(a.completions) || 0,
  }));
}

async function loadGoals() {
  if (!isLoggedIn()) return
  
  const res = await fetch("http://backend.vm1.test/api/goals", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })
  const json = await res.json();
  goals.value = json.data;
}

/* ---------------- FILTER (FIX!!) ---------------- */

const filtered = computed(() =>
  achievements.value.filter(
    a => Number(a.category_id) === categoryId
  )
)

const searched = computed(() => {
  if (!searchQuery.value.trim()) return filtered.value

  const q = searchQuery.value.toLowerCase()

  return filtered.value.filter(a =>
    a.name.toLowerCase().includes(q) ||
    a.description.toLowerCase().includes(q)
  )
})

/* ---------------- UI HELPERS ---------------- */

const categoryName = computed(() => {
  const cat = categories.value.find(c => c.id === categoryId)
  return cat ? cat.name.toUpperCase() : ""
})

const icon = computed(() => {
  const cat = categories.value.find(c => c.id === categoryId)
  return cat ? cat.icon : ""
})

const categoryColor = computed(() => {
  const cat = categories.value.find(c => c.id === categoryId)

  if (isDark.value && categoryId === 8) return "#3b82f6"

  return cat?.color ? `#${cat.color}` : "#3b82f6"
})

const totalPages = computed(() =>
  Math.max(1, Math.ceil(searched.value.length / perPage))
)

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return searched.value.slice(start, start + perPage)
})

const completionButtonText = computed(() => {
  if (!selected.value) return 'MARK AS COMPLETED'
  if (selected.value.completed) {
    return selected.value.repeatable ? 'COMPLETE AGAIN' : 'COMPLETED'
  }
  return 'MARK AS COMPLETED'
})

const completionButtonDisabled = computed(() => {
  if (!selected.value) return false
  return selected.value.completed && !selected.value.repeatable
})

function goToPage(page) {
  currentPage.value = page
}

/* ---------------- MODAL ---------------- */

function openModal(a) {
  selected.value = a
  showModal.value = true
}

function closeModal() {
  selected.value = null
  showModal.value = false
}

/* ---------------- GOALS ---------------- */

async function saveGoal() {
  if (!selected.value) return

  await fetch(
    `http://backend.vm1.test/api/goals/${selected.value.id}`,
    {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`
      }
    }
  )
  await loadGoals()
}

async function removeGoal() {
  if (!selected.value) return

  await fetch(
    `http://backend.vm1.test/api/goals/${selected.value.id}`,
    {
      method: "DELETE",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`
      }
    }
  )
  await loadGoals()
}

async function toggleGoal() {

  if (!selected.value) return

  if (isGoal(selected.value.id)) {
    await removeGoal()
  }
  else {
    await saveGoal()
  }
}

/* ---------------- ACTIONS ---------------- */

async function markAsCompleted() {
  if (!selected.value) return;

  if (!selected.value.repeatable && selected.value.completed) return;

  const res = await fetch(
    `http://backend.vm1.test/api/achievements/${selected.value.id}/complete`,
    {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );

  const data = await res.json();

  if (data.badge) {
    unlockedBadge.value = data.badge;
  }

  if (selected.value.repeatable) {
    selected.value.completed = true;
    selected.value.completions = (Number(selected.value.completions) || 0) + 1;
  }

  const idx = achievements.value.findIndex(
    a => a.id === selected.value.id
  );

  if (idx !== -1) {
    if (selected.value.repeatable) {
      achievements.value[idx].completions = selected.value.completions;
      achievements.value[idx].completed = true;
    } else {
      achievements.value[idx].completed = true;
    }
  }

  if (isGoal(selected.value.id)) {
    await removeGoal();
  }

  await loadAchievements();
}

/* ---------------- LIFECYCLE ---------------- */

onMounted(() => {
  loadCategories()
  loadAchievements()
  if (isLoggedIn()) {
    loadGoals()
  }
})
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-10
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-3xl font-bold tracking-wide mb-12">
      {{ categoryName }}
    </h2>

    <div class="flex justify-center mb-6">
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


    <!-- ACHIEVEMENT GRID -->
    <div
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
             gap-x-6 gap-y-6
             sm:gap-x-10 sm:gap-y-10
             lg:gap-x-14 lg:gap-y-12"
    >
      <div
        v-for="a in paginatedAchievements"
        :key="a.id"
        @click="openModal(a)"
        class="relative flex gap-5 cursor-pointer
               border border-gray-200 dark:border-gray-700
               rounded-2xl px-7 py-6
               bg-white dark:bg-gray-800
               transition
               hover:shadow-lg
               dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.18)]"
      >
        <!-- COMPLETED CHECK -->
        <div
          v-if="a.completed"
          class="absolute top-3 right-3
                 w-7 h-7 rounded-full
                 bg-green-500 text-white
                 flex items-center justify-center"
        >
          ✓
        </div>

        <div class="w-16 h-16 rounded-full flex items-center justify-center">
          <img v-if="icon" :src="icon" class="w-20 h-20 object-contain" />
        </div>

        <div>
          <h3 class="font-semibold text-lg mb-1">
            {{ a.name }}
          </h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ a.description }}
          </p>
        </div>
      </div>
    </div>

    <!-- PAGINATION -->
    <div v-if="totalPages > 1" class="flex justify-center gap-4 mt-8">
      <button
        v-for="page in totalPages"
        :key="page"
        @click="goToPage(page)"
        class="w-10 h-10 rounded-full
               flex items-center justify-center
               font-semibold transition"
        :class="page === currentPage
          ? 'bg-blue-700 text-white'
          : 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-600'"
      >
        {{ page }}
      </button>
    </div>

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
      <button @click="closeModal" class="absolute top-4 right-4 text-2xl">
        ×
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
            @click="toggleGoal"
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
