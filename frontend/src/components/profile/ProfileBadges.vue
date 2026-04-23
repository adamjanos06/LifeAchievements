<script setup>
import { ref, onMounted } from "vue"

const badges = ref([])

async function loadBadges() {

  const res = await fetch("http://backend.vm1.test/api/my-badges", {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  })

  const json = await res.json()

  badges.value = (json.data ?? []).slice(0, 3)
}

onMounted(async () => {
  await new Promise(resolve => setTimeout(resolve, 300))
  loadBadges()
})
</script>

<template>
  <div class="flex flex-col items-center gap-3">

    <!-- TITLE -->
    <p class="font-medium text-gray-700 dark:text-gray-300">
      Recent Badges
    </p>

    <!-- BADGES -->
    <div class="flex justify-center gap-6 flex-wrap">
      <div
        v-for="badge in badges"
        :key="badge.id"
        class="flex flex-col items-center"
      >
        <div class="w-24 h-24 flex items-center justify-center">
          <img
            v-if="badge.icon"
            :src="badge.icon"
            class="max-w-full max-h-full object-contain"
            @error="badge.icon = null"
          />

          <div
            v-else
            class="w-12 h-12 rounded-full
                   bg-blue-600 text-white
                   flex items-center justify-center
                   font-bold text-sm"
          >
            {{ badge.name.charAt(0).toUpperCase() }}
          </div>
        </div>
      </div>
    </div>

  </div>
</template>