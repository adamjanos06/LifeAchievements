<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);
const selectedCategory = ref(route.params.id || "");
const viewMode = ref("grid");

async function loadCategories() {
  const res = await fetch("/api/categories");
  categories.value = await res.json();
}

async function loadAchievements() {
  const res = await fetch("/api/achievements");
  achievements.value = await res.json();
  applyFilter();
}

function applyFilter() {
  filtered.value = achievements.value.filter(
    a => a.category_id === Number(selectedCategory.value)
  );
}

onMounted(() => {
  loadCategories();
  loadAchievements();
});
</script>

<template>
  <div>
    <!-- Filter Bar -->
    <div>
      <select v-model="selectedCategory" @change="applyFilter">
        <option value="">All Categories</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
          {{ cat.name }}
        </option>
      </select>

      <button @click="viewMode = 'grid'">Grid</button>
      <button @click="viewMode = 'list'">List</button>
    </div>

    <!-- Achievements -->
    <div v-if="viewMode === 'grid'">
      <div v-for="a in filtered" :key="a.id">
        {{ a.name }}
      </div>
    </div>

    <div v-else>
      <div v-for="a in filtered" :key="a.id">
        <strong>{{ a.name }}</strong>
        <p>{{ a.description }}</p>
      </div>
    </div>
  </div>
</template>
