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
├── env.d.ts          # TypeScript environment declarations
├── eslint.config.ts  # ESLint configuration file for linting
├── index.html        # Main HTML file
├── package-lock.json # Package lock file for dependencies
├── package.json      # Project metadata and dependencies
├── public
│   └── favicon.ico   # Favicon for the web application
├── src
│   ├── App.vue       # Main Vue.js component that controls app structure
│   ├── assets
│   │   └── main.css  # Global CSS styles for the application
│   ├── component-library
│   │   └── icons
│   │       ├── ArrowDownIcon.vue  # Icon component for down arrow
│   │       └── ArrowUpIcon.vue    # Icon component for up arrow
│   ├── components
│   │   ├── DataTable.vue          # Data table component displaying coach info
│   │   ├── SearchBar.vue          # Search bar component for filtering coaches
│   │   └── SortDropdown.vue       # Sort dropdown component for sorting by hourly rate
│   ├── main.ts                    # Main entry file for Vue app setup
│   ├── services
│   │   └── axios.ts               # Axios service for API calls (e.g., fetching coach data)
│   └── types
│       ├── Coach.ts               # Type definition for Coach object
│       ├── Field.ts               # Type definition for Field (e.g., coach field data)
│       └── RowData.ts             # Type definition for RowData (e.g., individual row in DataTable)
├── tests
│   └── DataTable.test.ts          # Unit test for DataTable component
├── tsconfig.app.json             # TypeScript configuration for app
├── tsconfig.json                 # General TypeScript configuration
├── tsconfig.node.json            # TypeScript configuration for Node.js
└── vite.config.ts                # Vite configuration file for project build setups
```

## How to Run
1. Clone or download the repository.
2. Install dependencies:
```
npm install
```
3. Run the development server:
```
npm run dev
```

## Development Details

### Vue Components

- **App.vue**: The main component that includes the global layout of the application.
- **DataTable.vue**: Displays the list of coaches in a grid, with sortable and filterable columns.
- **SearchBar.vue**: Provides the UI for users to search coaches by name or location.
- **SortDropdown.vue**: A dropdown for sorting coaches by their hourly rate (ascending/descending).

### TypeScript Services

- **axios.ts**: Contains a service to handle HTTP requests (e.g., fetching coach data).

### Styling

- **main.css**: Contains the styles for the layout, including the grid and media queries for responsive design.

### TypeScript Types

- **Coach.ts**: Type definitions for the coach object.
- **Field.ts**: Defines the fields used in the grid (e.g., name, location).
- **RowData.ts**: Type definition for each individual row in the table.

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
- ~~Fetch coach data dynamically from the backend API.~~
- Add animations for smooth transitions during filtering and sorting.
- ~~Implement pagination for large datasets.s~~

## Coach Listing RESTful API

This RESTful API powers the Coach Listing Frontend, showcasing available coaches and allowing users to filter and sort through them.

# Coach API Documentation

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
| `filter`       | String | Filter coaches by name or location (case-insensitive).      |
| `sort`       | String | Sort coaches by `hourly_rate`.                  |

### Example Usage
#### GET - Fetch all coaches from Lisbon, sorted by hourly rate:
```bash
curl "http://localhost:8000/coaches?filter=lisbon&sort=asc"
```

#### POST - Create a new coach:
```bash
curl -X POST "http://localhost:8000/coaches" \
-H "Content-Type: application/json" \
-d '{
  "name": "John Doe",
  "years_of_experience": 5,
  "hourly_rate": 50,
  "location": "Lisbon,Portugal",
  "joined_at": "2025-01-27"
}'
```

#### DELETE - Delete a specific coach by ID:
```
curl -X DELETE "http://localhost:8000/coaches/1"
```

#### PATCH - Update a coach's hourly rate:
```
curl -X PATCH "http://localhost:8000/coaches/1" \
-H "Content-Type: application/json" \
-d '{
  "hourly_rate": 55
}'
```

## Folder Structure
```
/coach-api
├── /src
│   ├── /Controllers
│   │   └── CoachController.php       # Handles coach-related logic.
│   ├── /Database
│   │   └── Database.php             # Database connection and queries.
│   ├── /Gateways
│   │   └── CoachGateway.php         # Responsible for fetching coaches from database.
│   ├── /Helpers
│   │   ├── FilterSort.php           # Contains filtering and sorting logic.
│   │   └── ValidationHelper.php    # Helper functions for input validation.
│   ├── /Utilities
│   │   └── ErrorHandler.php         # Handles error responses.
├── /tests
│   ├── DatabaseTest.php             # Test script for database-related logic.
│   ├── FilterSortTest.php           # Test script for filtering and sorting logic.
├── /public
│   └── index.php                   # Entry point for the application.
├── composer.json                   # For dependency management.
├── composer.lock                   # Lock file for dependencies.
└── README.md                       # Documentation for the API.
```

## Running the API
1. Clone or download the repository.
2. Host the folder on a PHP server (e.g., Apache or PHP's built-in server).
3. Access the API endpoint using your browser or a tool like curl or Postman.

## Tests
Run tests with:
```
php tests/DatabaseTest.php
php tests/FilterSortTest.php
```

## Test Cases
- Filter by Name: Ensures filtering by coach name works correctly.
- Filter by Location: Validates location-based filtering.
- Sort by Hourly Rate: Confirms sorting logic by hourly rates.

## Future Enhancements
- ~~Connect to a real database to dynamically manage coaches.~~
- ~~Add authentication for secure API usage.~~
- Implement pagination for large coach datasets.