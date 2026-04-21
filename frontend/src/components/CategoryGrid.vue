<script setup>
import CategoryCard from './CategoryCard.vue';

defineProps({
  categories: {
    type: Array,
    required: true
  },
  isLoading: {
    type: Boolean,
    default: false
  },
  emptyMessage: {
    type: String,
    default: "No categories found"
  }
});

defineEmits(['category-click']);
</script>

<template>
  <!-- Empty State -->
  <div
    v-if="categories.length === 0 && !isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    {{ emptyMessage }}
  </div>

  <!-- Loading State -->
  <div
    v-if="isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    Loading categories...
  </div>

  <!-- Categories Grid -->
  <div
    v-else-if="categories.length > 0"
    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
           gap-x-6 gap-y-6
           sm:gap-x-10 sm:gap-y-10
           lg:gap-x-14 lg:gap-y-12"
  >
    <CategoryCard
      v-for="category in categories"
      :key="category.id"
      :category="category"
      @click="$emit('category-click', category.id)"
    />
  </div>
</template>
