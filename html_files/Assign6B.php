<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $old_password = $_POST['OldPassword'];
    $new_password = $_POST['NewPassword'];

    // Establish database connection
    $servername = "localhost";
    $db_username = "root"; 
    $db_password = ""; 
    $dbname = "online store";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query with potential for SQL injection
    $sql = "UPDATE employee_credentials ec 
            JOIN employee e ON ec.employee_ssn = e.employee_ssn 
            SET ec.password = '$new_password' 
            WHERE e.employee_ssn = '$employee_ssn' AND e.email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
}
?>