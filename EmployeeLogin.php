<?php
    // Get Employee Login Information
    $employee_login_user = $_POST['php_emp_login_user'];
    $employee_login_pass = $_POST['php_emp_login_pass'];

    // Database Information
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online store";

    // Setup MySQL Connection
    $connection = new mysqli($hostname, $username, $password, $dbname);

    // Check Connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare MySQL Statement
    $sql_stmt = $connection->prepare("SELECT * FROM employee_credentials WHERE username = ? AND password = ?");
    $sql_stmt->bind_param("ss", $employee_login_user, $employee_login_pass);

    // Execute MySQL Statement
    $sql_stmt->execute();
    $result = $sql_stmt->get_result();

    if ($result->num_rows > 0) {
        // Redirect to 'EmployeeHomepage.html'
        header("Location: EmployeeHomepage.html");
        die();
    } else {
        // If MySQL Query Failed -> Print Error
        if ($sql_stmt->error) {
            echo "Error: " . $sql_stmt->error;
        }
        // Else --> Invalid Username or Password
        else {
            // TODO: Could change to make invalid username or password clearer for failed login
            header("Location: EmployeeLogin.html?error=Invalid_Username_or_Password");
            die();
        }
        // Close MySQL Statements & Database Connection
        $sql_stmt->close();
        $connection->close();
    }
