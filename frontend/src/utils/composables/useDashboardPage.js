import { computed, onMounted, ref } from "vue"

export function useDashboardPage() {
  const tables = ref([])
  const selectedTable = ref(null)
  const records = ref([])
  const columns = ref([])
  const loading = ref(true)
  const recordsLoading = ref(false)
  const currentPage = ref(1)
  const perPage = ref(15)
  const searchQuery = ref("")
  const sortBy = ref("id")
  const sortOrder = ref("asc")
  const totalPages = ref(1)
  const totalRecords = ref(0)

  const token = localStorage.getItem("token")

  const showEditModal = ref(false)
  const showCreateModal = ref(false)
  const editingRecord = ref(null)
  const editFormData = ref({})
  const fillable = ref([])
  const foreignKeyOptions = ref({})
  const tableStructureCache = ref({})

  async function getTables() {
    try {
      const response = await fetch("http://backend.vm1.test/api/admin/tables", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      if (!response.ok) throw new Error("Failed to fetch tables")
      const data = await response.json()
      tables.value = data.data || []
    } catch (err) {
      console.error("Error fetching tables:", err)
      alert("Failed to load tables. Make sure you're an admin.")
    }
  }

  async function selectTable(tableName) {
    selectedTable.value = tableName
    currentPage.value = 1
    searchQuery.value = ""
    await loadTableRecords()
    await loadTableStructure()
  }

  async function loadTableRecords() {
    if (!selectedTable.value) return

    recordsLoading.value = true
    try {
      const params = new URLSearchParams({
        per_page: perPage.value,
        page: currentPage.value,
        search: searchQuery.value,
        sort_by: sortBy.value,
        sort_order: sortOrder.value,
      })

      const response = await fetch(
        `http://backend.vm1.test/api/admin/tables/${selectedTable.value}/records?${params}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )
      if (!response.ok) throw new Error("Failed to fetch records")

      const data = await response.json()
      records.value = data.data || []
      columns.value = data.columns || []
      totalRecords.value = data.pagination.total
      totalPages.value = data.pagination.last_page
    } catch (err) {
      console.error("Error loading records:", err)
      alert("Failed to load records")
    } finally {
      recordsLoading.value = false
    }
  }

  async function loadTableStructure() {
    if (!selectedTable.value) return

    try {
      const response = await fetch(
        `http://backend.vm1.test/api/admin/tables/${selectedTable.value}/structure`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )
      if (!response.ok) throw new Error("Failed to fetch structure")

      const data = await response.json()
      fillable.value = data.fillable || []
      await loadForeignKeyOptionsForFields(fillable.value)
    } catch (err) {
      console.error("Error loading structure:", err)
    }
  }

  function singularizeTableName(tableName) {
    if (tableName.endsWith("ies")) return `${tableName.slice(0, -3)}y`
    if (tableName.endsWith("s")) return tableName.slice(0, -1)
    return tableName
  }

  function getForeignKeyCandidatesForTable(tableName) {
    const singular = singularizeTableName(tableName)
    return [`${singular}_id`, `${tableName}_id`]
  }

  async function getTableStructure(tableName) {
    if (tableStructureCache.value[tableName]) {
      return tableStructureCache.value[tableName]
    }

    const response = await fetch(
      `http://backend.vm1.test/api/admin/tables/${tableName}/structure`,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    )

    if (!response.ok) throw new Error(`Failed to fetch structure for ${tableName}`)

    const data = await response.json()
    const structure = {
      fillable: data.fillable || [],
    }
    tableStructureCache.value[tableName] = structure
    return structure
  }

  async function fetchAllRecordsForTable(tableName) {
    const all = []
    let page = 1
    let lastPage = 1

    do {
      const params = new URLSearchParams({
        per_page: "200",
        page: String(page),
        search: "",
        sort_by: "id",
        sort_order: "asc",
      })

      const response = await fetch(
        `http://backend.vm1.test/api/admin/tables/${tableName}/records?${params}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )

      if (!response.ok) throw new Error(`Failed to fetch records from ${tableName}`)

      const data = await response.json()
      all.push(...(data.data || []))
      lastPage = data.pagination?.last_page || 1
      page += 1
    } while (page <= lastPage)

    return all
  }

  async function deleteRecordDirect(tableName, recordId) {
    const response = await fetch(
      `http://backend.vm1.test/api/admin/tables/${tableName}/records/${recordId}`,
      {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    )

    if (!response.ok) {
      throw new Error(`Failed to delete record ${recordId} from ${tableName}`)
    }
  }

  async function getDependentTables(parentTableName) {
    const parentFkCandidates = getForeignKeyCandidatesForTable(parentTableName)
    const dependentTables = []

    for (const table of tables.value) {
      const tableName = table.name
      if (tableName === parentTableName) continue

      try {
        const structure = await getTableStructure(tableName)
        const matchedField = structure.fillable.find((field) => parentFkCandidates.includes(field))

        if (matchedField) {
          dependentTables.push({
            tableName,
            foreignKeyField: matchedField,
          })
        }
      } catch (err) {
        console.error(`Skipping dependency check for ${tableName}:`, err)
      }
    }

    return dependentTables
  }

  async function cascadeDeleteRecord(tableName, recordId, visited = new Set()) {
    const visitKey = `${tableName}:${recordId}`
    if (visited.has(visitKey)) return
    visited.add(visitKey)

    const dependents = await getDependentTables(tableName)

    for (const dependent of dependents) {
      const rows = await fetchAllRecordsForTable(dependent.tableName)
      const linkedRows = rows.filter((row) => Number(row[dependent.foreignKeyField]) === Number(recordId))

      for (const linkedRow of linkedRows) {
        await cascadeDeleteRecord(dependent.tableName, linkedRow.id, visited)
      }
    }

    await deleteRecordDirect(tableName, recordId)
  }

  function isForeignKeyField(field) {
    return field.endsWith("_id") && field !== "id"
  }

  function getReferencedTableCandidates(field) {
    const base = field.replace(/_id$/, "")
    const candidates = [base, `${base}s`]

    if (base.endsWith("y")) {
      candidates.push(`${base.slice(0, -1)}ies`)
    }

    return candidates
  }

  function resolveReferencedTable(field) {
    const candidates = getReferencedTableCandidates(field)
    const available = new Set(tables.value.map((t) => t.name))

    for (const candidate of candidates) {
      if (available.has(candidate)) return candidate
    }

    return candidates[0]
  }

  function getBestLabel(record) {
    const preferred = ["name", "username", "title", "full_name", "display_name", "email", "slug"]

    for (const key of preferred) {
      if (record[key] !== undefined && record[key] !== null && String(record[key]).trim() !== "") {
        return String(record[key])
      }
    }

    const fallbackKey = Object.keys(record).find((key) => {
      if (["id", "created_at", "updated_at", "deleted_at"].includes(key)) return false
      const value = record[key]
      return typeof value === "string" && value.trim() !== ""
    })

    if (fallbackKey) return String(record[fallbackKey])
    return `ID ${record.id}`
  }

  async function loadForeignKeyOptions(field) {
    if (!isForeignKeyField(field)) return

    const sourceTable = resolveReferencedTable(field)
    foreignKeyOptions.value[field] = {
      loading: true,
      sourceTable,
      options: [],
    }

    try {
      const params = new URLSearchParams({
        per_page: "200",
        page: "1",
        search: "",
        sort_by: "id",
        sort_order: "asc",
      })

      const response = await fetch(
        `http://backend.vm1.test/api/admin/tables/${sourceTable}/records?${params}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      )

      if (!response.ok) throw new Error(`Failed to fetch options for ${field}`)

      const data = await response.json()
      const rows = data.data || []

      foreignKeyOptions.value[field] = {
        loading: false,
        sourceTable,
        options: rows
          .filter((row) => row.id !== undefined && row.id !== null)
          .map((row) => ({
            value: row.id,
            label: getBestLabel(row),
          })),
      }
    } catch (err) {
      console.error(`Error loading foreign key options for ${field}:`, err)
      foreignKeyOptions.value[field] = {
        loading: false,
        sourceTable,
        options: [],
      }
    }
  }

  async function loadForeignKeyOptionsForFields(fields) {
    const fkFields = fields.filter((field) => isForeignKeyField(field))
    await Promise.all(fkFields.map((field) => loadForeignKeyOptions(field)))
  }

  async function deleteRecord(recordId) {
    if (!confirm("Are you sure you want to delete this record?")) return

    try {
      recordsLoading.value = true
      await cascadeDeleteRecord(selectedTable.value, recordId)

      alert("Record deleted successfully")
      await loadTableRecords()
    } catch (err) {
      console.error("Error deleting record:", err)
      alert("Failed to delete record. It may still be referenced by another record.")
    } finally {
      recordsLoading.value = false
    }
  }

  function openEditModal(record) {
    editingRecord.value = record
    editFormData.value = { ...record }
    showEditModal.value = true
  }

  function openCreateModal() {
    editingRecord.value = null
    editFormData.value = {}
    fillable.value.forEach((field) => {
      if (!Object.prototype.hasOwnProperty.call(editFormData.value, field)) {
        if (isBooleanField(field)) {
          editFormData.value[field] = false
        } else if (isForeignKeyField(field)) {
          editFormData.value[field] = ""
        } else {
          editFormData.value[field] = ""
        }
      }
    })
    showCreateModal.value = true
  }

  function isBooleanField(field) {
    const booleanKeywords = ["is", "has", "admin", "repeatable", "verified"]
    return booleanKeywords.some((keyword) => field.toLowerCase().includes(keyword))
  }

  function getForeignKeyOptions(field) {
    return foreignKeyOptions.value[field]?.options || []
  }

  function isForeignKeyLoading(field) {
    return foreignKeyOptions.value[field]?.loading === true
  }

  function getForeignKeySourceTable(field) {
    return foreignKeyOptions.value[field]?.sourceTable || resolveReferencedTable(field)
  }

  async function saveRecord() {
    const payload = {}
    fillable.value.forEach((field) => {
      if (Object.prototype.hasOwnProperty.call(editFormData.value, field)) {
        if (isForeignKeyField(field)) {
          payload[field] = editFormData.value[field] === "" ? null : Number(editFormData.value[field])
        } else {
          payload[field] = editFormData.value[field]
        }
      }
    })

    try {
      let response
      if (editingRecord.value) {
        response = await fetch(
          `http://backend.vm1.test/api/admin/tables/${selectedTable.value}/records/${editingRecord.value.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(payload),
          }
        )
      } else {
        response = await fetch(
          `http://backend.vm1.test/api/admin/tables/${selectedTable.value}/records`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(payload),
          }
        )
      }

      if (!response.ok) throw new Error("Failed to save record")

      alert(editingRecord.value ? "Record updated successfully" : "Record created successfully")
      showEditModal.value = false
      showCreateModal.value = false
      await loadTableRecords()
    } catch (err) {
      console.error("Error saving record:", err)
      alert("Failed to save record")
    }
  }

  function closeEditModal() {
    showEditModal.value = false
    editingRecord.value = null
    editFormData.value = {}
  }

  function closeCreateModal() {
    showCreateModal.value = false
    editFormData.value = {}
  }

  function handleSearch() {
    currentPage.value = 1
    loadTableRecords()
  }

  function handleSort(column) {
    if (sortBy.value === column) {
      sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc"
    } else {
      sortBy.value = column
      sortOrder.value = "asc"
    }
    loadTableRecords()
  }

  function goToPage(page) {
    currentPage.value = page
    loadTableRecords()
  }

  const visibleColumns = computed(() => columns.value.filter((col) => !["password", "remember_token"].includes(col)))

  const paginationRange = computed(() => {
    const range = []
    const maxVisible = 5
    let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2))
    let end = Math.min(totalPages.value, start + maxVisible - 1)

    if (end - start < maxVisible - 1) {
      start = Math.max(1, end - maxVisible + 1)
    }

    if (start > 1) range.push(1)
    if (start > 2) range.push("...")

    for (let i = start; i <= end; i += 1) {
      range.push(i)
    }

    if (end < totalPages.value - 1) range.push("...")
    if (end < totalPages.value) range.push(totalPages.value)

    return range
  })

  onMounted(async () => {
    try {
      await getTables()
    } finally {
      loading.value = false
    }
  })

  return {
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
  }
}
