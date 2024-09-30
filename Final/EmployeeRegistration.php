<?php
    // Get Employee Data
    $employee_ssn = $_POST['php_emp_ssn'];
    $first_name = $_POST['php_emp_first_name'];
    $last_name = $_POST['php_emp_last_name'];
    $address = $_POST['php_emp_address'];
    $phone = $_POST['php_emp_phone'];
    $email = $_POST['php_emp_email'];
    $Eusername = $_POST['php_emp_user'];
    $Epassword = $_POST['php_emp_pass'];
    $dept_id = $_POST['php_emp_dept_id'];

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

    // Prepare MySQL Statement for 'employee'
    $emp_sql_stmt = $connection->prepare("INSERT INTO employee (employee_ssn, first_name, last_name, address, phone, email, username, dept_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $emp_sql_stmt->bind_param("isssissi", $employee_ssn, $first_name, $last_name, $address, $phone, $email, $Eusername, $dept_id);

    // Prepare MySQL Statement for 'employee_credentials'
    $emp_cred_sql_stmt = $connection->prepare("INSERT INTO employee_credentials (employee_ssn, username, password)
            VALUES (?, ?, ?)");
    $emp_cred_sql_stmt->bind_param("iss", $employee_ssn, $Eusername, $Epassword);

    // Execute MySQL Statements
    if ($emp_sql_stmt->execute() && $emp_cred_sql_stmt->execute()) {
        // Redirect to 'employee_homepage.html' if Execute Successful
        header("Location: EmployeeHomepage.html");
        die();
    } else {
        // If MySQL Query Failed -> Print Error
        if ($emp_sql_stmt->errno || $emp_cred_sql_stmt->errno) {
            if ($emp_sql_stmt->errno) {
                echo "Error: " . $emp_sql_stmt->error;
            }
            if ($emp_cred_sql_stmt->errno) {
                echo "Error: " . $emp_cred_sql_stmt->error;
            }
        }
        // Else -> Invalid Form Data
        else {
            // TODO: Could change to make error clearer for failed employee registration
            header("Location: EmployeeRegistration.html?error=Invalid_Data");
            die();
        }

        // Close MySQL Statements & Database Connection
        $emp_sql_stmt->close();
        $emp_cred_sql_stmt->close();
        $connection->close();
    }
