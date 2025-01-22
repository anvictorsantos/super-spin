import { mount } from '@vue/test-utils'
import { defineComponent, ref } from 'vue'
import DataTable from '../src/components/DataTable.vue'
import SearchBar from '../src/components/SearchBar.vue'
import { expect, it, vi } from 'vitest'

// Mock the necessary props
const mockFields = [
  { key: 'name', label: 'Name' },
  { key: 'location', label: 'Location' },
  { key: 'hourly_rate', label: 'Hourly Rate' },
]

const mockData = [
  { name: 'John Doe', location: 'New York', hourly_rate: 100 },
  { name: 'Jane Smith', location: 'London', hourly_rate: 120 },
]

it('should render the DataTable correctly with fields', async () => {
  const wrapper = mount(DataTable, {
    props: {
      fields: mockFields,
      data: mockData,
      sortableFields: ['hourly_rate'],
    },
  })

  // Check if fields are rendered correctly
  mockFields.forEach((field) => {
    expect(wrapper.text()).toContain(field.label)
  })

  // Check if the data is rendered correctly
  mockData.forEach((row) => {
    expect(wrapper.text()).toContain(row.name)
    expect(wrapper.text()).toContain(row.location)
    expect(wrapper.text()).toContain(row.hourly_rate.toString())
  })
})

it('should filter data based on search query', async () => {
  const wrapper = mount(SearchBar, {
    props: {
      search: 'John',
    },
  })

  const input = wrapper.find('input')
  await input.setValue('Jane')

  // Check if the component emits the correct search query
  const emitted = wrapper.emitted('search')
  expect(emitted).toBeTruthy()
  expect(emitted![0][0]).toBe('Jane')
})
