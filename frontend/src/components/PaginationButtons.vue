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
  activeButtonStyle: {
    type: Object,
    default: () => ({
      backgroundColor: "#1d4ed8"
    })
  },
  buttonClass: {
    type: String,
    default: "w-10 h-10"
  },
  containerClass: {
    type: String,
    default: "flex justify-center gap-4 mt-16"
  }
});

defineEmits(['page-change']);
</script>

<template>
  <div
    v-if="totalPages > 1"
    :class="containerClass"
  >
    <button
      v-for="page in totalPages"
      :key="page"
      @click="$emit('page-change', page)"
      :class="[
        buttonClass,
        'rounded-full flex items-center justify-center font-semibold transition',
        page === currentPage
          ? 'text-white'
          : 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-600'
      ]"
      :style="page === currentPage ? activeButtonStyle : {}"
    >
      {{ page }}
    </button>
  </div>
</template>
