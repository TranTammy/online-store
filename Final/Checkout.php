 <?php
    session_start();
     // Database Information
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $dbname = "online store";
             // Setup MySQL Connection
             $connection = new mysqli($hostname, $username, $password, $dbname);
              // Check Connection
            if($connection->connect_error){
                die("Connection Failed: " . $connection->connect_error);
             }
             if (isset($_SESSION['customer_id'])) {
                 $customer_id = $_SESSION['customer_id'];}
            //prepare and bind data
            $stmt = $connection->prepare("DELETE FROM cart WHERE customer_id = ?");
            $stmt->bind_param("i", $customer_id);     
            //execute and print errors
             if ($stmt->execute()) {
                echo "Checkout Complete Thanks for Shopping";}
                 elseif ($stmt->error) {
                echo "Error: " . $stmt->error;}
             else
             {die();}
             $stmt->close();
$connection->close();

