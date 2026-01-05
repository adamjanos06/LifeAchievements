<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import MainNavbar from '@/components/layout/MainNavbar.vue'

const router = useRouter();
const categories = ref([]);

async function loadCategories() {
  const res = await fetch("http://backend.vm1.test/api/categories");
  const json = await res.json();
  categories.value = json.data;
}

function goToCategory(id) {
  router.push(`/catalog/${id}`);
}

onMounted(loadCategories);
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h2 class="text-center text-2xl font-bold tracking-wide mb-14">
      CATEGORIES
    </h2>

    <div
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
             gap-x-6 gap-y-6
             sm:gap-x-10 sm:gap-y-10
             lg:gap-x-14 lg:gap-y-12"
    >
      <div
        v-for="cat in categories"
        :key="cat.id"
        @click="goToCategory(cat.id)"
        class="flex items-center gap-5
               border border-gray-200 dark:border-gray-700
               rounded-2xl px-7 py-6 cursor-pointer
               bg-white dark:bg-gray-800
               transition
               hover:shadow-lg
               dark:hover:shadow-[0_0_20px_rgba(255,255,255,0.08)]"
      >
        <div class="w-16 h-16 rounded-full flex items-center justify-center">
          <img
            v-if="cat.icon"
            :src="cat.icon"
            alt="Category Icon"
            class="w-20 h-20 object-contain"
          />
          <span
            v-else
            class="text-lg font-bold
                   text-gray-600 dark:text-gray-300"
          >
            {{ cat.name.charAt(0) }}
          </span>
        </div>

        <span class="text-lg font-semibold">
          {{ cat.name }}
        </span>
      </div>
    </div>
  </div>
</template>
