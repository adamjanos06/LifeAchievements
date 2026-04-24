<script setup>
import { useCatalogIndexPage } from "@/utils/composables/useCatalogIndexPage.js";
import MainNavbar from '@/components/layout/MainNavbar.vue';
import CategoryGrid from '@/components/CategoryGrid.vue';
import PaginationButtons from '@/components/PaginationButtons.vue';

const {
  paginatedCategories,
  isLoading,
  perPage,
  totalPages,
  currentPage,
  goToPage,
  goToCategory,
} = useCatalogIndexPage()
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
