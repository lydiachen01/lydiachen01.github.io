<?php
session_start();

$server = "localhost";
$userid = "u9rnmkwnhqk3j";
$pw = "@*2l@2f7i%&2";
$db = "dbygr11xzpv4y5";

$conn = new mysqli($server, $userid, $pw, $db);

$userID = $_SESSION['userID'];

// Fetch user information from the database
$stmt = $conn->prepare("SELECT * FROM user_table WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // User found, fetch user details
    $userDetails = $result->fetch_assoc();
    $email = $userDetails['email'];
    $username = $userDetails['username'];
}

$stmt->close();

// Fetch user's past orders from the database, ordered by orderID in descending order
$stmt_orders = $conn->prepare("
    SELECT ot.orderID, oi.quantity, pt.productName
    FROM order_table ot
    JOIN OrderItem oi ON ot.orderID = oi.orderID
    JOIN product_table pt ON oi.productID = pt.productID
    WHERE ot.userID = ?
    ORDER BY ot.orderID DESC
");

$stmt_orders->bind_param("i", $userID);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();

$orders = [];
while ($row = $result_orders->fetch_assoc()) {
    $orderID = $row['orderID'];
    if (!isset($orders[$orderID])) {
        $orders[$orderID] = ['products' => []];
    }
    $orders[$orderID]['orderID'] = $orderID;
    $orders[$orderID]['products'][] = ['productName' => $row['productName'], 'quantity' => $row['quantity']];
}

$stmt_orders->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100;0,9..144,200;0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,100&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap"
        rel="stylesheet">
    <title>Profile</title>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            font-size: 16px;
            margin: 0;
            line-height: 1.6;
            color: #333;
        }

        .parent {
            display: flex;
            position: relative;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .profile {
            display: block;
            margin: 100px 10%;
            max-width: 1000px;
            padding: 2em;
            font-family: 'Fraunces', serif;
            border: 1px solid olivedrab;
            background-color: #fff; /* Set background color */
            border-radius: 20px; /* Add border-radius for rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
        }

        .left {
            position: relative;
            padding-right: 20px; /* Add padding to separate from the right content */
        }

        .category {
            position: relative;
        }

        .left nav {
            background-color: #f5f5f5; /* Set background color for the sidebar */
            border-radius: 10px; /* Add border-radius for rounded corners */
            padding: 10px; /* Add padding */
        }

        .left a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 10px;
            width: 100%;
            transition: background-color 0.3s ease-in-out;
        }

        .left a:hover {
            background-color: #e0e0e0; /* Add a hover effect */
        }

        .right {
            padding: 0 0 0 20px; /* Adjust padding */
        }

        label {
            font-size: 25px;
            font-weight: bold;
        }

        .box {
        text-align: left;
        background-color: rgba(106, 142, 35, 0.225);
        padding: 10px; /* Adjust padding */
        border-radius: 10px; /* Add border-radius for rounded corners */
        margin-bottom: 20px; /* Adjust margin */
        }

        #profilePictureContainer img {
            margin: 0 auto;
        }
        
        .profile-picture-container {
            margin: 10px 0; /* Adjust margin as needed */
        }

        #profilePictureContainer img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }

        .username-left {
            text-align: center;
            font-size: 32px;
            margin: 10px 0; /* Adjust margin as needed */
        }

        /* For mobile phones and tablets: */
        @media only screen and (max-width: 768px) {
            #profile-box {
                grid-template-columns: repeat(1, 1fr) !important;
            }
            .right {
                margin-top: 2em;
                margin-left: 0;
                padding-left: 0;
            }

            .left {
                padding-right: 0px;
            }
        }

        /* For desktop: */
        /* @media only screen and (min-width: 769px) {
            #profile-box {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .right {
                margin-top: 2em;
                margin-left: 0;
                padding-left: 0;
            }
            /* .left {
                padding-right: 0px;
            } */
        } */

    </style>
</head>
<body>
    <!-- Navbar Component -->
    <div id="header" style="z-index:100;"></div>
    <script>
        $(function() {
            $("#header").load("navbar.php");
        });
    </script>

    <div class="parent">
        <div id="profile-box" class="profile grid-cols-2 grid mx-6" style="width:1200px;">
            <!-- Sidebar -->
            <div class="left">
                <div class="profile-picture-container" id="profilePictureContainer"></div>

                <nav class="category">
                    <a href="#user-info"><div>User Info</div></a>
                    <a href="#order-history"><div>Order History</div></a>
                </nav>
            </div>

            <div class="right">

                <!-- User Info/Contact Info -->
                <div id="user-info">
                    <label class="block text-lg">User Info</label>
                    <div class="box">
                        <div>Username: <?php echo $username; ?></div>
                        <div>Email: <?php echo $email; ?></div>
                    </div>
                </div>
            
                <!-- Order History -->
                <div id="order-history" class="mt-4 block">
                    <label class="block text-lg">Order History</label>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="box">
                                <div>Order ID: <?php echo $order['orderID']; ?></div>
                                <?php foreach ($order['products'] as $product): ?>
                                    <div><?php echo $product['productName']; ?> x <?php echo $product['quantity']; ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>No order history available.</div>
                    <?php endif; ?>
                </div>
                
            </div>
            <!-- end of profile -->
        </div>
        <!-- end of parent -->
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Assuming you have a profile picture file in the 'images' folder
        var profilePicturePath = "./assests/black_tea.jpg";
        var username = '<?php echo $username; ?>';

        var profileContainer = document.getElementById('profilePictureContainer');

        // Create an img element for the profile picture
        var imgElement = document.createElement('img');
        imgElement.src = profilePicturePath;
        imgElement.alt = 'Profile Picture';
        imgElement.style.width = '200px';
        imgElement.style.height = '200px';
        imgElement.style.borderRadius = '50%';

        // Create a div for user information
        var userInfoDiv = document.createElement('div');
        userInfoDiv.className = "username-left";
        userInfoDiv.innerHTML = '<div><b style="font-size:32px; margin: 0 auto;">' + username + '</b></div>';

        // Append the profile picture and user information to the container
        profileContainer.appendChild(imgElement);
        profileContainer.appendChild(userInfoDiv);
    });
</script>
</body>
</html>