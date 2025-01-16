# SuperSpin Coach Listing API

This API powers the Coach Listing Page, showcasing available coaches and allowing users to filter and sort through them.

## Features
- **Coach Listing**: Displays a list of predefined coaches.
- **Filtering**:
  - By Name: Search for coaches by their name.
  - By Location: Filter coaches based on their location.
- **Sorting**:
  - By Hourly Rate: Sort coaches in ascending order of their hourly rates.
- **Modular Design**: The code is organized into reusable components for maintainability.
- **Tests Included**: Backend filtering and sorting logic is thoroughly tested.

## API Endpoint

### `GET /api.php`
Fetch a list of coaches with optional filtering and sorting.

### Query Parameters
| Parameter    | Type   | Description                                      |
|--------------|--------|--------------------------------------------------|
| `name`       | String | Filter coaches by name (case-insensitive).      |
| `location`   | String | Filter coaches by location (case-insensitive).  |
| `sort`       | String | Sort coaches by `hourly_rate`.                  |

### Example Usage
Fetch all coaches from Lisbon, sorted by hourly rate:
```bash
curl "http://localhost/coach-api/src/api.php?location=lisbon&sort=hourly_rate"
```

## Folder Structure
```plaintext
/coach-api
├── /src
│   ├── database.php       # Mock data source
│   ├── filter_and_sort.php # Filtering and sorting logic
│   ├── api.php            # Main API entry point
├── /tests
│   ├── test_api.php       # Test script for the API
├── .htaccess              # For Apache server configuration (optional)
├── composer.json          # For dependency management (optional)
└── README.md              # Documentation for the API
```

## Running the API
1. Clone or download the repository.
2. Host the folder on a PHP server (e.g., Apache or PHP's built-in server).
3. Access the API endpoint using your browser or a tool like `curl` or Postman.

## Tests
Run tests with:
```bash
php tests/test_api.php
```

### Test Cases
- **Filter by Name**: Ensures filtering by coach name works correctly.
- **Filter by Location**: Validates location-based filtering.
- **Sort by Hourly Rate**: Confirms sorting logic by hourly rates.

## Future Enhancements
- Connect to a real database to dynamically manage coaches.
- Add authentication for secure API usage.
- Implement pagination for large coach datasets.
