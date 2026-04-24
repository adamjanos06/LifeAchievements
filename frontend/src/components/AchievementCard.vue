<script setup>
import { Check } from '@lucide/vue';
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
  },
  emitClick: {
    type: Boolean,
    default: true
  },
  largeText: {
    type: Boolean,
    default: false
  },
  cardHeightClass: {
    type: String,
    default: "min-h-[8rem]"
  }
});

defineEmits(['click']);
</script>

<template>
  <div
    @click="clickable && emitClick && $emit('click')"
    :class="[
      'relative border border-gray-200 dark:border-gray-700 rounded-2xl px-7 py-7',
      'bg-white dark:bg-gray-800 flex items-center gap-5 transition-colors',
      cardHeightClass,
      clickable ? 'cursor-pointer hover:shadow-lg dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.18)]' : ''
    ]"
  >
    <!-- COMPLETION INDICATOR -->
    <div v-if="showCompletionIndicator" class="absolute top-3 right-3">
      <template v-if="repeatable">
        <span
          class="w-8 h-8 rounded-full bg-blue-600 text-white
                 flex items-center justify-center text-lg font-bold text-center"
        >
          {{ completions }}
        </span>
      </template>
      <template v-else>
        <div
          class="w-8 h-8 rounded-full bg-green-500 dark:bg-green-600 text-white flex items-center justify-center"
        >
          <Check :strokeWidth="4" />  
        </div>
      </template>
    </div>

    <!-- ICON -->
    <div v-if="categoryIcon" class="w-20 h-20 rounded-full flex items-center justify-center flex-shrink-0">
      <img
        :src="categoryIcon"
        :alt="`${achievement.name} Icon`"
        class="w-22 h-22 object-contain"
      />
    </div>

    <!-- TEXT CONTENT -->
    <div class="flex-1">
      <h3
        :class="[
          'font-semibold mb-1 text-gray-900 dark:text-gray-100',
          largeText ? 'text-2xl' : 'text-xl'
        ]"
      >
        {{ achievement.name }}
      </h3>
      <p
        :class="[
          'text-gray-800 dark:text-gray-200 leading-snug',
          largeText ? 'text-xl' : 'text-lg'
        ]"
      >
        {{ achievement.description }}
      </p>
    </div>
  </div>
</template>
