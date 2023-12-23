<?php
// Start the session
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Assuming you have a database connection
$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];

    // Fetch user data based on user ID
    $selectUserQuery = "SELECT * FROM user_table WHERE userID = $userId";
    $result = $conn->query($selectUserQuery);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];

        $content = $_POST['content'];
        $title = $_POST['title'];

        if ($content && $title) {
            // Insert post data into post_table
            $postInsertQuery = "INSERT INTO post_table (content, title, userID) VALUES ('$content', '$title', '$userId')";
            
            if ($conn->query($postInsertQuery) === TRUE) {
                // Fetch the inserted post for response
                $postId = $conn->insert_id;
                $selectPostQuery = "SELECT * FROM post_table WHERE postID = $postId";
                $result = $conn->query($selectPostQuery);

                if ($result->num_rows > 0) {
                    $post = $result->fetch_assoc();
                    echo json_encode($post);
                } else {
                    echo json_encode(['error' => 'Error fetching post']);
                }
            } else {
                echo json_encode(['error' => 'Error inserting post: ' . $conn->error]);
            }
        } else {
            echo json_encode(['error' => 'Invalid input']);
        }
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}

// Close the database connection
$conn->close();
?>
