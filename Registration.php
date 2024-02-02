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
</head>
<body>
    <h1>Registration</h1>
    <form method="post" action="registration.php">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
