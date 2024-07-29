<?php
    // Collect data
    $email = $_GET['Email'];
    $SSN = $_GET['SSN'];

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
    

    $stmt = $mysqli->prepare("
        SELECT ec.username, ec.password
        FROM employee_credentials ec
        LEFT JOIN employee e ON ec.employee_ssn = e.employee_ssn
        WHERE e.email = ? AND e.ssn = ?");

    $stmt->bind_param("s", $email, $ssn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result){
        while ($row = $result->fetch_assoc()){
            printf ("Username: %s -- Password: %s\n",
            $row["username"], $row["password"]);
        }
    }
    
    $stmt->close();
    $connection->close();

?>