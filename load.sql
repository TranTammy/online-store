-- Load data into customer table
LOAD DATA INFILE 'customer.csv'
INTO TABLE customer
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(customer_id, first_name, last_name, address, phone, email, username, password, cc_no, exp_date, cvv);

-- Load data into employee table
LOAD DATA INFILE 'employee.csv'
INTO TABLE employee
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(essn, first_name, last_name, address, phone, email, username, password, dept_id);

-- Load data into department table
LOAD DATA INFILE 'department.csv'
INTO TABLE department
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(dept_id, dept_name, manager_ssn);

-- Load data into product table
LOAD DATA INFILE 'product.csv'
INTO TABLE product
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(product_id, product_name, sell_price, exp_date, dpt_id);

-- Load data into supplier table
LOAD DATA INFILE 'supplier.csv'
INTO TABLE supplier
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(supplier_id, supplier_name, buy_price);

-- Load data into supplier_products table
LOAD DATA INFILE 'supplier_products.csv'
INTO TABLE supplier_products
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(supplier_id, product_id, product_name);

-- Load data into supplied_by table
LOAD DATA INFILE 'supplied_by.csv'
INTO TABLE supplied_by
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(supplier_id, product_id, product_amount);

-- Load data into cart table
LOAD DATA INFILE 'cart.csv'
INTO TABLE cart
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(cart_id, customer_id);

-- Load data into cart_items table
LOAD DATA INFILE 'cart_items.csv'
INTO TABLE cart_items
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(cart_id, product_id, product_name, sell_price);