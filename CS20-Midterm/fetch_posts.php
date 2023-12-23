<?php

// Assuming you have a database connection
$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts with associated usernames from the database
$selectPostsQuery = "SELECT post_table.*, user_table.username 
                     FROM post_table 
                     JOIN user_table ON post_table.userID = user_table.userID                      
                     ORDER BY post_table.postID";

$result = $conn->query($selectPostsQuery);

if ($result->num_rows > 0) {
    $posts = array();

    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    // Output posts as JSON
    header('Content-Type: application/json');
    echo json_encode($posts);
} else {
    // No posts found
    echo json_encode(['error' => 'No posts found']);
}

// Close the database connection
$conn->close();
?>
