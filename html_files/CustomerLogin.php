<?php
    // Customer Login Information
    $customer_login_user = $_POST['php_customer_login_user'];
    $customer_login_pass = $_POST['php_customer_login_pass'];

    // Database Information
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online store";

    // Setup MySQL Connection
    $connection = new mysqli($hostname, $username, $password, $dbname);

    // Check Connection
    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    // Prepare MySQL Statement
    $sql_stmt = $connection->prepare("SELECT customer_id FROM customer WHERE username = ? AND password = ?");
    $sql_stmt->bind_param("ss", $customer_login_user, $customer_login_pass);
    
   
    // Execute MySQL Statement
    $sql_stmt->execute();
    $result = $sql_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Redirect to 'products.php'
        $uid = $result->fetch_assoc()
        header("Location: Products.php?uid=$uid");
        die();
    } else {
        // If MySQL Query Failed -> Print Error
        if ($sql_stmt->error) {
            echo "Error: " . $sql_stmt->error;
        }
        // Else --> Invalid Username or Password
        else {
            // TODO: Could change to make invalid username or password clearer for failed login
            header("Location: CustomerLogin.html?error=Invalid_Username_or_Password");
            die();
        }
        // Close MySQL Statements & Database Connection
        $sql_stmt->close();
        $connection->close();
    }
