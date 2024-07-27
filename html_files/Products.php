<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Products</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="products">
            <h1 class="heading">Products</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Expiration Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        session_start();
                        // Database Information
                        $hostname = "localhost";
                        $username = "root";
                        $password = "Evergreen6167!";
                        $dbname = "cs4347_project";

                        // Setup MySQL Connection
                        $connection = new mysqli($hostname, $username, $password, $dbname);

                        // Check Connection
                        if($connection->connect_error){
                            die("Connection Failed: " . $connection->connect_error);
                        }

                        // Get Current Customer Cart
                        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
                            $customer_id = $_SESSION['customer_id'];
                            $product_id = $_POST['product_id'];
                            $product_name = $_POST['product_name'];
                            $sell_price = $_POST['sell_price'];

                            // Insert Selected Product Into Customer Cart
                            $sql_stmt = $connection->prepare("INSERT INTO cart (customer_id, product_id, product_name, product_cost)
                                VALUES (?, ?, ?, ?)");
                            $sql_stmt->bind_param("iiss", $customer_id, $product_id, $product_name, $sell_price);

                            if($sql_stmt->execute()){
                                echo "Added to cart";
                            }
                            else{
                                echo "SQL Error: " . $sql_stmt->error;
                            }
                            // Close SQL Statement
                            $sql_stmt->close();
                        }

                        // Display Products
                        $select_product = $connection->query("SELECT * FROM product");
                        if($select_product->num_rows > 0){
                            while($row = $select_product->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['sell_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['exp_date']) . "</td>";
                                echo "<td>
                                                <form method='post'>
                                                    <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                                                    <input type='hidden' name='product_name' value='" . htmlspecialchars($row['product_name']) . "'>
                                                    <input type='hidden' name='sell_price' value='" . htmlspecialchars($row['sell_price']) . "'>
                                                    <button type='submit'>Add to Cart</button>
                                                </form>
                                                </td>";
                                echo "</tr>";
                            }
                        }
                        else{
                            echo "<tr>No products found</tr>";
                        }
                        // Close Connection
                        $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart">
            <h1 class="heading">Shopping Cart</h1>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $customer_id = $_SESSION['customer_id']; //user getter to replace customer id

                $connection = new mysqli($hostname, $username, $password, $dbname);

                if($connection->connect_error){
                    die("query failed" . $connection->connect_error);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
                    $product_id = $_POST['remove_product_id'];

                    // Prepare and execute the delete query
                    $stmt = $connection->prepare("DELETE FROM cart WHERE customer_id = ? AND product_id = ?");
                    $stmt->bind_param("ii", $customer_id, $product_id);
                    $stmt->execute();
                    $stmt->close();
                }

                $select_cart = $connection->query("SELECT product_id, product_name, product_cost, COUNT(*) as quantity, SUM(product_cost) as total_price FROM cart WHERE customer_id = $customer_id GROUP BY product_id");

                if($select_cart->num_rows > 0){
                    while($row = $select_cart->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['product_cost']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='remove_product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
                        echo "<button type='submit'>Remove</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>No items in cart</tr>";
                }

                $connection->close();
                ?>
                </tbody>
            </table>

            <h4>Grand Total:</h4>
            <?php
            $connection = new mysqli($hostname, $username, $password, $dbname);

            if($connection->connect_error){
                die("query failed" . $connection->connect_error);
            }

            $total = $connection->query("SELECT SUM(product_cost) as grand_total FROM cart WHERE customer_id = $customer_id");

            if($total){
                $row = $total->fetch_assoc();
                echo "<h4>" . htmlspecialchars($row['grand_total']) . "</h4>";
            }

            $connection->close();
            ?>

            <div class="cart-btn">
                <button type="button">Checkout</button>
            </div>
        </div>
    </body>
</html>