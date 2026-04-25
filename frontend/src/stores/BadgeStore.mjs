import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useBadgeStore = defineStore('badge', () => {
  const recentlyEarnedBadges = ref([])

  function addRecentBadge(badge) {
    if (badge && !recentlyEarnedBadges.value.some(b => b.id === badge.id)) {
      recentlyEarnedBadges.value.push(badge)
    }
  }

  function clearRecentBadges() {
    recentlyEarnedBadges.value = []
  }

  return {
    recentlyEarnedBadges,
    addRecentBadge,
    clearRecentBadges
  }
})
