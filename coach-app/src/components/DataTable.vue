<template>
  <div>
    <table>
      <thead>
        <tr>
          <th v-for="(item, idx) in fields" :key="idx">
            <span @click="sortBy(item.key)" class="sortable-header">
              {{ item.label }}
              <!-- Show ascending or descending icon if the field is sortable -->
              <span v-if="sortableFields.includes(item.key)">
                <i v-if="sortConfig.key === item.key && sortConfig.order === 'asc'" class="asc-icon"
                  >▲</i
                >
                <i
                  v-if="sortConfig.key === item.key && sortConfig.order === 'desc'"
                  class="desc-icon"
                  >▼</i
                >
              </span>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td v-for="(field, idx) in fields" :key="idx">
            <span v-if="!hasNamedSlot(field.key)" :item="item">
              {{ item[field.key] }}
            </span>
            <slot v-else :name="field.key" :item="item" />
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="hasNamedSlot('footer')">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, useSlots } from 'vue'
import type { Field } from '@/types/Field'
import type { RowData } from '@/types/RowData'

// Define the props
const props = defineProps<{
  data: RowData[]
  fields: Field[]
  sortableFields: string[]
}>()

// Define the emits with correct typing for event names and parameters
const emit = defineEmits<{
  (e: 'rowSelected', selectedRow: RowData): void
  (e: 'sortChanged', sortConfig: { key: string; order: 'asc' | 'desc' }): void
}>()

// Access slots using useSlots() and define its type
const slots = useSlots() as Record<string, unknown>

// Sorting configuration with strict types for order
const sortConfig = ref<{ key: string; order: 'asc' | 'desc' }>({ key: '', order: 'asc' })

// Function to check for named slots
const hasNamedSlot = (slotName: string) => !!slots[slotName]

// Sort the table based on a specific field and order
const sortBy = (key: string) => {
  // Check if it's the same column
  if (sortConfig.value.key === key) {
    // Toggle sorting order if the same column is clicked
    sortConfig.value.order = sortConfig.value.order === 'asc' ? 'desc' : 'asc'
  } else {
    // Set new column and default to ascending order
    sortConfig.value.key = key
    sortConfig.value.order = 'asc'
  }

  // Emit event to update sorted data in the parent component
  emit('sortChanged', sortConfig.value)

  // Sort data based on the selected column and order
  props.data.sort((a, b) => {
    if (a[key] < b[key]) {
      return sortConfig.value.order === 'asc' ? -1 : 1
    }
    if (a[key] > b[key]) {
      return sortConfig.value.order === 'asc' ? 1 : -1
    }
    return 0
  })
}
</script>
