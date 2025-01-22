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
          <th v-if="rowSelector">
            <div>
              <input id="contact-selectAll" type="checkbox" @change="selectAll" />
            </div>
          </th>
          <th v-for="(item, idx) in fields" :key="idx">
            {{ item.label }}
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
          <td v-for="(field, idx) in fields" :key="idx" @click="rowSelected(item)">
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
  },
  emits: ['rowSelected'],
  setup(props, { emit, slots }) {
    const selectAll = (e: Event) => {
      const checked = (e.target as HTMLInputElement).checked
      props.data.forEach((item) => {
        item.selected = checked
      })
    }

    const rowSelected = (item: RowData) => {
      emit('rowSelected', item)
    }

    const hasNamedSlot = (slotName: string) => !!slots[slotName]

    return {
      selectAll,
      rowSelected,
      hasNamedSlot,
    }
  },
})
</script>
