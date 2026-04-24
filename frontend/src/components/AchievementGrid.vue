<script setup>
import AchievementCard from './AchievementCard.vue';

defineProps({
  achievements: {
    type: Array,
    required: true
  },
  isLoading: {
    type: Boolean,
    default: false
  },
  showCompletionIndicators: {
    type: Boolean,
    default: false
  },
  clickable: {
    type: Boolean,
    default: true
  },
  emptyMessage: {
    type: String,
    default: "No achievements found"
  },
  gridGap: {
    type: String,
    default: "gap-x-6 gap-y-6 sm:gap-x-10 sm:gap-y-10 lg:gap-x-14 lg:gap-y-12"
  }
});

defineEmits(['achievement-click']);
</script>

<template>
  <!-- Empty State -->
  <div
    v-if="achievements.length === 0 && !isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    {{ emptyMessage }}
  </div>

  <!-- Loading State -->
  <div
    v-if="isLoading"
    class="text-center text-gray-500 dark:text-gray-400 text-lg py-20"
  >
    Loading achievements...
  </div>

  <!-- Achievements Grid -->
  <div
    v-else-if="achievements.length > 0"
    :class="['grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3', gridGap]"
  >
    <div
      v-for="achievement in achievements"
      :key="achievement.id"
      :class="clickable ? 'cursor-pointer' : ''"
      @click="clickable && $emit('achievement-click', achievement)"
    >
      <slot name="achievement-card" :achievement="achievement">
        <AchievementCard
          :achievement="achievement"
          :show-completion-indicator="showCompletionIndicators"
          :completions="achievement.completions || 0"
          :repeatable="achievement.repeatable || false"
          :category-icon="achievement.category?.icon || achievement.category_icon"
          :clickable="clickable"
          :emit-click="false"
        />
      </slot>
    </div>
  </div>
</template>
