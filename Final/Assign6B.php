<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $old_password = $_POST['Old_Password'];
    $new_password = $_POST['New_Password'];

    // Establish database connection
    $servername = "localhost";
    $db_username = "root"; 
    $db_password = ""; 
    $dbname = "online store";
    
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query with potential for SQL injection
    $sql = "UPDATE employee_credentials 
            SET password = '$new_password' 
            WHERE username = '$username' AND password = '$old_password'";

    if ($conn->query($sql) === TRUE) 
            echo "Password Updated";
            
    else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
}
?>