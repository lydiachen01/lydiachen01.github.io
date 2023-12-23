<?php
session_start();

$conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

if ($conn->connect_error) {
  // Provide a JSON-formatted error response
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
  exit;
}

// Query to fetch tea names from the database
$sql = "SELECT productName AS name, image, description FROM product_table";
$result = $conn->query($sql);

$userID = $_SESSION['userID'];

$query = $conn->prepare("SELECT * FROM user_table WHERE userID = ?");
$query->bind_param("i", $userID);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
  $userDetails = $result->fetch_assoc();
  $username = $userDetails['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Navigation Bar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100;0,9..144,200;0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,700;0,9..144,800;0,9..144,900;1,9..144,100&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      nav {
        display: block;
        position: fixed;
        background-color: white;
        /* font-family: 'Inter', sans-serif; */
        /* font-family: 'Fraunces', serif; */
        font-family: 'Poppins', sans-serif;
        width: 100%;
        z-index: 999;
      }

      @media screen and (max-width: 639px){
        #logo{
          margin-left: 4.5em;
        }

        #ham-bar {
          margin-left: 1em;
        }
      }

      @media screen and (min-width: 639px) {
        #mobile-menu {
          display: none;
        }
      }
    </style>
  
</head>
<body>
    <nav style="border-bottom: 2px solid rgba(128, 128, 128, 0.547)">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-16 items-center justify-between">
            <div id="ham-bar" class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <!-- Mobile menu button-->
              <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Open main menu</span>
                <!--
                  Icon when menu is closed.
      
                  Menu open: "hidden", Menu closed: "block"
                -->
                <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <!--
                  Icon when menu is open.
      
                  Menu open: "block", Menu closed: "hidden"
                -->
                <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>

                <script>
                  var mobileButton = document.querySelector('[aria-controls="mobile-menu"]');
                  var mobileMenu = document.getElementById('mobile-menu');
                  mobileButton.addEventListener('click', function () {
                      mobileMenu.classList.toggle('hidden');
                  });
                </script>
              </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
              <a href="index.html">
                <div class="flex flex-shrink-0 justify-center items-center">
                    <img id="logo" style="margin-top: 2px;" class="h-8 mx-6 w-auto" src="./assests/Teatopia-Logo.png" alt="Teatopia">
                </div>
              </a>
              <div class="hidden sm:ml-6 sm:block">
                <div class="flex space-x-4" style="font-family: 'Poppins', sans-serif;">
                  <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                  <a href="catalog.html" class="text-black-300 hover:text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Shop</a>
                  <a href="benefits_of_tea.html" class="text-black-300 hover:text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Benefits</a>
                  <a href="contacts.html" class="text-black-300 hover:text-gray-300 rounded-md px-3 py-2 text-sm font-medium">Contact</a>
                </div>
              </div>
            </div>
      
              <!-- Profile dropdown -->
              <div class="relative ml-3" id="user-menu">
                <div style="display: flex;">
                  <!-- Display Username -->
                  <div style="
                      font-size: 16px; 
                      font-weight: normal; 
                      place-items: center; 
                      margin-top: 3px;"><?php echo $username?></div>  

                  <!-- Checkout and Profile Icons -->
                  <div>
                    <!-- Tea Profile Picture -->
                    <div id="tea-profile-pic" class="hidden">
                      <button type="button" class="navbar-btn relative flex text-sm h-7" id="tea-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        <span class="flex items-center"><img class="h-7 w-7 mx-2 rounded-full" src="./assests/black_tea.jpg" alt="profile"></span>
                      </button>

                      <script>
                         // Show the profile menu on hover
                        document.getElementById('tea-menu-button').addEventListener('click', function () {
                          document.getElementById('profile-menu').classList.toggle('hidden');
                        });
                      </script>
                    </div>

                    <!-- Default Login -->
                    <a href="login.html" id="default-login" class="">
                      <button style="margin-top:4px" type="button" class="navbar-btn relative flex text-sm" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        <span class="flex items-center"><img class="h-5 w-5 mx-2" src="./assests/user_default.png" alt="profile"></span>
                      </button>
                    </a>
                  </div>
                </div>
      
                <!-- Profile Dropdown Menu -->
                <div id="profile-menu" class="hidden" style="font-family: 'Poppins', sans-serif;">
                  <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <a href="user_profile.php" class="hover:bg-gray-200 block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                    <a href="discussion.html" class="hover:bg-gray-200 block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Discussion</a>
                    <a onclick="signOutAndRedirect(event)" class="hover:bg-gray-200 block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign Out</a>
                
                    <script>
                        function signOutAndRedirect(e) {
                          e.preventDefault();
                          document.getElementById('profile-menu').classList.add('hidden');
                          document.getElementById('tea-profile-pic').classList.add('hidden');
                          document.getElementById('default-login').classList.remove('hidden');

                          window.location.href = 'signout.php';
                        }
                    </script>                                      
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden" id="mobile-menu">
          <div class="space-y-1 px-2 pb-3 pt-2">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="catalog.html" style="font-family: 'Poppins', sans-serif;" class="text-gray-500 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Shop</a>
            <a href="benefits_of_tea.html" style="font-family: 'Poppins', sans-serif;" class="text-gray-500 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Benefits</a>
            <a href="contacts.html" style="font-family: 'Poppins', sans-serif;" class="text-gray-500 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Contact</a>
          </div>
        </div>
      </nav>   

      <script>
      const loginStatus = "<?php echo isset($_SESSION['loginStatus']) ? $_SESSION['loginStatus'] : 'failure'; ?>";

      if (loginStatus === "success") {
          document.getElementById('tea-profile-pic').classList.remove('hidden');
          document.getElementById('default-login').classList.add('hidden');
      }
    </script>
</body>
</html>