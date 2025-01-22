# Use the official PHP CLI image as the base
FROM php:8.0-cli

# Set the working directory inside the container
WORKDIR /usr/src/app

# Install dependencies (like PDO extensions for MySQL)
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_mysql

# Copy the PHP application files into the container
COPY . .

# Expose the port the API will run on (adjust based on your app's configuration)
EXPOSE 8000

# Command to run the PHP built-in server (adjust as needed for your API)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
