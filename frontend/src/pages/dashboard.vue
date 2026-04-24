<script setup>
import { useDashboardPage } from "@/utils/composables/useDashboardPage.js"
import MainNavbar from "@/components/layout/MainNavbar.vue"
import { SquarePen, SquareX, CirclePlus, SquareXIcon, Trash2 } from "@lucide/vue"

const {
  tables,
  selectedTable,
  records,
  loading,
  recordsLoading,
  currentPage,
  perPage,
  searchQuery,
  sortBy,
  sortOrder,
  totalPages,
  totalRecords,
  showEditModal,
  showCreateModal,
  editingRecord,
  editFormData,
  fillable,
  visibleColumns,
  paginationRange,
  selectTable,
  openCreateModal,
  openEditModal,
  deleteRecord,
  handleSearch,
  handleSort,
  goToPage,
  closeEditModal,
  closeCreateModal,
  isBooleanField,
  isForeignKeyField,
  isForeignKeyLoading,
  getForeignKeySourceTable,
  getForeignKeyOptions,
  saveRecord,
} = useDashboardPage()
</script>

<template>
  <MainNavbar class="relative z-50" />
  
  <div class="fixed inset-0 top-24 z-10 bg-gray-50 dark:bg-gray-800 overflow-hidden flex flex-col">
    <div class="px-4 sm:px-6 lg:px-8 py-3 border-b border-gray-200 dark:border-gray-600 flex-shrink-0">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        Admin Dashboard
      </h1>
    </div>

    <div class="flex-1 overflow-hidden">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-3 h-full px-3 sm:px-4 lg:px-6 py-3">
        <div class="lg:col-span-1 flex flex-col overflow-hidden">
          <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-3 flex flex-col h-full">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-3 flex-shrink-0">
              Tables
            </h2>
            
            <div v-if="loading" class="text-gray-500 dark:text-gray-400">
              Loading tables...
            </div>
            
            <div v-else class="space-y-2 overflow-y-auto flex-1">
              <button
                v-for="table in tables"
                :key="table.name"
                @click="selectTable(table.name)"
                :class="[
                  'w-full text-left px-4 py-2 rounded transition',
                  selectedTable === table.name
                    ? 'bg-blue-500 text-white'
                    : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500'
                ]"
              >
                <span class="font-medium">{{ table.name }}</span>
                <span class="ml-2 text-sm opacity-75">
                  ({{ table.count }})
                </span>
              </button>
            </div>
          </div>
        </div>

        <div class="lg:col-span-3 flex flex-col overflow-hidden">
          <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-3 flex flex-col h-full">
            <div v-if="selectedTable" class="flex-shrink-0 mb-3">
              <div class="flex justify-between items-center mb-2 gap-2">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                  {{ selectedTable }}
                </h2>
                <button
                  @click="openCreateModal"
                  class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition text-sm font-bold flex flex-row items-center gap-1"
                >
                  <CirclePlus class="" />Add
                </button>
              </div>

              <div class="mb-2">
                <input
                  v-model="searchQuery"
                  @keyup.enter="handleSearch"
                  type="text"
                  placeholder="Search..."
                  class="w-full px-3 py-1 text-sm border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                />
              </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col">
              <div v-if="recordsLoading" class="text-center text-gray-500 dark:text-gray-400 py-3 text-sm">
                Loading records...
              </div>

              <div v-else-if="records.length === 0" class="text-center text-gray-500 dark:text-gray-400 py-3 text-sm">
                No records found
              </div>

              <div v-else class="overflow-y-auto flex-1 min-h-0">
                <table class="w-full border-collapse text-sm">
                  <thead class="sticky top-0 bg-gray-100 dark:bg-gray-600 border-b border-gray-300 dark:border-gray-500">
                    <tr>
                      <th
                        v-for="column in visibleColumns"
                        :key="column"
                        @click="handleSort(column)"
                        class="px-2 py-1 text-left text-gray-900 dark:text-white font-semibold cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-500 transition whitespace-nowrap text-xs"
                      >
                        <div class="flex items-center gap-1">
                          {{ column }}
                          <span v-if="sortBy === column" class="text-xs">
                            {{ sortOrder === 'asc' ? '▲' : '▼' }}
                          </span>
                        </div>
                      </th>
                      <th class="px-2 py-1 text-left text-gray-900 dark:text-white font-semibold whitespace-nowrap text-xs">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="record in records"
                      :key="record.id"
                      class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition"
                    >
                      <td
                        v-for="column in visibleColumns"
                        :key="`${record.id}-${column}`"
                        class="px-2 py-1 text-gray-700 dark:text-gray-300 truncate max-w-xs text-xs"
                        :title="String(record[column])"
                      >
                        {{ record[column] }}
                      </td>
                      <td class="px-2 py-1 flex gap-1 whitespace-nowrap">
                        <button
                          @click="openEditModal(record)"
                          class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition"
                        >
                          <SquarePen />  
                        </button>
                        <button
                          @click="deleteRecord(record.id)"
                          class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition"
                        >
                          <Trash2 />
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div v-if="totalPages > 1" class="flex-shrink-0 border-t border-gray-200 dark:border-gray-600 mt-2 pt-2 flex justify-center items-center gap-1">
                <button
                  v-if="currentPage > 1"
                  @click="goToPage(currentPage - 1)"
                  class="px-2 py-1 border border-gray-300 dark:border-gray-500 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition text-xs"
                >
                  ← Prev
                </button>

                <button
                  v-for="page in paginationRange"
                  :key="page"
                  @click="typeof page === 'number' && goToPage(page)"
                  :disabled="page === '...'"
                  :class="[
                    'px-2 py-1 rounded transition text-xs',
                    page === currentPage
                      ? 'bg-blue-500 text-white'
                      : page === '...'
                      ? 'cursor-default'
                      : 'border border-gray-300 dark:border-gray-500 hover:bg-gray-100 dark:hover:bg-gray-600'
                  ]"
                >
                  {{ page }}
                </button>

                <button
                  v-if="currentPage < totalPages"
                  @click="goToPage(currentPage + 1)"
                  class="px-2 py-1 border border-gray-300 dark:border-gray-500 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition text-xs"
                >
                  Next →
                </button>
              </div>

              <div class="flex-shrink-0 text-xs text-gray-500 dark:text-gray-400 mt-2 px-2" v-else-if="totalRecords != 0">
                {{ (currentPage - 1) * perPage + 1 }}-{{ Math.min(currentPage * perPage, totalRecords) }} of {{ totalRecords }}
              </div>
            </div>

            <div v-if="!selectedTable" class="text-center text-gray-500 dark:text-gray-400 py-12">
              Select a table from the list on the left to get started
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="showEditModal || showCreateModal"
      class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 p-4"
      @click="showEditModal ? closeEditModal() : closeCreateModal()"
    >
      <div
        class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-4 max-w-sm w-full"
        @click.stop
      >
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
          {{ editingRecord ? "Edit Record" : "Create New Record" }}
        </h3>

        <div class="space-y-3 mb-4 max-h-80 overflow-y-auto">
          <div
            v-for="field in fillable"
            :key="field"
            :class="['flex', isBooleanField(field) ? 'flex-row items-center gap-2' : 'flex-col']"
          >
            <template v-if="isBooleanField(field)">
              <input
                :id="`field-${field}`"
                v-model="editFormData[field]"
                type="checkbox"
                class="w-4 h-4 rounded border-gray-300 dark:border-gray-500 cursor-pointer"
              />
              <label 
                :for="`field-${field}`"
                class="text-xs font-medium text-gray-700 dark:text-gray-300 cursor-pointer"
              >
                {{ field }}
              </label>
            </template>

            <template v-else-if="isForeignKeyField(field)">
              <label class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ field }}
              </label>
              <select
                v-model="editFormData[field]"
                class="px-2 py-1 text-xs border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-900 dark:text-white"
              >
                <option value="">
                  Select {{ getForeignKeySourceTable(field) }}
                </option>
                <option
                  v-if="isForeignKeyLoading(field)"
                  disabled
                  value=""
                >
                  Loading options...
                </option>
                <option
                  v-for="option in getForeignKeyOptions(field)"
                  :key="`${field}-${option.value}`"
                  :value="option.value"
                >
                  {{ option.label }} ({{ option.value }})
                </option>
              </select>
            </template>

            <template v-else>
              <label class="text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                {{ field }}
              </label>
              <input
                v-model="editFormData[field]"
                type="text"
                :placeholder="`Enter ${field}`"
                class="px-2 py-1 text-xs border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
              />
            </template>
          </div>
        </div>

        <div class="flex gap-2 justify-end">
          <button
            @click="showEditModal ? closeEditModal() : closeCreateModal()"
            class="px-3 py-1 text-xs border border-gray-300 dark:border-gray-500 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition text-gray-900 dark:text-white"
          >
            Cancel
          </button>
          <button
            @click="saveRecord"
            class="px-3 py-1 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded transition"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
