<script setup>
import CategoryCard from './CategoryCard.vue';
import { computed } from 'vue';

const props = defineProps({
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
  },
  fillToCount: {
    type: Number,
    default: 0
  }
});

const fillerCount = computed(() => {
  return Math.max(0, props.fillToCount - props.categories.length);
});

defineEmits(['category-click']);
</script>

<template>
  <div
    v-if="categories.length === 0 && !isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    {{ emptyMessage }}
  </div>

  <div
    v-if="isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    Loading categories...
  </div>

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

    <div
      v-for="n in fillerCount"
      :key="`filler-${n}`"
      class="invisible pointer-events-none"
    >
      <div
        class="flex items-center gap-5
               border border-gray-200 dark:border-gray-700
               rounded-2xl px-7 py-6"
      >
        <div class="w-16 h-16 rounded-full flex-shrink-0"></div>
        <span class="text-lg font-semibold">placeholder</span>
      </div>
    </div>
  </div>
</template>
