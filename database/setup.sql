CREATE TABLE IF NOT EXISTS migrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_number VARCHAR(255) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(255) NOT NULL,
    shipping_address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status VARCHAR(255) DEFAULT 'pending',
    payment_reference VARCHAR(255),
    moneybag_transaction_id VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INTEGER,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- Insert sample products
INSERT INTO products (name, description, price, stock, created_at, updated_at) VALUES
('Laptop', 'High-performance laptop with 16GB RAM and 512GB SSD', 1299.99, 10, datetime('now'), datetime('now')),
('Smartphone', 'Latest smartphone with 5G connectivity', 899.99, 15, datetime('now'), datetime('now')),
('Wireless Headphones', 'Noise-canceling wireless headphones', 299.99, 20, datetime('now'), datetime('now')),
('Smart Watch', 'Fitness tracking smart watch with heart rate monitor', 399.99, 25, datetime('now'), datetime('now')),
('Tablet', '10-inch tablet with stylus support', 599.99, 12, datetime('now'), datetime('now'));