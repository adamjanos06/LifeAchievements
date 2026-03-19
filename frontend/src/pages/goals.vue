<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const router = useRouter()

const goals = ref([])

const currentPage = ref(1);
const perPage = 9;

/* -------- LOAD DATA -------- */

async function loadGoals() {
  const res = await fetch("http://backend.vm1.test/api/goals", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  });

  const json = await res.json()
  goals.value = json.data ?? []
}

/* -------- NAVIGATION -------- */

function openGoal(a) {
  router.push(`/catalog/${a.category_id}?open=${a.id}`);
}

/* -------- PAGINATION -------- */

const totalPages = computed(() => {
  return Math.max(1, Math.ceil(goals.value.length / perPage));
});

const paginatedGoals = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return goals.value.slice(start, start + perPage);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

onMounted(loadGoals);
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14 dark:text-gray-100
           transition-colors">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      GOALS
    </h2>

    <!-- EMPTY STATE -->
    <div
      v-if="goals.length === 0"
      class="text-center text-gray-500 dark:text-gray-400 text-lg"
    >
      You haven't set any achievements as goals yet.
    </div>

    <!-- GRID -->
    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
             gap-x-6 gap-y-6
             sm:gap-x-10 sm:gap-y-10
             lg:gap-x-14 lg:gap-y-12"
    >
      <div
        v-for="a in paginatedGoals"
        :key="a.id"
        @click="openGoal(a)"
        class="relative border border-gray-200 dark:border-gray-700
               rounded-2xl px-7 py-6 bg-white dark:bg-gray-800
               flex gap-5 transition-colors
               cursor-pointer hover:shadow-lg
               dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.18)]"
      >
        <div class="w-16 h-16 rounded-full flex items-center justify-center">
          <img
            v-if="a.category?.icon"
            :src="a.category.icon"
            class="w-14 h-14 object-contain"
          />
        </div>

        <!-- TEXT -->
        <div>
          <h3 class="font-semibold text-lg mb-1">
            {{ a.name }}
          </h3>
          <p class="text-sm text-gray-600 dark:text-gray-400 leading-snug">
            {{ a.description }}
          </p>
        </div>
      </div>
    </div>

    <!-- PAGINATION -->
    <div
      v-if="totalPages > 1"
      class="flex justify-center gap-4 mt-16"
    >
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

  </div>
</template>