<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CDN -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100;0,9..144,200;0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,100&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <title>Checkout Page 🍵</title>
    <style>
        #checkoutPage {
            padding-top: 80px;
            margin: 0 250px;
        }

        li {
            margin: 10px;
        }

        strong {
            display: block;
            text-align: right;
            margin-right: 20px;
        }

        button {
            background-color: #416843;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #094f23;
        }

        #thankYouMessage {
            font-size: 50px;
            margin: 60px auto;
            width: 50%;
            text-align: center;
        }

        .hide-text {
            display: none;
        }

        .navbar-btn {
            background-color: transparent;
        }

        #cTitle {
            font-weight: bold;
            font-size: 30px;
        }
        .minorTitle{
            font-size: 20px;
            font-weight:500;
        }


        /* Responsive Styles */
        @media (max-width: 576px) {
            #checkoutPage {
                margin: 0 125px;
            }

            #thankYouMessage {
                width: 80%;
            }
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
</head>

<body>
    <!-- Navbar Component -->
    <div id="header" style="z-index: 100;"></div>
    <script>
        $(function () {
            $("#header").load("navbar.php");
        });
    </script>
    <form method="post" action="process_checkout.php"> 
    <div id="checkoutPage">
        <h1 style="text-align: center;" id="cTitle">Checkout</h1>
        <!-- Shipping Address Form -->
        <div id="shippingAddress" class="mb-2">
            <h2 class= "minorTitle">Shipping Address</h2>
            <form id="shippingForm" >
                <div class="mb-2">
                    <label for="fullName" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" style="max-width: 100%;" required>
                </div>

                <div class="mb-2">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" style="max-width: 100%;" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="city" class="form-label">City:</label>
                        <input type="text" class="form-control" id="city" name="city" style="max-width: 100%;" required>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="state" class="form-label">State:</label>
                        <input type="text" class="form-control" id="state" name="state" style="max-width: 100%;" required>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="zipCode" class="form-label">Zip Code:</label>
                        <input type="text" class="form-control" id="zipCode" name="zipCode" style="max-width: 100%;" required>
                    </div>
                </div>    
            </form>
        </div>

        <!-- Payment Info Form -->
        <div id="paymentInfo" class="mb-2">
            <h2 class= "minorTitle">Payment Information</h2>
            <form id="paymentForm">
                <div class="mb-2">
                    <label for="cardNumber" class="form-label">Card Number:</label>
                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" style="max-width: 100%;" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="expiryDate" class="form-label">Expiry Date:</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" style="max-width: 100%;"
                            placeholder="MM/YYYY" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="cvv" class="form-label">CVV:</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" style="max-width: 100%;" required>
                    </div>
                </div>
            </form>
        </div>

        <hr><br/>

        <!-- Cart Items -->
        <div id="cartItems" class="mb-2">
            <h2 class= "minorTitle">Cart Items</h2>
            <ol id="checkout-items">
                <!-- Cart items will be displayed here -->
            </ol>
        </div>

        <!-- Subtotals and Totals -->
        <div id="totals" class="mb-2">
            <h2 class= "minorTitle">Totals</h2>
            <p id="subtotal">Subtotal: $0.00</p>
            <p id="tax">Tax (6.25%): $0.00</p>
            <p id="total" style="font-weight: 1000;">Total: $0.00</p>
        </div>

        <input type="hidden" name="cartData" id="cartDataInput" value="">
        <div class="d-flex justify-content-center mb-2">
        <button id="thankYouButton" class="btn btn-success" type="submit" style = "background-color: #416843;">Complete Purchase</button>
        </div>
    </form>
        
        <!-- Thank You Message -->
        <p id="thankYouMessage" class="hide-text">Thank you for shopping with us!!</p>
    </div>

    

    <script>
        let cart = {};

        function hideElements() {
            const checkoutItems = document.getElementById('checkout-items');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const thankYouButton = document.getElementById('thankYouButton');
            const checkoutTitle = document.getElementById('cTitle');

            checkoutItems.classList.add('hide-text');
            subtotalElement.classList.add('hide-text');
            taxElement.classList.add('hide-text');
            totalElement.classList.add('hide-text');
            thankYouButton.classList.add('hide-text');
            checkoutTitle.classList.add('hide-text');
        }

        function showThankYouMessage() {
            const thankYouMessage = document.getElementById('thankYouMessage');
            thankYouMessage.style.display = 'block';
        }

        document.addEventListener("DOMContentLoaded", function () {
            const checkoutItems = document.getElementById('checkout-items');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const thankYouButton = document.getElementById('thankYouButton');
            const checkoutTitle = document.getElementById('cTitle');

            <?php

                $conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $query = "SELECT productName, price FROM product_table";
                $result = mysqli_query($conn, $query);

                $prices = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    $prices[$row['productName']] = $row['price'];
                }

                mysqli_close($conn);
                ?>


            const teaPrices = <?php echo json_encode($prices); ?>;

            function getUrlParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            const cartData = getUrlParameter('cartData');

            if (cartData) {
                cart = JSON.parse(decodeURIComponent(cartData));
                console.log('Cart:', cart);
            } else {
                console.log('Cart is empty or undefined.');
            }

            let subtotal = 0;
            const taxRate = 0.0625;

            for (const productName in cart) {
                const quantity = cart[productName];
                const itemPrice = calculateItemPrice(productName);
                const teaSubtotal = itemPrice * quantity;
                subtotal += teaSubtotal;

                const li = document.createElement('li');
                li.innerHTML = `${productName} x ${quantity}<strong>$${teaSubtotal.toFixed(2)}</strong>`;
                checkoutItems.appendChild(li);
            }
            const tax = subtotal * taxRate;
            const total = subtotal + tax;

            subtotalElement.innerHTML = `Subtotal: <strong>$${subtotal.toFixed(2)}</strong>`;
            taxElement.innerHTML = `Tax (6.25%): <strong>$${tax.toFixed(2)}</strong>`;
            totalElement.innerHTML = `TOTAL <strong>$${total.toFixed(2)}</strong>`;

            function calculateItemPrice(itemName) {
                return teaPrices[itemName];
            }


        thankYouButton.addEventListener('click', function () {
            const cartData = JSON.stringify(cart);
            document.getElementById('cartDataInput').value = cartData;
            window.location.href = 'index.html';    
        });

        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Footer -->
</body>

</html>
