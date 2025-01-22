<?php

use Helpers\FilterSort;

class FilterSortTest extends PHPUnit\Framework\TestCase
{
    public function testFilterByNameOrLocation(): void
    {
        $coaches = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
        ];

        // Test filter by name ("John")
        $filter = 'John'; // Should match "John Smith"
        $expected = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
        ];
        $result = FilterSort::filterAndSort($coaches, $filter, 'asc');
        $this->assertEquals($expected, $result);

        // Test filter by location ("London")
        $filter = 'London'; // Should match "Emma Johnson" in London
        $expected = [
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15']
        ];
        $result = FilterSort::filterAndSort($coaches, $filter, 'asc');
        $this->assertEquals($expected, $result);

        // Test filter that matches both name and location
        $filter = 'Liam'; // Should match "Liam Brown"
        $expected = [
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20']
        ];
        $result = FilterSort::filterAndSort($coaches, $filter, 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortAscending(): void
    {
        $coaches = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
        ];

        // Sort by hourly_rate in ascending order
        $expected = [
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
        ];

        $result = FilterSort::filterAndSort($coaches, '', 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortDescending(): void
    {
        $coaches = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
        ];

        // Sort by hourly_rate in descending order
        $expected = [
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
        ];

        $result = FilterSort::filterAndSort($coaches, '', 'desc');
        $this->assertEquals($expected, $result);
    }

    public function testFilterAndSortByFilterAndSortParams(): void
    {
        $coaches = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
            ['id' => 3, 'name' => 'Liam Brown', 'hourly_rate' => 40, 'location' => 'Sydney', 'joined_at' => '2022-07-20'],
            ['id' => 4, 'name' => 'Sophia Garcia', 'hourly_rate' => 80, 'location' => 'Los Angeles', 'joined_at' => '2020-01-25'],
            ['id' => 5, 'name' => 'Noah Wilson', 'hourly_rate' => 35, 'location' => 'Toronto', 'joined_at' => '2024-09-12'],
        ];

        // Test filtering by name ("John") and sorting by hourly_rate (asc)
        $filter = 'John';
        $sort = 'asc';
        $expected = [
            ['id' => 1, 'name' => 'John Smith', 'hourly_rate' => 50, 'location' => 'New York', 'joined_at' => '2023-05-10'],
            ['id' => 2, 'name' => 'Emma Johnson', 'hourly_rate' => 65, 'location' => 'London', 'joined_at' => '2021-03-15'],
        ];
        $result = FilterSort::filterAndSort($coaches, $filter, $sort);
        $this->assertEquals($expected, $result);
    }
}

