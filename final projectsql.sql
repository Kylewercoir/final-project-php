CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users (username,email,password,role)
VALUES ('admin', 'admin@example.com',
'$2y$10$E2a2l3aXw3Cl0bxQqAh5kOr9h7uFzDzIHrKjH2jYxYBz0d5p4hF.q', 'admin');
ALTER TABLE products
ADD COLUMN image VARCHAR(255) AFTER quantity;
INSERT INTO products (name, description, price, quantity, image)
VALUES ('KyleWerCoir Hat', 'Official merch hat.', 29.99, 10, 'kylewercoir-hat.png');



