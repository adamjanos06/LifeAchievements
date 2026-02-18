<script setup>
import { computed } from "vue"

const props = defineProps({
  completedAchievements: {
    type: Array,
    required: true,
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


const events = computed(() => {
  const sorted = [...props.completedAchievements].sort(
    (a, b) => new Date(a.completion_date) - new Date(b.completion_date)
  )

  const result = []
  let accumulatedXp = 0
  let currentLevel = 1

  for (const achievement of sorted) {
    const xpGain = achievement.achievement?.xp ?? 0
    accumulatedXp += xpGain

    const newLevel = calculateLevel(accumulatedXp)

    result.push({
      type: "achievement",
      name: achievement.achievement?.name,
      xp: xpGain,
      date: achievement.completion_date,
    })

    while (newLevel > currentLevel) {
      currentLevel++

      result.push({
        type: "level",
        level: currentLevel,
        date: achievement.completion_date,
      })
    }
  }

  return result
    .sort((a, b) => new Date(b.date) - new Date(a.date))
    .slice(0, 3)
})
</script>

<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 space-y-4">
    <h3 class="font-semibold text-lg">Recent Activity</h3>

    <div
      v-for="(event, index) in events"
      :key="index"
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

      <div v-else>
        <p class="font-medium text-blue-600 dark:text-cyan-400">
          🎉 Level Up!
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Reached Level {{ event.level }}
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
