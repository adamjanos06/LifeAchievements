<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);
const selectedCategory = ref("");
const viewMode = ref("grid");

async function loadCategories() {
  const res = await fetch("http://backend.vm1.test/api/categories");
  categories.value = await res.json();
  categories.value = categories.value.data;
}

function goToCategory(id) {
  router.push(`/catalog/${id}`);
}

onMounted(() => {
  loadCategories();
});
</script>

<template>
  <div>
    <!-- Category Cards for Quick Filter -->
    <div>
      <div v-for="cat in categories" :key="cat.id" @click="goToCategory(cat.id)">
        {{ cat.name }}
      </div>
    </div>

  </div>
</template>
