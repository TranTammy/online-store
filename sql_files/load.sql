USE `your_database_here`;

-- Insert data into DEPARTMENT table
INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'Sales'),
(2, 'Engineering');

-- Insert data into EMPLOYEE table
INSERT INTO `employee` (`employee_ssn`, `first_name`, `last_name`, `address`, `phone`, `email`, `username`, `dept_id`) VALUES
('123456789', 'John', 'Doe', '123 Main St', '123456789', 'john.doe@example.com', 'johndoe', 1),
('987654321', 'Jane', 'Smith', '456 Oak St', '098765432', 'jane.smith@example.com', 'janesmith', 2);

-- Insert data into EMPLOYEE_CREDENTIALS table
INSERT INTO `employee_credentials` (`employee_ssn`, `username`, `password`) VALUES
('123456789', 'johndoe', 'password123'),
('987654321', 'janesmith', 'password321');

-- Insert data into CUSTOMER table
INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `address`, `phone`, `email`, `username`, `password`, `cc_no`, `exp_date`, `cvv`) VALUES
(1, 'Alice', 'Wonderland', '789 Elm St', '112233445', 'alice@example.com', 'alicew', 'alicepass', '1234567812345678', '12/25', '123'),
(2, 'Bob', 'Builder', '101 Pine St', '554433221', 'bob@example.com', 'bobb', 'bobpass', '8765432187654321', '11/24', '321');


-- Insert data into PRODUCT table
INSERT INTO `product` (`product_id`, `product_name`, `sell_price`, `exp_date`, `dept_id`) VALUES
(1, 'Laptop', 999.99, '2025-12-31', 2),
(2, 'Smartphone', 499.99, '2024-11-30', 2);

-- Insert data into CART table
INSERT INTO `cart` (`customer_id`, `product_id`, `product_name`, `product_cost`) VALUES
(1, 1, 'Laptop', 999.99),
(2, 2, 'Smartphone', 499.99);

-- Insert data into SUPPLIER table
INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `buy_price`) VALUES
(1, 'TechSupplier', 800.0),
(2, 'MobileInc', 400.0);

-- Insert data into SUPPLIER_PRODUCTS table
INSERT INTO `supplier_products` (`supplier_id`, `supplier_product_id`) VALUES
(1, 1),
(2, 2);

-- Insert data into SUPPLIED_BY table
INSERT INTO `supplied_by` (`supplier_id`, `store_product_id`, `product_amount`) VALUES
(1, 1, 50),
(2, 2, 100);