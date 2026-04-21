<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import MainNavbar from '@/components/layout/MainNavbar.vue';
import CategoryGrid from '@/components/CategoryGrid.vue';
import { fetchCategories } from '@/utils/api/categories.js';

const router = useRouter();
const categories = ref([]);
const isLoading = ref(false);

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

onMounted(loadCategories);
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
      :categories="categories"
      :is-loading="isLoading"
      @category-click="goToCategory"
    />
  </div>
</template>
