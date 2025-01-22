<template>
  <div>
    <div v-if="header">
      <h2>
        {{ header.title }}
      </h2>
      <p>
        {{ header.description }}
      </p>
    </div>
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
          <td v-if="rowSelector">
            <div>
              <input :id="`contact-${index}`" v-model="item.selected" type="checkbox" />
            </div>
          </td>
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

<script lang="ts">
import { defineComponent, type PropType, ref } from 'vue'

interface Field {
  key: string
  label: string
}

interface Header {
  title: string
  description: string
}

interface RowData {
  [key: string]: any
  selected?: boolean
}

export default defineComponent({
  name: 'TableComponent',
  props: {
    data: {
      type: Array as PropType<RowData[]>,
      required: true,
      default: () => [],
    },
    header: {
      type: Object as PropType<Header | null>,
      required: false,
      default: null,
    },
    fields: {
      type: Array as PropType<Field[]>,
      required: true,
      default: () => [],
    },
    rowSelector: {
      type: Boolean,
      required: false,
      default: false,
    },
    // Prop to specify which columns are sortable
    sortableFields: {
      type: Array as PropType<string[]>,
      required: true,
      default: () => [],
    },
  },
  emits: ['rowSelected', 'sortChanged'],
  setup(props, { emit, slots }) {
    const hasNamedSlot = (slotName: string) => !!slots[slotName]

    // Sorting configuration: key (field) and order ('asc' or 'desc')
    const sortConfig = ref({ key: '', order: 'asc' })

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

    return {
      hasNamedSlot,
      sortBy,
      sortConfig,
    }
  },
})
</script>

<style scoped>
.sortable-header {
  cursor: pointer;
}

.asc-icon,
.desc-icon {
  font-size: 12px;
  margin-left: 5px;
}
</style>
