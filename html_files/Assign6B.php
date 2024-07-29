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

    // Update query using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE employee_credentials ec
                            JOIN employee e ON ec.username = e.username
                            SET ec.password = ?
                            WHERE ec.username = ? AND ec.password = ?"
                            );
    $stmt->bind_param("sss", $new_password, $username, $old_password);

    if ($stmt->execute() === TRUE) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>