<script setup>
import { ref, onMounted, computed } from "vue";
import MainNavbar from "@/components/layout/MainNavbar.vue";
import AchievementGrid from "@/components/AchievementGrid.vue";
import PaginationButtons from "@/components/PaginationButtons.vue";
import { fetchMyAchievements } from "@/utils/api/achievements.js";

const achievements = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const perPage = 9;

async function loadMyAchievements() {
  try {
    isLoading.value = true;
    achievements.value = await fetchMyAchievements();
  } catch (error) {
    console.error("Failed to load achievements:", error);
  } finally {
    isLoading.value = false;
  }
}

const totalPages = computed(() => {
  return Math.max(1, Math.ceil(achievements.value.length / perPage));
});

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return achievements.value.slice(start, start + perPage);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

onMounted(loadMyAchievements);
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14 text-gray-900 dark:text-gray-100 transition-colors">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      MY ACHIEVEMENTS
    </h2>

    <AchievementGrid
      :achievements="paginatedAchievements"
      :is-loading="isLoading"
      :show-completion-indicators="true"
      :clickable="false"
      empty-message="You haven't completed any achievements yet."
    />

    <PaginationButtons
      :total-pages="totalPages"
      :current-page="currentPage"
      @page-change="goToPage"
    />

  </div>
</template>
