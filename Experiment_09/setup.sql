CREATE DATABASE IF NOT EXISTS experiment_09_store;
USE experiment_09_store;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    video_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, category, image_path, description, video_link)
SELECT 'Laptop', 110000.00, 'Laptop', '../Experiment_02/MacBookM4.png', 'High performance laptop from Experiment 2 with premium design and features.', 'https://www.youtube.com/embed/rcqJwd0wElA?si=eo_xmM_L0Tx1nphB'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Laptop'
);

INSERT INTO products (name, price, category, image_path, description, video_link)
SELECT 'Mobile', 179000.00, 'Mobile', '../Experiment_02/iPhone17Pro.jpeg', 'Flagship mobile from Experiment 2 with advanced camera and display.', 'https://www.youtube.com/embed/q0aFOxT6TNw?si=ukozilx-xO-xYbhH'
WHERE NOT EXISTS (
    SELECT 1 FROM products WHERE name = 'Mobile'
);
