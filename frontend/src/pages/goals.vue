<script setup>
import { useGoalsPage } from "@/utils/composables/useGoalsPage.js";
import MainNavbar from "@/components/layout/MainNavbar.vue"
import AchievementBrowserSection from "@/components/achievements/AchievementBrowserSection.vue"
import AchievementDetailsModal from "@/components/achievements/AchievementDetailsModal.vue"
import BadgePopup from "@/components/BadgePopup.vue"

const {
  goals,
  isLoading,
  selectedGoal,
  showModal,
  unlockedBadge,
  completionButtonText,
  completionButtonDisabled,
  selectedIcon,
  openGoal,
  closeModal,
  removeSelectedGoal,
  markSelectedAsCompleted,
} = useGoalsPage()
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14 text-gray-900 dark:text-gray-100 transition-colors">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      GOALS
    </h2>

    <AchievementBrowserSection
      :achievements="goals"
      :is-loading="isLoading"
      :show-completion-indicators="false"
      :clickable="true"
      :large-text="true"
      :responsive-page-size="true"
      card-height-class="h-[8.75rem] max-h-[8.75rem] sm:h-[9.5rem] sm:max-h-[9.5rem] lg:h-[9.5rem] lg:max-h-[9.5rem]"
      content-min-height-class="min-h-[32rem] sm:min-h-[35.25rem] lg:min-h-[35.75rem]"
      pagination-container-class="flex justify-center gap-4 mt-2"
      empty-message="You haven't set any achievements as goals yet."
      @select="openGoal"
    />

    <AchievementDetailsModal
      :open="showModal"
      :achievement="selectedGoal"
      :icon="selectedIcon"
      @close="closeModal"
    >
      <div class="w-full mt-3">
        <button
          v-if="selectedGoal?.completed && !selectedGoal?.repeatable"
          disabled
          class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold cursor-default border-2 border-green-400 dark:border-green-300 shadow-md dark:shadow-[0_0_15px_rgba(34,197,94,0.6)]"
        >
          COMPLETED
        </button>

        <button
          v-else
          @click="markSelectedAsCompleted"
          :disabled="completionButtonDisabled"
          class="w-full bg-blue-600 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold transition cursor-pointer border-2 border-blue-400 dark:border-blue-300 shadow-md dark:shadow-[0_0_15px_rgba(59,130,246,0.6)]"
        >
          {{ completionButtonText }}
        </button>

        <button
          @click="removeSelectedGoal"
          class="w-full mt-3 py-2 rounded-lg font-semibold transition cursor-pointer bg-transparent text-amber-600 border-2 border-amber-500"
        >
          REMOVE GOAL
        </button>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selectedGoal?.xp }} XP</p>
        </div>
      </div>
    </AchievementDetailsModal>

    <BadgePopup
      v-if="unlockedBadge"
      :badge="unlockedBadge"
      @close="unlockedBadge = null"
    />

  </div>
</template>