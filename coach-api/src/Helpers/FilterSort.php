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
     public static function filterAndSort(array $data, string $filter = '', string $sort = 'asc'): array
    {
        // Filter the data
        if (!empty($filter)) {
            $data = array_filter($data, function ($item) use ($filter) {
                return stripos($item['name'], $filter) !== false;
            });
        }

        // Sort the data
        usort($data, function ($a, $b) use ($sort) {
            return $sort === 'desc' ? strcmp($b['name'], $a['name']) : strcmp($a['name'], $b['name']);
        });

        return $data;
    }
}
