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
    public static function filterAndSort(array $coaches, string $filterName = '', string $filterLocation = '', string $sort = 'asc'): array
    {
        // Filter by name and location (both case insensitive)
        $filteredData = array_filter($coaches, function ($coach) use ($filterName, $filterLocation) {
            $nameMatch = empty($filterName) || stripos($coach['name'], $filterName) !== false;
            $locationMatch = empty($filterLocation) || stripos($coach['location'], $filterLocation) !== false;
            return $nameMatch && $locationMatch;
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
