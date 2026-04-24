<script setup>
import { useCatalogDetailPage } from "@/utils/composables/useCatalogDetailPage.js"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import AchievementBrowserSection from "@/components/achievements/AchievementBrowserSection.vue"
import AchievementDetailsModal from "@/components/achievements/AchievementDetailsModal.vue"
import BadgePopup from "@/components/BadgePopup.vue"
const {
  unlockedBadge,
  selected,
  showModal,
  isLoading,
  filteredAchievements,
  categoryName,
  icon,
  categoryColor,
  completionButtonText,
  completionButtonDisabled,
  isLoggedIn,
  isGoal,
  goBackToCategories,
  openModal,
  closeModal,
  toggleGoalData,
  markAsCompleted,
} = useCatalogDetailPage()
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-4
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-3xl font-bold tracking-wide mb-4">
      {{ categoryName }}
    </h2>

    <AchievementBrowserSection
      :achievements="filteredAchievements"
      :is-loading="isLoading"
      :show-completion-indicators="true"
      :clickable="true"
      :large-text="true"
      :category-icon="icon"
      card-height-class="h-[8.75rem] max-h-[8.75rem] sm:h-[9.5rem] sm:max-h-[9.5rem] lg:h-[9.5rem] lg:max-h-[9.5rem]"
      grid-gap="gap-3 sm:gap-5 lg:gap-6"
      pagination-container-class="flex justify-center gap-4 mt-7"
      :pagination-active-button-style="{
        backgroundColor: categoryColor,
        boxShadow: `0 0 20px ${categoryColor}66`
      }"
      content-min-height-class="min-h-[28rem] sm:min-h-[31rem] lg:min-h-[33rem]"
      searchable
      search-placeholder="Search achievements..."
      responsive-page-size
      empty-message="No achievements found in this category."
      @select="openModal"
    />

    <div class="flex justify-center mt-8">
      <button
        @click="goBackToCategories"
        class="px-8 py-3 text-white font-semibold rounded-xl
        transition transform duration-300 cursor-pointer hover:scale-120"
        :style="{
          backgroundColor: categoryColor,
          boxShadow: `0 0 20px ${categoryColor}66`
        }"
      >
        ← Back to Categories
      </button>
    </div>
  </div>

  <AchievementDetailsModal
    :open="showModal"
    :achievement="selected"
    :icon="isLoggedIn() ? icon : ''"
    :show-details="isLoggedIn()"
    @close="closeModal"
  >
    <template v-if="!isLoggedIn()">
      <div class="text-center space-y-4">
        <h2 class="text-xl font-bold">
          You must be logged in
        </h2>

        <RouterLink
          to="/login"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold"
        >
          Go to Login
        </RouterLink>
      </div>
    </template>

    <template v-else>
      <div class="w-full mt-3">
        <button
          v-if="selected?.completed && !selected?.repeatable"
          disabled
          class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold cursor-default border-2 border-green-400 dark:border-green-300 shadow-md dark:shadow-[0_0_15px_rgba(34,197,94,0.6)]"
        >
          COMPLETED
        </button>

        <button
          v-else
          @click="markAsCompleted"
          :disabled="completionButtonDisabled"
          class="w-full bg-blue-600 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold transition cursor-pointer border-2 border-blue-400 dark:border-blue-300 shadow-md dark:shadow-[0_0_15px_rgba(59,130,246,0.6)]"
        >
          {{ completionButtonText }}
        </button>

        <button
          v-if="!selected?.completed"
          @click="toggleGoalData"
          :class="isGoal(selected.id)
            ? 'bg-transparent text-amber-600 border-2 border-amber-500'
            : 'bg-amber-600 hover:bg-amber-800 text-white border-2 border-amber-400 shadow-md dark:shadow-[0_0_15px_rgba(251,191,36,0.6)]'"
          class="w-full mt-3 py-2 rounded-lg font-semibold transition cursor-pointer"
        >
          {{ isGoal(selected.id) ? "REMOVE GOAL" : "MARK AS GOAL" }}
        </button>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selected?.xp }} XP</p>
        </div>
      </div>
    </template>
  </AchievementDetailsModal>
  <BadgePopup
    v-if="unlockedBadge"
    :badge="unlockedBadge"
    @close="unlockedBadge = null"
  />
</template>
