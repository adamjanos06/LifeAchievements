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

  badges.value = (json.data ?? []).slice(0, 5)
}

onMounted(loadBadges)
</script>

<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

    <h3 class="text-lg font-semibold mb-4">
      Recent Badges
    </h3>

    <div class="flex justify-center gap-10 flex-wrap">

      <div
        v-for="badge in badges"
        :key="badge.id"
        class="flex flex-col items-center w-28"
      >

        <!-- IMAGE -->
        <div class="w-40 h-40 flex items-center justify-center">

          <img
            v-if="badge.icon"
            :src="badge.icon"
            class="max-w-full max-h-full object-contain"
            @error="badge.icon = null"
          />

          <!-- FALLBACK -->
          <div
            v-else
            class="w-24 h-24 rounded-full
                   bg-blue-600
                   text-white
                   flex items-center justify-center
                   font-bold text-xl"
          >
            {{ badge.name.charAt(0).toUpperCase() }}
          </div>

        </div>

        <span class="text-sm mt-3 text-center whitespace-nowrap">
          {{ badge.name }}
        </span>

      </div>

    </div>

  </div>
</template>