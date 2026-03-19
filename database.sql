-- Database: topup_game
CREATE DATABASE IF NOT EXISTS topup_game;
USE topup_game;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('superadmin', 'admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: developers
CREATE TABLE developers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    company_name VARCHAR(100),
    full_name VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: games
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    developer_id INT,
    game_name VARCHAR(100) NOT NULL,
    game_slug VARCHAR(100) UNIQUE NOT NULL,
    game_icon VARCHAR(255),
    game_banner VARCHAR(255),
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (developer_id) REFERENCES developers(id) ON DELETE SET NULL
);

-- Table: game_nominal
CREATE TABLE game_nominal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    nominal_name VARCHAR(100) NOT NULL,
    nominal_value VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

-- Table: orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT NULL,
    game_id INT NOT NULL,
    nominal_id INT NOT NULL,
    game_account_id VARCHAR(100) NOT NULL,
    game_account_server VARCHAR(50),
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100),
    customer_phone VARCHAR(20),
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (nominal_id) REFERENCES game_nominal(id)
);

-- Table: payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_provider VARCHAR(50),
    payment_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'expired') DEFAULT 'pending',
    payment_code VARCHAR(100),
    payment_details TEXT,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Insert default admin
INSERT INTO admins (username, email, password, full_name, role) VALUES
('admin', 'admin@topupgame.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'superadmin');

-- Insert sample developer
INSERT INTO developers (username, email, password, company_name, full_name) VALUES
('moonton', 'dev@moonton.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Moonton Games', 'Developer ML');

-- Insert sample games
INSERT INTO games (developer_id, game_name, game_slug, description) VALUES
(1, 'Mobile Legends', 'mobile-legends', 'Top up Diamond Mobile Legends'),
(1, 'Free Fire', 'free-fire', 'Top up Diamonds Free Fire');

-- Insert sample nominals
INSERT INTO game_nominal (game_id, nominal_name, nominal_value, price) VALUES
(1, '86 Diamonds', '86', 25000),
(1, '172 Diamonds', '172', 50000),
(1, '257 Diamonds', '257', 75000),
(2, '70 Diamonds', '70', 12000),
(2, '140 Diamonds', '140', 24000),
(2, '210 Diamonds', '210', 36000);