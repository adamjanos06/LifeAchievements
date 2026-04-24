<script setup>
import { useAchievementsPage } from "@/utils/composables/useAchievementsPage.js";
import MainNavbar from "@/components/layout/MainNavbar.vue";
import AchievementBrowserSection from "@/components/achievements/AchievementBrowserSection.vue";
import AchievementDetailsModal from "@/components/achievements/AchievementDetailsModal.vue";

const {
  achievements,
  isLoading,
  selectedAchievement,
  showModal,
  selectedIcon,
  openAchievement,
} = useAchievementsPage()
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14 text-gray-900 dark:text-gray-100 transition-colors">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      MY ACHIEVEMENTS
    </h2>

    <AchievementBrowserSection
      :achievements="achievements"
      :is-loading="isLoading"
      :show-completion-indicators="true"
      :clickable="true"
      :searchable="false"
      :large-text="true"
      :responsive-page-size="true"
      card-height-class="h-[8.75rem] max-h-[8.75rem] sm:h-[9.5rem] sm:max-h-[9.5rem] lg:h-[9.5rem] lg:max-h-[9.5rem]"
      content-min-height-class="min-h-[32rem] sm:min-h-[35.25rem] lg:min-h-[35.75rem]"
      pagination-container-class="flex justify-center gap-4 mt-2"
      empty-message="You haven't completed any achievements yet."
      @select="openAchievement"
    />

    <AchievementDetailsModal
      :open="showModal"
      :achievement="selectedAchievement"
      :icon="selectedIcon"
      @close="showModal = false"
    />

  </div>
</template>
