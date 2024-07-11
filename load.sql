-- Select the database
-- Use your database name
USE dbhw3;

-- Insert into employee table
INSERT INTO employee (essn, first_name, last_name, address, phone, email, username, password, dept_id) VALUES
('123456789', 'John', 'Doe', '123 Main St', '123456789', 'john.doe@example.com', 'johndoe', 'password123', NULL);

-- Insert into department table
INSERT INTO department (dept_id, dept_name, manager_ssn) VALUES
(1, 'Electronics', '123456789'),
(2, 'Clothing', '123456789');

-- Insert into customer table
INSERT INTO customer (customer_id, first_name, last_name, address, phone, email, username, password, cc_no, exp_date, cvv) VALUES
(1, 'Jane', 'Smith', '456 Elm St', '987654321', 'jane.smith@example.com', 'janesmith', 'password456', '1111222233334444', '2025-12-31', '123');

-- Insert into product table
INSERT INTO product (product_id, product_name, sell_price, exp_date, dpt_id) VALUES
(1, 'Laptop', 999.99, '2026-12-31', 1),
(2, 'Smartphone', 799.99, '2026-12-31', 1),
(3, 'Tablet', 499.99, '2026-12-31', 1),
(4, 'Headphones', 199.99, '2026-12-31', 1),
(5, 'Smartwatch', 299.99, '2026-12-31', 1),
(6, 'T-Shirt', 19.99, '2025-12-31', 2),
(7, 'Jeans', 49.99, '2025-12-31', 2),
(8, 'Jacket', 99.99, '2025-12-31', 2),
(9, 'Sneakers', 79.99, '2025-12-31', 2),
(10, 'Hat', 14.99, '2025-12-31', 2);

-- Insert into supplier table
INSERT INTO supplier (supplier_id, supplier_name, buy_price) VALUES
(1, 'TechSupplier Inc.', 800.00),
(2, 'FashionSupplier Ltd.', 40.00);

-- Insert into supplier_products table
INSERT INTO supplier_products (supplier_id, product_id, product_name) VALUES
(1, 1, 'Laptop'),
(1, 2, 'Smartphone'),
(1, 3, 'Tablet'),
(1, 4, 'Headphones'),
(1, 5, 'Smartwatch'),
(2, 6, 'T-Shirt'),
(2, 7, 'Jeans'),
(2, 8, 'Jacket'),
(2, 9, 'Sneakers'),
(2, 10, 'Hat');

-- Insert into supplied_by table
INSERT INTO supplied_by (supplier_id, product_id, product_amount) VALUES
(1, 1, 100),
(1, 2, 200),
(1, 3, 150),
(1, 4, 300),
(1, 5, 250),
(2, 6, 400),
(2, 7, 300),
(2, 8, 200),
(2, 9, 350),
(2, 10, 500);

-- Insert into cart table
INSERT INTO cart (cart_id, customer_id) VALUES
(1, 1);

-- Insert into cart_items table
INSERT INTO cart_items (cart_id, product_id, product_name, sell_price) VALUES
(1, 1, 'Laptop', 999.99),
(1, 7, 'Jeans', 49.99);