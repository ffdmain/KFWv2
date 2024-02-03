<?php
require_once 'database.php'; // Include the database connection script
require_once 'UserManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $userManager = new UserManager($db); // Pass the $db connection to UserManager

    if ($userManager->registerUser($username, $password, $email, 'customer')) {
        echo "Registration successful. You can now <a href='login.php'>login</a>.";
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/styles1.css">
  <script src="js/validation.js"></script>
</head>
<body>
  <main>
    <section class="register-form">
        <h1>Register</h1>
  <?php include('header.php'); ?>
    <form method="post" action="registration.php">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</section>
</main>
</body>
</html>
