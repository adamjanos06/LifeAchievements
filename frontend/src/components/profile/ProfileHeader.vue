<script setup>
defineProps({
  user: {
    type: Object,
    required: true
  },
  imageUrl: {
    type: String,
    default: null
  }
})

defineEmits(['edit', 'logout'])
</script>

<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
    <div class="flex flex-col md:flex-row md:items-center gap-6">
      <div
        class="w-28 h-28 rounded-full bg-blue-600 text-white flex items-center justify-center text-5xl font-bold overflow-hidden"
      >
        <img v-if="imageUrl" :src="imageUrl" class="w-full h-full object-cover" />
        <span v-else>
          {{ user.name[0].toUpperCase() }}
        </span>
      </div>

      <!-- Main Stuff -->
      <div class="flex-1 space-y-3">
        <div
          class="flex flex-col md:flex-row md:items-center md:justify-between gap-2"
        >
          <div>
            <h2 class="text-2xl font-bold">
              {{ user.name }}
            </h2>
            <p class="text-gray-700 dark:text-gray-300">
              {{ user.email }}
            </p>
          </div>
          <span class="text-sm font-semibold text-blue-600 dark:text-cyan-400">
            Level {{ user.level_data?.level }}
          </span>
        </div>

        <!-- PROGRESS BAR -->
        <div>
          <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div
              class="bg-blue-600 h-3 rounded-full transition-all duration-500"
              :style="{ width: (user.level_data?.progress_percent ?? 0) + '%' }"
            ></div>
          </div>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ user.level_data?.current_level_xp ?? 0 }}
            /
            {{ user.level_data?.xp_needed ?? 0 }} XP
          </p>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex md:flex-col gap-2">
        <button
          @click="$emit('edit')"
          class="border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition"
        >
          Edit
        </button>

        <button
          @click="$emit('logout')"
          class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold"
        >
          Log Out
        </button>
      </div>
    </div>
  </div>
</template>
