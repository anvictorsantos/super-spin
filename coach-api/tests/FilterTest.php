<?php

require_once realpath(dirname(__FILE__) . '/../src/Database/Database.php');
require_once realpath(dirname(__FILE__) . '/../src/Helpers/FilterSort.php');

use Database\Database;
use Helpers\FilterSort;

function runTests(): void
{
    testGetCoaches();
    testFilterAndSort();
}

function testGetCoaches(): void
{
    $db = new Database();
    $connection = $db->getConnection();

    // Insert mock data for testing
    $connection->exec("DELETE FROM coach");
    $connection->exec("
        INSERT INTO coach
        (name, years_of_experience, hourly_rate, location, joined_at)
        VALUES
        ('John Smith', 5, 50, 'New York, USA', '2023-05-10'),
        ('Emma Johnson', 8, 65, 'London, UK', '2021-03-15'),
        ('Liam Brown', 3, 40, 'Sydney, Australia', '2022-07-20'),
        ('Sophia Garcia', 10, 80, 'Los Angeles, USA', '2020-01-25'),
        ('Noah Wilson', 1, 35, 'Toronto, Canada', '2024-09-12');
    ");

    // Fetch data
    $sql = "SELECT * FROM coach";
    $stmt = $connection->query($sql);
    $actual = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $expected = [
        ['id' => '1', 'name' => 'John Doe'],
        ['id' => '2', 'name' => 'Jane Doe'],
        ['id' => '3', 'name' => 'Jim Doe'],
        ['id' => '4', 'name' => 'Jill Doe']
    ];

    assert($expected === $actual, 'testGetCoaches');
}

function testFilterAndSort(): void
{
    $coaches = [
        ['id' => 1, 'name' => 'John Doe'],
        ['id' => 2, 'name' => 'Jane Doe'],
        ['id' => 3, 'name' => 'Jim Doe'],
        ['id' => 4, 'name' => 'Jill Doe']
    ];

    $filter = 'John'; // Filter for coaches with "John" in their name
    $sort = 'asc'; // Sort order

    $expected = [
        ['id' => 1, 'name' => 'John Doe']
    ];

    // Call the filterAndSort utility
    $actual = FilterSort::filterAndSort($coaches, $filter, $sort);

    assert($expected === $actual, 'testFilterAndSort');
}

// Run the tests
runTests();
