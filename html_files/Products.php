<!DOCTYPE html>
<html lang="en">
<head>

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
                
                $servername = "localhost";
                $username = "root"; //change to personal mysql username
                $password = ""; //change to personal mysql password
                $dbname = "online store"; //change to mysql database name

                $conn = new mysqli("localhost", $username, $password, $dbname);

                if($conn->connect_error){
                    die("query failed" . $conn->connect_error);
                }

                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])){
                    $customer_id = 1; //replace w get customer id from log in
                    $product_id = $_POST['product_id'];
                    $product_name = $_POST['product_name'];
                    $sell_price = $_POST['sell_price'];

                    $stmt = $conn->prepare("INSERT INTO cart (customer_id, product_id, product_name, sell_price) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiss", $customer_id, $product_id, $product_name, $sell_price);

                    if($stmt->execute()){
                        echo "Added to cart";
                    }
                    else{
                        echo "Error" . $stmt->error;
                    }

                    $stmt->close();
                }

                $select_product = $conn->query("SELECT * FROM product");
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
                                    <button type='confirm'>Add to Cart</button>
                                </form>
                                </td>";
                        echo "</tr>";
                    }
                }
                else{
                    echo "<tr>No products found</tr>";
                }

                $conn->close();
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
                session_start();
                if (isset($_SESSION['customer_id']))
                {
                    echo "good"
                    $customer_id=$_SESSION['customer_id'];
                }
                 $conn = new mysqli($servername, $username, $password, $dbname);
                echo $customer_id
                if($conn->connect_error){
                    die("query failed" . $conn->connect_error);
                }

                $select_cart = $conn->query("SELECT product_name, product_cost, COUNT(*) as quantity, SUM(product_cost) as total_price FROM cart WHERE customer_id = $customer_id GROUP BY product_id");

                if($select_cart->num_rows > 0){
                    while($row = $select_cart->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['product_cost']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";

                        echo "<td><button type='button'>Remove</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>No items in cart</tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>

    <h4>Grand Total:</h4>
    <?php
        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn->connect_error){
            die("query failed" . $conn->connect_error);
        }
        
        $total = $conn->query("SELECT SUM(product_cost) as grand_total FROM cart WHERE customer_id = $customer_id");

        if($total){
            $row = $total->fetch_assoc();
            echo "<h4>" . htmlspecialchars($row['grand_total']) . "</h4>";
        }

        $conn->close();

    ?>

    <div class="cart-btn">
        <button type="button">Checkout</button>
    </div>
</div>
</body>
</html>
