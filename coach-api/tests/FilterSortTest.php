<?php

use Helpers\FilterSort;
use PHPUnit\Framework\TestCase;

class FilterSortTest extends TestCase
{
    public function testFilterAndSortByNameAndLocation()
    {
        // Sample coaches data
        $coaches = [
            ['id' => 1, 'name' => 'John Doe', 'location' => 'New York, USA', 'hourly_rate' => 50],
            ['id' => 2, 'name' => 'Jane Doe', 'location' => 'London, UK', 'hourly_rate' => 65],
            ['id' => 3, 'name' => 'Jim Doe', 'location' => 'New York, USA', 'hourly_rate' => 40],
            ['id' => 4, 'name' => 'Jill Doe', 'location' => 'Los Angeles, USA', 'hourly_rate' => 70]
        ];

        // Filter by "Doe" in name and "USA" in location, sort by hourly_rate ascending
        $filterName = 'Doe';
        $filterLocation = 'USA';
        $sort = 'asc';
        $expected = [
            ['id' => 3, 'name' => 'Jim Doe', 'location' => 'New York, USA', 'hourly_rate' => 40],
            ['id' => 1, 'name' => 'John Doe', 'location' => 'New York, USA', 'hourly_rate' => 50],
            ['id' => 4, 'name' => 'Jill Doe', 'location' => 'Los Angeles, USA', 'hourly_rate' => 70]
        ];

        // Call the method
        $actual = FilterSort::filterAndSort($coaches, $filterName, $filterLocation, $sort);

        // Assert that the result matches the expected outcome
        $this->assertEquals($expected, $actual);
    }

    public function testFilterAndSortWithNoMatches()
    {
        // Sample coaches data
        $coaches = [
            ['id' => 1, 'name' => 'John Doe', 'location' => 'New York, USA', 'hourly_rate' => 50],
            ['id' => 2, 'name' => 'Jane Doe', 'location' => 'London, UK', 'hourly_rate' => 65],
            ['id' => 3, 'name' => 'Jim Doe', 'location' => 'New York, USA', 'hourly_rate' => 40],
            ['id' => 4, 'name' => 'Jill Doe', 'location' => 'Los Angeles, USA', 'hourly_rate' => 70]
        ];

        // Filter by a non-existent name "Peter" and location "Canada", sort by hourly_rate ascending
        $filterName = 'Peter';
        $filterLocation = 'Canada';
        $sort = 'asc';
        $expected = [];

        // Call the method
        $actual = FilterSort::filterAndSort($coaches, $filterName, $filterLocation, $sort);

        // Assert that the result matches the expected outcome
        $this->assertEquals($expected, $actual);
    }

    public function testFilterAndSortWithDescendingOrder()
    {
        // Sample coaches data
        $coaches = [
            ['id' => 1, 'name' => 'John Doe', 'location' => 'New York, USA', 'hourly_rate' => 50],
            ['id' => 2, 'name' => 'Jane Doe', 'location' => 'London, UK', 'hourly_rate' => 65],
            ['id' => 3, 'name' => 'Jim Doe', 'location' => 'New York, USA', 'hourly_rate' => 40],
            ['id' => 4, 'name' => 'Jill Doe', 'location' => 'Los Angeles, USA', 'hourly_rate' => 70]
        ];

        // Filter by "Doe" in name and "USA" in location, sort by hourly_rate descending
        $filterName = 'Doe';
        $filterLocation = 'USA';
        $sort = 'desc';
        $expected = [
            ['id' => 4, 'name' => 'Jill Doe', 'location' => 'Los Angeles, USA', 'hourly_rate' => 70],
            ['id' => 1, 'name' => 'John Doe', 'location' => 'New York, USA', 'hourly_rate' => 50],
            ['id' => 3, 'name' => 'Jim Doe', 'location' => 'New York, USA', 'hourly_rate' => 40]
        ];

        // Call the method
        $actual = FilterSort::filterAndSort($coaches, $filterName, $filterLocation, $sort);

        // Assert that the result matches the expected outcome
        $this->assertEquals($expected, $actual);
    }

    public function testFilterAndSortWithEmptyArray()
    {
        // Empty coaches data
        $coaches = [];

        // Filter by "John" and sort by hourly_rate ascending
        $filterName = 'John';
        $filterLocation = '';
        $sort = 'asc';
        $expected = [];

        // Call the method
        $actual = FilterSort::filterAndSort($coaches, $filterName, $filterLocation, $sort);

        // Assert that the result matches the expected outcome
        $this->assertEquals($expected, $actual);
    }
}
