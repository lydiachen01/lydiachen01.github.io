<?php
session_start();

$server = "localhost";
$userid = "u9rnmkwnhqk3j";
$pw = "@*2l@2f7i%&2";
$db = "dbygr11xzpv4y5";

$conn = new mysqli($server, $userid, $pw, $db);

// Make sure to delete later!!
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        echo 'User with this email already exists';
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO user_table (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            $userID = $stmt->insert_id;
            $_SESSION['userID'] = $userID;
            $_SESSION['loginStatus'] = 'success';

            header("Location: user_profile.php");
            exit();
        } else {
            // Registration failed
            $status = 'failure';
            header("Location: registration.html?status=$status");
            exit();
        }
    }
}
?>
