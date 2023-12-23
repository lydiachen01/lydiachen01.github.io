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
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Validate the credentials against the database
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Authentication passed
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['loginStatus'] = 'success';
            $status = 'success';
            header("Location: user_profile.php");
            exit();
        }
    }

    // Authentication failed
    $status = 'failure';
    header("Location: login.html?status=$status");
    exit();
}
?>
