<?php
// Collect data
$email = $_POST['Email'];
$ssn = $_POST['SSN'];

$servername = "localhost";
$username = "root"; //replace w username
$password = ""; //replace w password
$dbname = "online store";

// Create connection to MySql
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


$stmt = $connection->prepare("
        SELECT ec.username, ec.password
        FROM employee_credentials ec
        LEFT JOIN employee e ON ec.employee_ssn = e.employee_ssn
        WHERE e.email = ? AND e.employee_ssn = ?");

$stmt->bind_param("si", $email, $ssn);
$stmt->execute();
$result = $stmt->get_result();

if ($result){
    while ($row = $result->fetch_assoc()){
        echo "Username: " . htmlspecialchars($row['username']);
        echo "Password: " . htmlspecialchars($row['password']);
    }
}
else{
    echo "No Employees Found";
    }

$stmt->close();
$connection->close();