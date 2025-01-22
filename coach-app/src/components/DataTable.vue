<template>
  <div>
    <slot name="filter"></slot>
    <table>
      <slot name="caption"></slot>
      <thead>
        <tr>
          <th v-for="(item, idx) in fields" :key="idx" scope="col">
            <span @click="sortBy(item.key)">
              {{ item.label }}
              <span v-if="sortableFields.includes(item.key)">
                <ArrowDownIcon v-if="sortConfig.key === item.key && sortConfig.order === 'desc'" />
                <ArrowUpIcon v-if="sortConfig.key === item.key && sortConfig.order === 'asc'" />
              </span>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in paginatedData" :key="index">
          <td v-for="(field, idx) in fields" :key="idx" :data-label="field.label">
            <span v-if="!hasNamedSlot(field.key)" :item="item">
              {{ item[field.key] }}
            </span>
            <slot v-else :name="field.key" :item="item" />
          </td>
        </tr>
      </tbody>
    </table>

    <slot name="no-records"></slot>

    <!-- Pagination controls -->
    <div class="pagination">
      <button @click="prevPage" :disabled="currentPage === 1">Prev</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, onMounted, computed, useSlots } from 'vue'
import type { Field } from '@/types/Field'
import type { RowData } from '@/types/RowData'
import ArrowUpIcon from '@/component-library/icons/ArrowUpIcon.vue'
import ArrowDownIcon from '@/component-library/icons/ArrowDownIcon.vue'

// Define the props
const props = defineProps<{
  data: RowData[]
  fields: Field[]
  sortableFields: string[]
}>()

// Define the emits
const emit = defineEmits<{
  (e: 'rowSelected', selectedRow: RowData): void
  (e: 'sortChanged', sortConfig: { key: string; order: 'asc' | 'desc' }): void
}>()

const slots = useSlots() as Record<string, unknown>

// Sorting configuration
const sortConfig = ref<{ key: string; order: 'asc' | 'desc' }>({ key: '', order: 'asc' })

// Pagination configuration
const itemsPerPage = 5
const currentPage = ref(1)

// Computed: Total pages based on the data and items per page
const totalPages = computed(() => {
  return Math.ceil(props.data.length / itemsPerPage)
})

// Computed: Data for the current page after sorting
const paginatedData = computed(() => {
  const sortedData = [...props.data]

  // Sort the data
  sortedData.sort((a, b) => {
    if (a[sortConfig.value.key] < b[sortConfig.value.key]) {
      return sortConfig.value.order === 'asc' ? -1 : 1
    }
    if (a[sortConfig.value.key] > b[sortConfig.value.key]) {
      return sortConfig.value.order === 'asc' ? 1 : -1
    }
    return 0
  })

  // Paginate the data
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return sortedData.slice(start, end)
})

// Check for named slots
const hasNamedSlot = (slotName: string) => !!slots[slotName]

// Initialize default sorting
onMounted(() => {
  if (props.sortableFields.length > 0) {
    sortConfig.value.key = props.sortableFields[0]
    sortConfig.value.order = 'asc'
    emit('sortChanged', sortConfig.value)
  }
})

// Sort the table based on a specific field and order
const sortBy = (key: string) => {
  if (sortConfig.value.key === key) {
    sortConfig.value.order = sortConfig.value.order === 'asc' ? 'desc' : 'asc'
  } else {
    sortConfig.value.key = key
    sortConfig.value.order = 'asc'
  }
  emit('sortChanged', sortConfig.value)
}

// Pagination: Navigate to the previous page
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1
  }
}

// Pagination: Navigate to the next page
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1
  }
}
</script>
