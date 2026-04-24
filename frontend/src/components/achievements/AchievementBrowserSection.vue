<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue"
import AchievementGrid from "@/components/AchievementGrid.vue"
import AchievementCard from "@/components/AchievementCard.vue"
import PaginationButtons from "@/components/PaginationButtons.vue"

const props = defineProps({
  achievements: {
    type: Array,
    required: true,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
  emptyMessage: {
    type: String,
    default: "No achievements found",
  },
  showCompletionIndicators: {
    type: Boolean,
    default: false,
  },
  clickable: {
    type: Boolean,
    default: true,
  },
  largeText: {
    type: Boolean,
    default: false,
  },
  categoryIcon: {
    type: String,
    default: null,
  },
  cardHeightClass: {
    type: String,
    default: "min-h-[8rem]",
  },
  gridGap: {
    type: String,
    default: "gap-3 sm:gap-5 lg:gap-6",
  },
  paginationContainerClass: {
    type: String,
    default: "flex justify-center gap-4 mt-2",
  },
  paginationActiveButtonStyle: {
    type: Object,
    default: null,
  },
  pageSize: {
    type: Number,
    default: 9,
  },
  responsivePageSize: {
    type: Boolean,
    default: false,
  },
  searchable: {
    type: Boolean,
    default: false,
  },
  searchPlaceholder: {
    type: String,
    default: "Search achievements...",
  },
  contentMinHeightClass: {
    type: String,
    default: "min-h-[32rem] sm:min-h-[35.25rem] lg:min-h-[35.75rem]",
  },
})

const emit = defineEmits(["select"])

const searchQuery = ref("")
const currentPage = ref(1)
const windowWidth = ref(typeof window !== "undefined" ? window.innerWidth : 1024)
let resizeHandler = null

const perPage = computed(() => {
  if (!props.responsivePageSize) return props.pageSize

  if (windowWidth.value >= 1024) return 9
  if (windowWidth.value >= 640) return 6
  return 3
})

const filteredAchievements = computed(() => {
  if (!props.searchable || !searchQuery.value.trim()) {
    return props.achievements
  }

  const query = searchQuery.value.toLowerCase()

  return props.achievements.filter((achievement) => {
    return achievement.name.toLowerCase().includes(query) ||
      achievement.description.toLowerCase().includes(query)
  })
})

const totalPages = computed(() => {
  return Math.max(1, Math.ceil(filteredAchievements.value.length / perPage.value))
})

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  return filteredAchievements.value.slice(start, start + perPage.value)
})

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

watch([filteredAchievements, perPage], () => {
  if (currentPage.value > totalPages.value) {
    currentPage.value = totalPages.value
  }
})

watch(searchQuery, () => {
  currentPage.value = 1
})

onMounted(() => {
  if (!props.responsivePageSize) return

  resizeHandler = () => {
    windowWidth.value = window.innerWidth
    currentPage.value = 1
  }

  window.addEventListener("resize", resizeHandler)
})

onBeforeUnmount(() => {
  if (resizeHandler) {
    window.removeEventListener("resize", resizeHandler)
  }
})
</script>

<template>
  <div>
    <div v-if="searchable" class="flex justify-center mb-4">
      <input
        v-model="searchQuery"
        type="text"
        :placeholder="searchPlaceholder"
        class="w-full max-w-md px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-600"
      />
    </div>

    <div :class="contentMinHeightClass">
      <AchievementGrid
        :achievements="paginatedAchievements"
        :is-loading="isLoading"
        :show-completion-indicators="showCompletionIndicators"
        :clickable="clickable"
        :empty-message="emptyMessage"
        :grid-gap="gridGap"
        @achievement-click="emit('select', $event)"
      >
        <template #achievement-card="{ achievement }">
          <AchievementCard
            :achievement="achievement"
            :show-completion-indicator="showCompletionIndicators && (achievement.completed || Number(achievement.completions) > 0)"
            :repeatable="achievement.repeatable"
            :completions="achievement.completions"
            :category-icon="categoryIcon || achievement.category?.icon || achievement.category_icon"
            :large-text="largeText"
            :card-height-class="cardHeightClass"
            :emit-click="false"
          />
        </template>
      </AchievementGrid>
    </div>

    <PaginationButtons
      :total-pages="totalPages"
      :current-page="currentPage"
      :container-class="paginationContainerClass"
      :active-button-style="paginationActiveButtonStyle || undefined"
      @page-change="goToPage"
    />
  </div>
</template>