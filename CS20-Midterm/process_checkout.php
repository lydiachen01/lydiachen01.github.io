<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get the currently logged-in user ID
$userID = $_SESSION['userID'] ?? null;

// Validate and sanitize form data
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';

// Check if any required fields are empty
if (empty($userID) || empty($address)) {
    die("Invalid user or shipping address. userID: $userID, address: $address");
}

// Retrieve cart data from the form
$cartData = isset($_POST['cartData']) ? json_decode($_POST['cartData'], true) : [];

// Insert data into the order_table
$sqlOrder = "INSERT INTO `order_table` (userID, shippingAddress) VALUES ($userID, '$address')";

// Check if the order_table exists
if ($conn->query($sqlOrder) === FALSE) {
    die("Error inserting into order_table: " . $conn->error);
}

// Retrieve the auto-generated orderID
$orderID = $conn->insert_id;

// Insert order items into the OrderItem table
foreach ($cartData as $productName => $quantity) {
    // Retrieve productID from the product_table based on productName
    $sqlProductID = "SELECT productID FROM product_table WHERE productName = '$productName'";
    $result = $conn->query($sqlProductID);
    $row = $result->fetch_assoc();
    $productID = $row['productID'];

    // Insert data into the OrderItem table
    $sqlOrderItem = "INSERT INTO OrderItem (orderID, productID, quantity) VALUES ($orderID, $productID, $quantity)";
    $conn->query($sqlOrderItem);
}

// Calculate total price for the order
$totalPrice = calculateTotalPrice($conn, $cartData);

// Update the price field in the order_table
$sqlUpdateOrder = "UPDATE `order_table` SET price = $totalPrice WHERE orderID = $orderID";
$conn->query($sqlUpdateOrder);

// Close the database connection
$conn->close();

// Redirect to the thank-you page or order confirmation page
header("Location: index.html");
exit();

function calculateTotalPrice($conn, $cartData) {
    $totalPrice = 0;

    foreach ($cartData as $productName => $quantity) {
        // Retrieve product price from the product_table based on productName
        $sqlProductPrice = "SELECT price FROM product_table WHERE productName = '$productName'";
        $result = $conn->query($sqlProductPrice);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productPrice = $row['price'];
            $totalPrice += $productPrice * $quantity;
        }
    }

    return $totalPrice;
}
?>
