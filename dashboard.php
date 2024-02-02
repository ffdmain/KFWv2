<?php
session_start();

// Check if the user is logged in (you may have your own authentication logic)
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Check if the logged-in user is an admin (you may have a different way to identify admins)
$isAdmin = false; // Set to true if the user is an admin (based on your logic)

require_once 'database.php'; // Include the database connection script

// Fetch all records from the users table
$query = "SELECT * FROM users";
$result = $db->query($query);

if (!$result) {
    die("Query failed: " . $db->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>

    <?php if ($isAdmin) : ?>
        <h2>User Records</h2>
        <table border="1">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['user_id']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['user_type']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>You do not have permission to view this page.</p>
    <?php endif; ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
