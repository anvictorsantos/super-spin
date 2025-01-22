<template>
  <select class="sort-dropdown" @change="onChange">
    <option value="" disabled selected>Sort by hourly rate</option>
    <option value="asc">Ascending</option>
    <option value="desc">Descending</option>
  </select>
</template>

<script setup lang="ts">
import { defineEmits } from 'vue'

// Define emits using defineEmits
const emit = defineEmits<{
  (e: 'sort', direction: 'asc' | 'desc' | ''): void
}>()

// Event handler for the dropdown change
const onChange = (event: Event) => {
  const target = event.target as HTMLSelectElement
  emit('sort', target.value as 'asc' | 'desc' | '') // Emit the selected sort direction
}
</script>

<style scoped></style>
