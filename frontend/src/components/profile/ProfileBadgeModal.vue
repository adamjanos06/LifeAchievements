<script setup>
import { ref, onMounted } from "vue"

const props = defineProps({
  show: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(["close"])
const badges = ref([])
const token = localStorage.getItem("token")

async function loadBadges() {
  const res = await fetch("http://backend.vm1.test/api/badges", {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })

  const json = await res.json()
  badges.value = json.data ?? []
}

function handleClose() {
  emit("close")
}

onMounted(() => {
  loadBadges()
})
</script>

<template>
  <div
    v-if="props.show"
    class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
  >
    <div
      class="bg-white dark:bg-gray-800
             w-full max-w-4xl mx-4 p-6 rounded-2xl
             text-gray-900 dark:text-gray-100
             max-h-[80vh] overflow-y-auto"
    >
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Badges</h2>
        <button @click="handleClose" class="text-xl">×</button>
      </div>

      <div
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6"
      >
        <div
          v-for="badge in badges"
          :key="badge.id"
          class="flex flex-col items-center group relative"
        >
          <div
            class="w-50 h-50 flex items-center justify-center transition"
          >
            <img
              v-if="badge.icon"
              :src="badge.icon"
              class="max-full max-full object-contain"
              :class="{
                'grayscale opacity-40': !badge.earned
              }"
            />
          </div>

          <p class="text-sm mt-2 text-center">
            {{ badge.name }}
          </p>
          <div
            class="absolute bottom-full mb-2 w-48 p-2 rounded-lg
                   bg-black text-white text-xs text-center
                   opacity-0 group-hover:opacity-100
                   transition pointer-events-none z-50"
          >
            {{ badge.requirement_text }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>