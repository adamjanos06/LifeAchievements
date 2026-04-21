<script setup>
defineProps({
  achievement: {
    type: Object,
    required: true,
    validator: (obj) => obj.id && obj.name
  },
  showCompletionIndicator: {
    type: Boolean,
    default: false
  },
  completions: {
    type: Number,
    default: 0
  },
  repeatable: {
    type: Boolean,
    default: false
  },
  categoryIcon: {
    type: String,
    default: null
  },
  clickable: {
    type: Boolean,
    default: true
  }
});

defineEmits(['click']);
</script>

<template>
  <div
    @click="clickable && $emit('click')"
    :class="[
      'relative border border-gray-200 dark:border-gray-700 rounded-2xl px-7 py-6',
      'bg-white dark:bg-gray-800 flex gap-5 transition-colors',
      clickable ? 'cursor-pointer hover:shadow-lg dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.18)]' : ''
    ]"
  >
    <!-- COMPLETION INDICATOR -->
    <div v-if="showCompletionIndicator" class="absolute top-3 right-3">
      <template v-if="repeatable">
        <span
          class="w-7 h-7 rounded-full bg-blue-600 text-white
                 flex items-center justify-center text-sm font-semibold"
        >
          {{ completions }}
        </span>
      </template>
      <template v-else>
        <div
          class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center"
        >
          ✓
        </div>
      </template>
    </div>

    <!-- ICON -->
    <div v-if="categoryIcon" class="w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0">
      <img
        :src="categoryIcon"
        :alt="`${achievement.name} Icon`"
        class="w-14 h-14 object-contain"
      />
    </div>

    <!-- TEXT CONTENT -->
    <div class="flex-1">
      <h3 class="font-semibold text-lg mb-1 text-gray-900 dark:text-gray-100">
        {{ achievement.name }}
      </h3>
      <p class="text-sm text-gray-600 dark:text-gray-400 leading-snug">
        {{ achievement.description }}
      </p>
    </div>
  </div>
</template>
