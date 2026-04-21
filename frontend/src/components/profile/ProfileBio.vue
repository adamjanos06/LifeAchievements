<script setup>
defineProps({
  bio: {
    type: String,
    default: ""
  }
})
</script>

<template>
  <div v-if="bio" class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
    <h3 class="text-lg font-semibold mb-2">About</h3>
    <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
      {{ bio }}
    </p>
  </div>
</template>
