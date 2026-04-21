<script setup>
defineProps({
  totalPages: {
    type: Number,
    required: true,
    validator: (val) => val > 0
  },
  currentPage: {
    type: Number,
    required: true
  },
  buttonClass: {
    type: String,
    default: "w-10 h-10"
  }
});

defineEmits(['page-change']);
</script>

<template>
  <div
    v-if="totalPages > 1"
    class="flex justify-center gap-4 mt-16"
  >
    <button
      v-for="page in totalPages"
      :key="page"
      @click="$emit('page-change', page)"
      :class="[
        buttonClass,
        'rounded-full flex items-center justify-center font-semibold transition',
        page === currentPage
          ? 'bg-blue-700 text-white'
          : 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-600'
      ]"
    >
      {{ page }}
    </button>
  </div>
</template>
