<?php
    session_start();
    session_destroy();
    // Redirect to the login page or handle as needed
    header("Location: login.html");
    exit();
?>