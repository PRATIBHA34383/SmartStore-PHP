CREATE DATABASE IF NOT EXISTS smartstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smartstore;
CREATE TABLE IF NOT EXISTS admins(id INT AUTO_INCREMENT PRIMARY KEY,username VARCHAR(100) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL);

CREATE TABLE IF NOT EXISTS businesses(id INT AUTO_INCREMENT PRIMARY KEY,business_name VARCHAR(150) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS products(id INT AUTO_INCREMENT PRIMARY KEY,business_id INT NOT NULL,product_name VARCHAR(150) NOT NULL,category VARCHAR(100),price DECIMAL(10,2) NOT NULL DEFAULT 0,stock INT NOT NULL DEFAULT 0,low_stock_limit INT NOT NULL DEFAULT 5,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(business_id) REFERENCES businesses(id) ON DELETE CASCADE);
CREATE TABLE IF NOT EXISTS price_history(id INT AUTO_INCREMENT PRIMARY KEY,product_id INT NOT NULL,old_price DECIMAL(10,2) NOT NULL,new_price DECIMAL(10,2) NOT NULL,changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE);
CREATE TABLE IF NOT EXISTS sales(id INT AUTO_INCREMENT PRIMARY KEY,product_id INT NOT NULL,quantity INT NOT NULL,unit_price DECIMAL(10,2) NOT NULL,discount DECIMAL(10,2) NOT NULL DEFAULT 0,total_amount DECIMAL(10,2) NOT NULL,sold_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE);
INSERT INTO businesses(business_name) SELECT 'Hotel' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='Hotel');
INSERT INTO businesses(business_name) SELECT 'Clothing Store' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='Clothing Store');
INSERT INTO businesses(business_name) SELECT 'Shoes Store' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='Shoes Store');
INSERT INTO businesses(business_name) SELECT 'Electronics Store' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='Electronics Store');
INSERT INTO businesses(business_name) SELECT 'General Store' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='General Store');
INSERT INTO businesses(business_name) SELECT 'Mall' WHERE NOT EXISTS(SELECT 1 FROM businesses WHERE business_name='Mall');
