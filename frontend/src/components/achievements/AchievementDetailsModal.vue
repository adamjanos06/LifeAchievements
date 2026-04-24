<script setup>
import { computed } from "vue"
import { CircleX } from "@lucide/vue"

const props = defineProps({
  open: {
    type: Boolean,
    default: false,
  },
  achievement: {
    type: Object,
    default: null,
  },
  icon: {
    type: String,
    default: "",
  },
  showDetails: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(["close"])

const completionText = computed(() => {
  if (!props.achievement) return ""

  const completions = Number(props.achievement.completions) || 0
  if (!completions) return ""

  return `Completed ${completions} time${completions > 1 ? "s" : ""}.`
})
</script>

<template>
  <div
    v-if="open"
    class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
  >
    <div
      class="bg-white dark:bg-gray-800 rounded-2xl p-8 w-full max-w-md relative mx-4 text-gray-900 dark:text-gray-100 transition-colors dark:shadow-[0_0_40px_rgba(255,255,255,0.25)]"
    >
      <button @click="emit('close')" class="absolute top-4 right-4 text-2xl w-8 h-8">
        <CircleX />
      </button>

      <div v-if="achievement" class="flex flex-col items-center text-center gap-4">
        <template v-if="showDetails">
          <img v-if="icon" :src="icon" class="w-20 h-20 object-contain" />

          <h2 class="text-2xl font-bold">
            {{ achievement.name }}
          </h2>

          <p class="text-gray-600 dark:text-gray-400">
            {{ achievement.description }}
          </p>

          <p
            v-if="completionText"
            class="text-sm text-gray-500 dark:text-gray-400 mt-1"
          >
            {{ completionText }}
          </p>
        </template>

        <slot :achievement="achievement" />
      </div>
    </div>
  </div>
</template>