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

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update query without prepared statements (vulnerable to SQL injection)
    $sql = "UPDATE employee_credentials 
            SET password='$new_password' 
            WHERE username='$username' AND password='$old_password'";

    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
}
?>