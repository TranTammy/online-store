<?php
$email = $_POST['Email'];
$ssn = $_POST['SSN'];
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

$stmt = $connection->query("
    SELECT ec.username, ec.password
    FROM employee_credentials ec
    LEFT JOIN employee e ON ec.employee_ssn = e.employee_ssn
    WHERE e.email = '$email' AND e.employee_ssn = '$ssn'
");
if ($stmt->num_rows > 0) {
    $row = $stmt->fetch_assoc();
    echo "Employee Username: " . htmlspecialchars($row['username']);
    echo "Employee Password: " . htmlspecialchars($row['password']);
} else {
    echo "No Employees Found";
}
// Close SQL Statement & Connection
$stmt->close();
$connection->close();
