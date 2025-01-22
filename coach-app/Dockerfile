# Use Node.js 20 as the base image
FROM node:20 AS build

# Set the working directory
WORKDIR /usr/src/app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application files
COPY . .

# Build the production-ready app (this runs the build command from package.json)
RUN npm run build

# Use a lightweight server to serve the static files (you can use something like nginx or serve)
FROM nginx:alpine

# Copy the built files from the build stage into the nginx folder
COPY --from=build /usr/src/app/dist /usr/share/nginx/html

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]
