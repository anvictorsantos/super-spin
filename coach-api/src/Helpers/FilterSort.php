<?php

namespace Helpers;

class FilterSort
{
    /**
     * Filters and sorts an array based on filter and sort parameters.
     *
     * @param array $data The array to filter and sort.
     * @param string $filter The filter string.
     * @param string $sort The sort direction (asc or desc).
     * @return array The filtered and sorted array.
     */
    public static function filterAndSort(array $coaches, string $filter = '', string $sort = 'asc'): array
    {
        // Filter by name or location (case insensitive)
        $filteredData = array_filter($coaches, function ($coach) use ($filter) {
            $nameMatch = empty($filter) || stripos($coach['name'], $filter) !== false;
            $locationMatch = empty($filter) || stripos($coach['location'], $filter) !== false;
            return $nameMatch || $locationMatch; // Match either name or location
        });

        // Sort by hourly_rate (ascending or descending)
        usort($filteredData, function ($a, $b) use ($sort) {
            return $sort === 'asc'
                ? $a['hourly_rate'] <=> $b['hourly_rate']
                : $b['hourly_rate'] <=> $a['hourly_rate'];
        });

        return $filteredData;
    }

}
