<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import AchievementGrid from "@/components/AchievementGrid.vue";
import PaginationButtons from "@/components/PaginationButtons.vue";
import { fetchGoals } from "@/utils/api/goals.js"

const router = useRouter()
const goals = ref([])
const isLoading = ref(false)
const currentPage = ref(1);
const perPage = 9;

async function loadGoals() {
  try {
    isLoading.value = true;
    goals.value = await fetchGoals();
  } catch (error) {
    console.error("Failed to load goals:", error);
  } finally {
    isLoading.value = false;
  }
}

function openGoal(a) {
  router.push(`/catalog/${a.category_id}?open=${a.id}`);
}

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

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14 text-gray-900 dark:text-gray-100 transition-colors">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      GOALS
    </h2>

    <AchievementGrid
      :achievements="paginatedGoals"
      :is-loading="isLoading"
      :show-completion-indicators="false"
      :clickable="true"
      empty-message="You haven't set any achievements as goals yet."
      @achievement-click="openGoal"
    />

    <PaginationButtons
      :total-pages="totalPages"
      :current-page="currentPage"
      @page-change="goToPage"
    />

  </div>
</template>