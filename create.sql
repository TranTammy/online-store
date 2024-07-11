USE `your_database_here`;

-- EMPLOYEE TABLES --
CREATE TABLE employee (
    `employee_ssn` char(9) NOT NULL DEFAULT '123456789',
	`first_name` varchar(15) NOT NULL,
	`last_name` varchar(15) NOT NULL,
	`address` varchar(15) DEFAULT NULL,
	`phone` char(9) DEFAULT NULL,
	`email` varchar(30) DEFAULT NULL,
	`username` varchar(15) NOT NULL,
	`dept_id` int DEFAULT NULL,
    PRIMARY KEY (`employee_ssn`),
	KEY `employee_dept_id_idx` (`dept_id`),
	CONSTRAINT `employee_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE employee_credentials (
    `employee_ssn` char(9) NOT NULL DEFAULT '123456789',
    `username` varchar(15) NOT NULL,
	`password` varchar(15) NOT NULL,
    PRIMARY KEY (`employee_ssn`, `username`),
	KEY `employee_ssn_idx` (`employee_ssn`),
	KEY `employee_username_idx` (`username`),
    CONSTRAINT `employee_ssn` FOREIGN KEY (`employee_ssn`) REFERENCES `employee` (`employee_ssn`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `employee_username` FOREIGN KEY (`username`) REFERENCES `employee` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- DEPARTMENT TABLE --
CREATE TABLE `department` (
	`dept_id` int NOT NULL DEFAULT '0',
	`dept_name` varchar(15) NOT NULL,
	`manager_ssn` char(9) DEFAULT NULL,
	PRIMARY KEY (`dept_id`),
	KEY `manager_ssn_idx` (`manager_ssn`),
	CONSTRAINT `manager_ssn` FOREIGN KEY (`manager_ssn`) REFERENCES `employee` (`employee_ssn`) ON DELETE SET NULL ON UPDATE CASCADE
);

-- CUSTOMER TABLES --
CREATE TABLE `customer` (
	`customer_id` int NOT NULL DEFAULT '0',
	`first_name` varchar(15) NOT NULL,
	`last_name` varchar(15) NOT NULL,
	`address` varchar(30) DEFAULT NULL,
	`phone` char(9) DEFAULT NULL,
	`email` varchar(30) DEFAULT NULL,
	`username` varchar(15) NOT NULL,
	`password` varchar(15) NOT NULL,
	`cc_no` char(16) NOT NULL,
	`exp_date` char(5) NOT NULL,
	`cvv` char(3) NOT NULL,
	PRIMARY KEY (`customer_id`)
);

-- CART TABLES --
CREATE TABLE `cart` (
	`customer_id` int NOT NULL DEFAULT '0',
	`product_id` int NOT NULL DEFAULT '0',
	`product_name` varchar(30) DEFAULT NULL,
	`product_cost` decimal(6,2) DEFAULT NULL,
	PRIMARY KEY (`customer_id`, `product_id`),
	KEY `customer_cart_id_idx` (`customer_id`),
	KEY `product_cart_id_idx` (`product_id`),
	CONSTRAINT `customer_cart_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `product_cart_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- PRODUCT TABLE --
CREATE TABLE `product` (
	`product_id` int NOT NULL DEFAULT '0',
	`product_name` varchar(30) NOT NULL,
	`sell_price` decimal(6,2) DEFAULT NULL,
	`exp_date` char(10) DEFAULT NULL,
	`dept_id` int NOT NULL DEFAULT '0',
	PRIMARY KEY (`product_id`),
	UNIQUE KEY `product_name_UNIQUE` (`product_name`),
	KEY `product_dept_id_idx` (`dept_id`),
	CONSTRAINT `product_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- SUPPLIER TABLES --
CREATE TABLE `supplier` (
	`supplier_id` int NOT NULL DEFAULT '0',
	`supplier_name` varchar(30) NOT NULL,
	`buy_price` decimal(10,2) DEFAULT NULL,
	PRIMARY KEY (`supplier_id`)
);

CREATE TABLE `supplier_products` (
	`supplier_id` int NOT NULL DEFAULT '0',
	`supplier_product_id` int NOT NULL DEFAULT '0',
	PRIMARY KEY (`supplier_id`,`supplier_product_id`),
	KEY `product_supplier_id_idx` (`supplier_id`),
	KEY `supplied_product_id_idx` (`supplier_product_id`),
	CONSTRAINT `product_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `supplied_product_id` FOREIGN KEY (`supplier_product_id`) REFERENCES `product` (`product_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `supplied_by` (
	`supplier_id` int NOT NULL DEFAULT '0',
	`store_product_id` int NOT NULL DEFAULT '0',
	`product_amount` int NOT NULL,
	PRIMARY KEY (`supplier_id`,`store_product_id`),
	KEY `supplied_by_id_idx` (`supplier_id`),
	KEY `product_supplied_id_idx` (`store_product_id`),
	CONSTRAINT `supplied_by_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT `product_supplied_id` FOREIGN KEY (`store_product_id`) REFERENCES `product` (`product_id`) ON DELETE SET NULL ON UPDATE CASCADE
);
