<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];

    // Validate that ProductID is not empty and is numeric
    if (!empty($productID) && is_numeric($productID)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM products WHERE ProductID = ?");
        $stmt->bind_param("i", $productID);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Product with ID $productID has been deleted successfully.";
        } else {
            echo "Error deleting product: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid ProductID. Please enter a valid numeric ProductID.";
    }
} else {
    echo "ProductID not provided.";
}

// Close the connection
$conn->close();
?>