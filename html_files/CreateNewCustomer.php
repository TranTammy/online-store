<?php
    // Get Customer Data
    $first_name = $_POST['php_customer_first_name'];
    $last_name = $_POST['php_customer_last_name'];
    $address = $_POST['php_customer_address'];
    $phone = $_POST['php_customer_phone'];
    $email = $_POST['php_customer_email'];
    $username = $_POST['php_customer_user'];
    $password = $_POST['php_customer_pass'];
    $ccn = $_POST['php_customer_ccn'];
    $exp_date = $_POST['php_customer_exp_date'];
    $cvv = $_POST['php_customer_cvv'];

    // Database Information
    $hostname = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "database_name";

    // Setup MySQL Connection
    $connection = new mysqli($hostname, $username, $password, $dbname);

    // Check Connection
    if ($connection -> connect_error) {
        // If Connection Failed -> Print Error
        die("Connection failed: " . $connection->connect_error);
    }
    // Find Next Available 'customer_id'
    $result = $connection->query("SELECT MAX(customer_id) AS customer_id FROM customer");
    $row = $result->fetch_assoc();
    $next_customer_id = $row['customer_id'] + 1;

    // Prepare MySQL Statement
    $sql_statement = $connection->prepare("INSERT INTO customer (customer_id, first_name, last_name, address, phone, email, username, password, cc_no, exp_date, cvv) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql_statement->bind_param("isssisssisi", $next_customer_id, $first_name, $last_name, $address, $phone, $email, $username, $password, $ccn, $exp_date, $cvv);

    // Execute MySQL Statement
    if ($sql_statement->execute()) {
        // Redirect to 'CustomerLogin.html' if Successful
        header("Location: CustomerLogin.html");
        die();
    } else {
        // If MySQL Query Failed -> Print Error
        if ($sql_statement->errno) {
            echo "Error: " . $sql_statement->error;
        }
        // Else -> Invalid Form Data
        else {
            // TODO: Could change to make error clearer for failed customer creation
            header("Location: CreateNewCustomer.html?error=Invalid_Data");
            die();
        }
        // Close MySQL Statements & Database Connection
        $sql_statement->close();
        $connection->close();
    }
