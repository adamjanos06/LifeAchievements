<template>
  <div class="fixed bottom-6 right-6 z-50">

    <div
      class="bg-gray-900 text-white rounded-xl shadow-lg p-4 w-64 border border-gray-700"
    >
      <div class="text-sm text-gray-400">
        🏅 Badge Unlocked
      </div>

      <div class="text-lg font-semibold mt-1">
        {{ badge.name }}
      </div>

      <div class="text-sm text-gray-300 mt-1">
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