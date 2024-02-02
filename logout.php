<?php
session_start();

// Check if the user_type is set in the session
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'admin') {
        // If the user is an admin, redirect to the admin dashboard
        header("Location: admin_dashboard.php");
    } else {
        // If the user is not an admin, redirect to the customer dashboard or any other appropriate page
        header("Location: customer_dashboard.php");
    }
}

// Clear the session data
session_unset();
session_destroy();
exit(); // Exit after clearing the session
?>
