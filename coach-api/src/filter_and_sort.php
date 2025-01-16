<?php
function filterAndSort(array $coaches, string $filter, string $sort): array {
    $filteredCoaches = [];
    foreach ($coaches as $coach) {
        if (stripos($coach['name'], $filter) !== false) {
            $filteredCoaches[] = $coach;
        }
    }
    usort($filteredCoaches, function ($a, $b) use ($sort) {
        return $sort === 'asc' ? strcmp($a['name'], $b['name']) : strcmp($b['name'], $a['name']);
    });
    return $filteredCoaches;
}
