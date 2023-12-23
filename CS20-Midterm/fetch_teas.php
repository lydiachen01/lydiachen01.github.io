<?php

// Include your database connection code or configuration file here

$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

// Check connection
if ($conn->connect_error) {
    // Provide a JSON-formatted error response
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Query to fetch tea names from the database
$sql = "SELECT productName AS name, image, description FROM product_table";
$result = $conn->query($sql);

// Fetch tea names into an array of objects
while ($row = mysqli_fetch_assoc($result)) {
    $teas[] = array(
        'name' => $row['name'],
        'description' => $row['description'],
        'image' => $row['image']
    );
}

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Return the data as JSON
echo json_encode($teas);

// Close the database connection
$conn->close();

?>
