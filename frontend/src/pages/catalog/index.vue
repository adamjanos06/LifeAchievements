<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from "vue";
import { useRouter } from "vue-router";
import MainNavbar from '@/components/layout/MainNavbar.vue';
import CategoryGrid from '@/components/CategoryGrid.vue';
import PaginationButtons from '@/components/PaginationButtons.vue';
import { fetchCategories } from '@/utils/api/categories.js';

const router = useRouter();
const categories = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const currentColumns = ref(3);

function getColumnsByWidth(width) {
  if (width >= 1024) return 3;
  if (width >= 640) return 2;
  return 1;
}

function updateColumns() {
  currentColumns.value = getColumnsByWidth(window.innerWidth);
}

const perPage = computed(() => currentColumns.value * 3);

const totalPages = computed(() => {
  return Math.max(1, Math.ceil(categories.value.length / perPage.value));
});

const paginatedCategories = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  return categories.value.slice(start, start + perPage.value);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

async function loadCategories() {
  try {
    isLoading.value = true;
    categories.value = await fetchCategories();
  } catch (error) {
    console.error("Failed to load categories:", error);
  } finally {
    isLoading.value = false;
  }
}

function goToCategory(id) {
  router.push(`/catalog/${id}`);
}

watch([categories, perPage], () => {
  if (currentPage.value > totalPages.value) {
    currentPage.value = totalPages.value;
  }
});

onMounted(() => {
  updateColumns();
  window.addEventListener('resize', updateColumns);
  loadCategories();
});

onUnmounted(() => {
  window.removeEventListener('resize', updateColumns);
});
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-3xl font-bold tracking-wide mb-14">
      CATEGORIES
    </h2>

    <CategoryGrid
      :categories="paginatedCategories"
      :is-loading="isLoading"
      :fill-to-count="perPage"
      @category-click="goToCategory"
    />

    <PaginationButtons
      :total-pages="totalPages"
      :current-page="currentPage"
      @page-change="goToPage"
    />
  </div>
</template>
