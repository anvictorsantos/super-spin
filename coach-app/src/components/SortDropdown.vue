<template>
  <select class="sort-dropdown" @change="onChange">
    <option value="" disabled selected>Sort by hourly rate</option>
    <option value="asc">Ascending</option>
    <option value="desc">Descending</option>
  </select>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'SortDropdown',
  emits: ['sort'],
  setup(_, { emit }) {
    const onChange = (event: Event) => {
      const target = event.target as HTMLSelectElement
      emit('sort', target.value as 'asc' | 'desc')
    }

    return { onChange }
  },
})
</script>

<style scoped>
.sort-dropdown {
  padding: 0.5rem;
  margin: 1rem 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
