<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Products</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="product_shop">
            <h1 class="heading">Products</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID |</th>
                        <th>Product Name |</th>
                        <th>Price |</th>
                        <th>Exp. Date |</th>
                        <th>Quantity |</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Start Session
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
                    // -- Add Selected Product to Customer Cart --
                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
                        $customer_id = $_SESSION['customer_id'];
                        $product_id = $_POST['product_id'];
                        $product_name = $_POST['product_name'];
                        $sell_price = $_POST['sell_price'];
                        // Insert Selected Product Into Customer Cart
                        $add_cart_sql_stmt = $connection->prepare("INSERT INTO cart (customer_id, product_id, product_name, product_cost)
                            VALUES (?, ?, ?, ?)");
                        $add_cart_sql_stmt->bind_param("iiss", $customer_id, $product_id, $product_name, $sell_price);
                        $add_cart_sql_stmt->execute();
                        if($add_cart_sql_stmt->error) {
                            echo "SQL Error: " . $add_cart_sql_stmt->error;
                        }
                        $add_cart_sql_stmt->close();
                        // Update Product Quantity
                        $lower_product_amount_sql_stmt = $connection->prepare("UPDATE supplied_by SET product_amount = product_amount - 1 WHERE store_product_id = ?");
                        $lower_product_amount_sql_stmt->bind_param("i", $product_id);
                        $lower_product_amount_sql_stmt->execute();
                        if($lower_product_amount_sql_stmt->error) {
                            echo "SQL Error: " . $lower_product_amount_sql_stmt->error;
                        }
                        $lower_product_amount_sql_stmt->close();
                    }
                    // -- Display Products --
                    $display_product_sql_stmt = $connection->query("
                        SELECT p.product_id, p.product_name, p.sell_price, p.exp_date, sb.product_amount
                        FROM product p
                        LEFT JOIN supplied_by sb ON p.product_id = sb.store_product_id
                    ");
                    if($display_product_sql_stmt->num_rows > 0){
                        while($row = $display_product_sql_stmt->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sell_price']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['exp_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['product_amount']) . "</td>";
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
                    } else {
                        echo "<tr>No products found</tr>";
                    }
                    // Close Connection
                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="shopping_cart">
            <h1 class="heading">Shopping Cart</h1>
            <table>
                <thead>
                    <tr>
                        <th>Product Name |</th>
                        <th>Price |</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get 'customer_id' From PHP Session
                    $customer_id = $_SESSION['customer_id'];
                    // Setup MySQL Connection
                    $connection = new mysqli($hostname, $username, $password, $dbname);
                    // Check MySQL Connection
                    if($connection->connect_error){
                        die("query failed" . $connection->connect_error);
                    }
                    // -- Remove Product from Customer Cart --
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
                        // Get Selected Products 'product_id'
                        $product_id = $_POST['remove_product_id'];
                        // Remove Product From Customer Cart
                        $delete_cart_sql_stmt = $connection->prepare("DELETE FROM cart WHERE customer_id = ? AND product_id = ?");
                        $delete_cart_sql_stmt->bind_param("ii", $customer_id, $product_id);
                        $delete_cart_sql_stmt->execute();
                        $delete_cart_sql_stmt->close();
                        // Update Product Quantity
                        $raise_product_amount_sql_stmt = $connection->prepare("UPDATE supplied_by SET product_amount = product_amount + 1 WHERE store_product_id = ?");
                        $raise_product_amount_sql_stmt->bind_param("i", $product_id);
                        $raise_product_amount_sql_stmt->execute();
                        $raise_product_amount_sql_stmt->close();
                    }
                    // -- Display Customer Cart --
                    $select_cart_sql_stmt = $connection->query("SELECT product_id, product_name, product_cost FROM cart WHERE customer_id = $customer_id GROUP BY product_id");
                    if($select_cart_sql_stmt->num_rows > 0){
                        while($row = $select_cart_sql_stmt->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['product_cost']) . "</td>";
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
                    // Close Connection
                    $connection->close();
                    ?>
                </tbody>
            </table>
            <h4>Grand Total:</h4>
            <?php
            // Setup MySQL Connection
            $connection = new mysqli($hostname, $username, $password, $dbname);
            // Check Connection
            if($connection->connect_error){
                die("query failed" . $connection->connect_error);
            }
            // -- Determine Total Cost of Customer Cart --
            $total_cost_sql_stmt = $connection->query("SELECT SUM(product_cost) as grand_total FROM cart WHERE customer_id = $customer_id");
            if($total_cost_sql_stmt->num_rows > 0){
                $row = $total_cost_sql_stmt->fetch_assoc();
                echo "<h4>" . htmlspecialchars($row['grand_total']) . "</h4>";
            }
            // Close Connection
            $connection->close();
            ?>
            <form action="Checkout.html">
                <input type="submit" value="Checkout">
            </form>
        </div>
    </body>
</html>
