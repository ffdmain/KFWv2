<?php
session_start();

require_once 'database.php'; // Include the database connection script
require_once 'UserManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userManager = new UserManager($db);

    if ($userManager->loginUser($username, $password)) {
        // Successful login, redirect to the dashboard based on user_type
        if ($_SESSION['user_type'] === 'admin') {
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        } else {
            $_SESSION['username'] = $username; // Set the username in the session
            header("Location: customer_dashboard.php"); // Redirect to normal user dashboard
        }
        exit();
    } else {
        echo "Login failed. Please check your username and password.";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Kentucky Fried Weed</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/styles1.css">
  <script src="js/validation.js"></script>
</head>
<body>
  <main>
  <?php include('header.php'); ?>
  <section class="login-form" style="margin-top: 50px;">
    <h1>Login</h1>
    <form method="post" action="login.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    </section>
  </main>
  <?php include('footer.php'); ?>
</body>
</html>