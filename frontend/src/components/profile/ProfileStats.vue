<script setup>
import ProfileBadges from "@/components/profile/ProfileBadges.vue"

defineProps({
  user: {
    type: Object,
    required: true
  },
  achievementsUnlocked: {
    type: Number,
    default: 0
  },
  totalXp: {
    type: Number,
    default: 0
  }
})

defineEmits(['achievements-click'])
</script>

<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4 min-h-[300px]">
    <h3 class="font-semibold text-lg">Stats</h3>
    <ProfileBadges />
    <div
      @click="$emit('achievements-click')"
      class="flex justify-between hover:text-blue-600 dark:hover:text-cyan-400 cursor-pointer transition"
    >
      <span>🏆 Achievements</span>
      <strong>{{ achievementsUnlocked }}</strong>
    </div>

    <div class="flex justify-between">
      <span>⭐ Total XP</span>
      <strong>{{ totalXp }}</strong>
    </div>
    <div class="flex justify-between">
      <span>🔥 Favorite Category</span>
      <strong>
        {{ user.favorite_category ?? "None" }}
      </strong>
    </div>
    <div class="flex justify-between">
      <span>📅 Member Since</span>
      <strong>
        {{ new Date(user.created_at).toLocaleDateString() }}
      </strong>
    </div>
  </div>
</template>
