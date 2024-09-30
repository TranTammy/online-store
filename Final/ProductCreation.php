<?php
    // Get Product Data
    $product_id = $_POST['php_product_id'];
    $product_name = $_POST['php_product_name'];
    $exp_date = $_POST['php_product_exp_date'];
    $sell_price = $_POST['php_product_sell_price'];
    $dept_id = $_POST['php_product_dept_id'];
    // Database Information
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online store";
    // Setup MySQL Connection
    $connection = new mysqli($servername, $username, $password, $dbname);
    // Check Connection
    if($connection->connect_error){
        die("Connection Failed: " . $connection->connect_error);
    }

    $create_product_sql_stmt = $connection->prepare("INSERT INTO product (product_id, product_name, sell_price, exp_date, dept_id)
        VALUES (?, ?, ?, ?, ?)");
    $create_product_sql_stmt->bind_param("isdsi", $product_id, $product_name, $sell_price, $exp_date, $dept_id);

    if($create_product_sql_stmt->execute()){
        header("Location: EmployeeHomepage.html");
        die();
    } else {
        // If MySQL Query Failed -> Print Error
        if ($create_product_sql_stmt->error) {
            echo "Error: " . $create_product_sql_stmt->error;
        }
        // Else -> Invalid Form Data
        else {
            header("Location: ProductCreation.html?error=Invalid_Data");
            die();
        }
    }
    // Close MySQL Statement and Database Connection
    $create_product_sql_stmt->close();
    $connection->close();

