<template>
  <div class="fixed bottom-6 left-6 z-50">

    <div
      class="bg-white text-gray-900 border border-gray-300
       dark:bg-gray-900 dark:text-white dark:border-gray-700
       rounded-xl shadow-lg p-4 w-64"
    >
      <div class="text-sm text-gray-900">
        🏅 Badge Unlocked
      </div>

      <div class="text-lg font-semibold mt-1">
        {{ badge.name }}
      </div>

      <div class="text-sm text-gray-800 mt-1">
        {{ badge.description }}
      </div>
    </div>

  </div>
</template>

<script setup>
import { onMounted } from "vue"

const props = defineProps({
  badge: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(["close"])

onMounted(() => {
  setTimeout(() => {
    emit("close")
  }, 4000)
})
</script>