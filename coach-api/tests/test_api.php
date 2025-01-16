<?php
require_once '../src/database.php';
require_once '../src/filter_and_sort.php';

function runTests(): void   {
    testGetCoaches();
    testFilterAndSort();
}

function testGetCoaches(): void {
    $expected = [
        ['id' => 1, 'name' => 'John Doe'],
        ['id' => 2, 'name' => 'Jane Doe'],
        ['id' => 3, 'name' => 'Jim Doe'],
        ['id' => 4, 'name' => 'Jill Doe']
    ];
    $actual = getCoaches();
    assert($expected === $actual, 'testGetCoaches');
}

function testFilterAndSort(): void {
    $coaches = [
        ['id' => 1, 'name' => 'John Doe'],
        ['id' => 2, 'name' => 'Jane Doe'],
        ['id' => 3, 'name' => 'Jim Doe'],
        ['id' => 4, 'name' => 'Jill Doe']
    ];
    $filter = '?filter=John';
    $sort = '?sort=asc';
    $expected = [
        ['id' => 1, 'name' => 'John Doe']
    ];
    $actual = filterAndSort($coaches, $filter, $sort);
    assert($expected === $actual, 'testFilterAndSort');
}
