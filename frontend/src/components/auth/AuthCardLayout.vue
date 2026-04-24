<script setup>
defineProps({
  title: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div
    class="min-h-screen flex items-center justify-center px-4
           bg-gray-100 dark:bg-gray-900
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <div
      class="w-full max-w-md rounded-2xl shadow-lg p-8
             bg-white dark:bg-gray-800
             transition-colors"
    >
      <h1 class="text-3xl font-bold text-center mb-6">
        {{ title }}
      </h1>

      <slot />
    </div>
  </div>
</template>
