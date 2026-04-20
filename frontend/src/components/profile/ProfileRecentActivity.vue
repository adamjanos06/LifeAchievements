<script setup>
import { computed } from "vue"

const props = defineProps({
  completedAchievements: {
    type: Array,
    required: true,
  },
  earnedBadges: {
    type: Array,
    default: () => [],
  },
})

function xpRequiredForLevel(level) {
  if (level <= 10) return level * 25
  return 250
}

function calculateLevel(xp) {
  let level = 1
  let remainingXp = xp

  while (true) {
    const needed = xpRequiredForLevel(level)

    if (remainingXp < needed) break

    remainingXp -= needed
    level++
  }

  return level
}

function parseDate(value) {
  const date = new Date(value)
  return Number.isNaN(date.getTime()) ? null : date
}

const events = computed(() => {
  const achievementEvents = [...props.completedAchievements]
    .map((achievement) => {
      const date = parseDate(achievement.completion_date)
      return date
        ? {
            type: "achievement",
            name: achievement.achievement?.name,
            xp: achievement.achievement?.xp ?? 0,
            date,
            timestamp: date.getTime(),
          }
        : null
    })
    .filter((event) => event)
    .sort((a, b) => a.timestamp - b.timestamp)

  const badgeEvents = [...props.earnedBadges]
    .map((badge) => {
      const date = parseDate(badge.pivot?.earned_at || badge.pivot?.created_at || badge.earned_at || badge.created_at)
      return date
        ? {
            type: "badge",
            name: badge.name,
            date,
            timestamp: date.getTime(),
          }
        : null
    })
    .filter((event) => event)
    .sort((a, b) => a.timestamp - b.timestamp)

  const result = []
  let accumulatedXp = 0
  let currentLevel = 1

  for (const event of achievementEvents) {
    accumulatedXp += event.xp
    const newLevel = calculateLevel(accumulatedXp)

    result.push(event)

    while (newLevel > currentLevel) {
      currentLevel++
      result.push({
        type: "level",
        level: currentLevel,
        date: event.date,
        timestamp: event.timestamp,
      })
    }
  }

  const allEvents = [...result, ...badgeEvents]

  return allEvents
    .sort((a, b) => {
      if (a.timestamp === b.timestamp) {
        return 0
      }
      return b.timestamp - a.timestamp
    })
    .slice(0, 3)
})
</script>

<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
    <h3 class="font-semibold text-lg">Recent Activity</h3>

    <div
      v-for="event in events"
      :key="event.type + '-' + event.timestamp"
      class="border dark:border-gray-700 rounded-xl px-4 py-3
             flex justify-between items-center"
    >
      <div v-if="event.type === 'achievement'">
        <p class="font-medium">
          Completed: {{ event.name }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ new Date(event.date).toLocaleDateString() }}
        </p>
      </div>

      <div v-else-if="event.type === 'badge'">
        <p class="font-medium text-yellow-600 dark:text-amber-300">
          🏅 Badge Unlocked
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ event.name }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ new Date(event.date).toLocaleDateString() }}
        </p>
      </div>

      <div v-else-if="event.type === 'friend'">
        <p class="font-medium text-pink-600 dark:text-pink-400">
          👥 New Friend
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Added {{ event.name }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ new Date(event.date).toLocaleDateString() }}
        </p>
      </div>

      <div v-else-if="event.type === 'level'">
        <p class="font-medium text-blue-600 dark:text-cyan-400">
          🎉 Level Up!
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Reached Level {{ event.level }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ new Date(event.date).toLocaleDateString() }}
        </p>
      </div>

      <span
        v-if="event.type === 'achievement'"
        class="text-green-600 font-semibold"
      >
        +{{ event.xp }} XP
      </span>
    </div>
  </div>
</template>
