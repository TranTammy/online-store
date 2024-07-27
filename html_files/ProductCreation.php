<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$productID = $_POST['ProductID'];
	$productName = $_POST['ProductName'];
	$expDate = $_POST['Exp_Date'];
	$price = $_POST['Price'];
	$deptID = $_POST['Dept_ID'];

	$servername = "localhost";
	$username = "root"
	$password = "";
	$dbname = "online store";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if($conn->connect_error){
		die("query failed" . $conn->connect_error);
	}

	$stmt = $conn->prepare("INSERT INTO product (product_id, product_name, exp_date, sell_price, dept_id) VALUES (?, ?, ?, ?, ?");
	$stmt->bind_param("issdi", $productID, $productName, $expDate, $price, $deptID);

	if($stmt->execute()){
		header("Location: EmployeeHomepage.html");
		die();
	}
	else{
		header("Location: ProductCreation.html?error=Invalid_Date");
		die();
	}

	$stmt->close();
	$conn->close();
}
?>