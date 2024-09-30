<?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "online store";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['php_delete_product_id'])) {
        $product_id = $_POST['php_delete_product_id'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: EmployeeHomepage.html');
        } else {
            if ($stmt->error) {
                echo "Error: " . $stmt->error;
            } else {
                header("Location: ProductDelete.html?error=Invalid_ProductID");
                die();
            }
        }
        // Close the statement
        $stmt->close();
    } else {
        echo "ProductID is null.";
    }
    // Close the connection
    $conn->close();
