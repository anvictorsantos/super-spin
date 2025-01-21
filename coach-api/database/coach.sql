CREATE DATABASE `super-spin`

CREATE TABLE `super-spin`.coach (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(100) NOT NULL,
	years_of_experience INT NOT NULL,
	hourly_rate FLOAT NOT NULL,
	location varchar(100) NOT NULL,
	joined_at DATE NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `super-spin`.coach
(name, years_of_experience, hourly_rate, location, joined_at)
VALUES
('John Smith', 5, 50, 'New York, USA', '2023-05-10'),
('Emma Johnson', 8, 65, 'London, UK', '2021-03-15'),
('Liam Brown', 3, 40, 'Sydney, Australia', '2022-07-20'),
('Sophia Garcia', 10, 80, 'Los Angeles, USA', '2020-01-25'),
('Noah Wilson', 1, 35, 'Toronto, Canada', '2024-09-12');
