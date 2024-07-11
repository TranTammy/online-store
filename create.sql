CREATE TABLE `customer` (
  `customer_id` int NOT NULL DEFAULT '0',
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `address` varchar(30) DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `cc_no` char(16) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `cvv` char(3) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
);

CREATE TABLE `employee` (
  `essn` char(9) NOT NULL DEFAULT '123456789',
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `address` varchar(15) DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `dept_id` int DEFAULT NULL,
  PRIMARY KEY (`essn`),
  KEY `dept_id_idx` (`dept_id`),
  CONSTRAINT `dept_id` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `department` (
  `dept_id` int NOT NULL DEFAULT '0',
  `dept_name` varchar(15) NOT NULL,
  `manager_ssn` char(9) DEFAULT '123456789',
  PRIMARY KEY (`dept_id`),
  KEY `manager_ssn_idx` (`manager_ssn`),
  CONSTRAINT `manager_ssn` FOREIGN KEY (`manager_ssn`) REFERENCES `employee` (`essn`) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `product_name` varchar(30) DEFAULT NULL,
  `sell_price` decimal(6,2) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `dpt_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name_UNIQUE` (`product_name`),
  KEY `dept_id_idx` (`dpt_id`),
  KEY `dpt_id_idx` (`dpt_id`),
  CONSTRAINT `dpt_id` FOREIGN KEY (`dpt_id`) REFERENCES `department` (`dept_id`)
);

CREATE TABLE `supplier` (
  `supplier_id` int NOT NULL DEFAULT '0',
  `supplier_name` varchar(30) DEFAULT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`supplier_id`)
);

CREATE TABLE `supplier_products` (
  `supplier_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`,`product_id`)
);

CREATE TABLE `supplied_by` (
  `supplier_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_amount` int NOT NULL,
  PRIMARY KEY (`supplier_id`,`product_id`)
);

CREATE TABLE `cart` (
  `cart_id` int NOT NULL DEFAULT '0',
  `customer_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cart_id`),
  KEY `customer_id_idx` (`customer_id`),
  CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
);

CREATE TABLE `cart_items` (
  `cart_id` int NOT NULL DEFAULT '0',
  `product_id` int NOT NULL DEFAULT '0',
  `product_name` varchar(30) DEFAULT NULL,
  `sell_price` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`product_id`),
  KEY `product_id_idx` (`product_id`),
  KEY `product_name_idx` (`product_name`),
  KEY `sell_price_idx` (`sell_price`),
  CONSTRAINT `cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_name` FOREIGN KEY (`product_name`) REFERENCES `product` (`product_name`)
);