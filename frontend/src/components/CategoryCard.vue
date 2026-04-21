<script setup>
defineProps({
  category: {
    type: Object,
    required: true,
    validator: (obj) => obj.id && obj.name
  }
});

defineEmits(['click']);
</script>

<template>
  <div
    @click="$emit('click')"
    class="flex items-center gap-5
           border border-gray-200 dark:border-gray-700
           rounded-2xl px-7 py-6 cursor-pointer
           bg-white dark:bg-gray-800
           transition
           hover:shadow-lg
           dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.18)]"
  >
    <!-- Icon / First Letter -->
    <div class="w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0">
      <img
        v-if="category.icon"
        :src="category.icon"
        :alt="`${category.name} Icon`"
        class="w-20 h-20 object-contain"
      />
      <span
        v-else
        class="text-lg font-bold
               text-gray-600 dark:text-gray-300"
      >
        {{ category.name.charAt(0) }}
      </span>
    </div>

    <!-- Category Name -->
    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
      {{ category.name }}
    </span>
  </div>
</template>
