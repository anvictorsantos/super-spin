# SuperSpin

SuperSpin is a startup based in Cairo, Egypt, with the vision of becoming the "Ultimate Marketplace for Table Tennis Players." It connects Table Tennis Players with professional Coaches for one-on-one training sessions.

## About SuperSpin
SuperSpin is dedicated to growing the Table Tennis community by providing an accessible platform for players to improve their skills and connect with top-tier coaches.

## Coach Listing Frontend

This frontend project is part of SuperSpin's initiative to create a responsive and user-friendly Coach Listing Page, connecting Table Tennis Players with professional Coaches.

## Features

### Responsive Coach Listing Page
- **Grid Layout**: Displays coaches in an organized grid with the following details:
  - Name
  - Years of Experience
  - Hourly Rate
  - Location (City, Country)
  - Date Joined SuperSpin
- **Search Bar**: Allows users to filter coaches by name or location.
- **Sort Dropdown**:
  - Sort coaches by hourly rate in ascending or descending order.

### Responsive Design
- **Mobile, Tablet, Desktop Support**: Built with CSS and media queries to ensure responsiveness across various screen sizes.
- **No Frameworks**: Uses only HTML, CSS, and Vanilla JavaScript for simplicity and maintainability.

## Folder Structure
```plaintext
/coach-app
├── index.html        # Main HTML file
├── styles.css        # CSS file for styling
├── script.js         # JavaScript file for interactivity
├── README.md         # Documentation for the frontend
```

## How to Run
1. Clone or download the repository.
2. Open `index.html` in any modern web browser.

## Development Details

### HTML (`index.html`)
- Contains the structure for the Coach Listing Page.
- Includes placeholders for dynamic data like coach details.

### CSS (`styles.css`)
- Implements the grid layout for displaying coaches.
- Uses media queries to adjust layout and styles for different screen sizes.
- Provides styling for the search bar and sort dropdown.

### JavaScript (`script.js`)
- Dynamically filters the list of coaches based on user input in the search bar.
- Sorts the displayed coaches by hourly rate (ascending/descending) when selected in the dropdown.

## Example Features

### Search Bar
- **Input**: Type in a coach's name or location.
- **Output**: Filters the visible coaches in real time.

### Sort Dropdown
- **Options**:
  - Hourly Rate: Low to High
  - Hourly Rate: High to Low
- **Functionality**: Sorts the coach grid dynamically based on the selected option.

## Example UI Behavior
- **Desktop**: Displays multiple rows of coaches in a grid with ample spacing.
- **Tablet**: Adjusts the grid to display fewer columns for better readability.
- **Mobile**: Stacks coaches vertically for a seamless scrolling experience.

## Future Enhancements
- Fetch coach data dynamically from the backend API.
- Add animations for smooth transitions during filtering and sorting.
- Implement pagination for large datasets.s

## Coach Listing RESTful API

This RESTful API powers the Coach Listing Frontend, showcasing available coaches and allowing users to filter and sort through them.

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

