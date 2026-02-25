<script setup>
import { ref, onMounted, computed } from "vue"
import { useRoute, useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import { isDark } from "@/utils/theme"

const route = useRoute()
const router = useRouter()
const categoryId = Number(route.params.id)

const categories = ref([])
const achievements = ref([])

const selected = ref(null)
const showModal = ref(false)

const currentPage = ref(1)
const perPage = 9

const searchQuery = ref("")

function isLoggedIn() {
  return !!localStorage.getItem("token");
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
  achievements.value = json.data;
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
  Math.min(2, Math.ceil(searched.value.length / perPage))
)

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return searched.value.slice(start, start + perPage)
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

/* ---------------- ACTIONS ---------------- */

async function markAsCompleted() {
  if (!selected.value || selected.value.completed) return;

  await fetch(
    `http://backend.vm1.test/api/achievements/${selected.value.id}/complete`,
    {
      method: "POST",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    },
  );

  // update modal
  selected.value.completed = true;

  // update main achievements array
  const idx = achievements.value.findIndex(
    a => a.id === selected.value.id
  );
  if (idx !== -1) {
    achievements.value[idx].completed = true;
  }
}

/* ---------------- LIFECYCLE ---------------- */

onMounted(() => {
  loadCategories()
  loadAchievements()
})
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      {{ categoryName }}
    </h2>

    <div class="flex justify-center mb-10">
      <input
        v-model="searchQuery"
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
    <div v-if="totalPages > 1" class="flex justify-center gap-4 mt-16">
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
    <div class="flex justify-center mt-12">
      <button
        @click="goBackToCategories"
        class="px-8 py-3 text-white font-semibold rounded-xl
        transition cursor-pointer hover:sclae-105"
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

        <div class="w-full mt-3">
          <button
            v-if="selected?.completed"
            disabled
            class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold cursor-default
            border-2 border-green-400 dark:border-green-300 shadow-md dark:shadow-[0_0_15px_rgba(34,197,94,0.6)]"
          >
            COMPLETED
          </button>

          <button
            v-else
            @click="markAsCompleted"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white
            py-2 rounded-lg font-semibold transition cursor-pointer"
          >
            MARK AS COMPLETED
          </button>
        </div>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selected?.xp }} XP</p>
        </div>
      </div>
    </div>
  </div>
</template>
