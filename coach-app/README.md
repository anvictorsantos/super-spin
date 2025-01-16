# SuperSpin Coach Listing Frontend

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
