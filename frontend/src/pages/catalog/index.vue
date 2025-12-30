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

onMounted(() => loadCategories());
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-6 py-12">

    <!-- Title -->
    <h2 class="text-center text-2xl font-bold tracking-wide mb-12">
      CATEGORIES
    </h2>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      <div
        v-for="cat in categories"
        :key="cat.id"
        @click="goToCategory(cat.id)"
        class="flex items-center gap-5 border rounded-2xl px-8 py-5 cursor-pointer 
               hover:shadow-lg transition bg-white"
      >

        <!-- ICON -->
        <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center">
          <span class="text-lg font-bold text-gray-600">
            {{ cat.name.charAt(0) }}
          </span>
        </div>

        <!-- TEXT -->
        <span class="text-xl font-semibold">
          {{ cat.name }}
        </span>

      </div>

    </div>

  </div>
</template>

