<?php
session_start();

require_once 'database.php'; // Include the database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sender_name']) && isset($_POST['sender_email']) && isset($_POST['message'])) {
        $sender_name = $_POST['sender_name'];
        $sender_email = $_POST['sender_email'];
        $message = $_POST['message'];

        $query = "INSERT INTO contactform (sender_name, sender_email, message, submission_date) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sss", $sender_name, $sender_email, $message);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                echo '<p class="success">Your message has been submitted successfully.</p>';
            } else {
                echo '<p class="error">Error: Record insertion failed.</p>';
            }
        } else {
            echo '<p class="error">Error: Preparation of SQL statement failed.</p>';
        }
    } else {
        echo '<p class="error">Error: Form fields are not set correctly.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Kentucky Fried Weed</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/styles1.css">
</head>
<body>
  <main>
  <?php include('header.php'); ?>
    <section class="contact-section">
      <h2>Get in Touch</h2>
      <p>Have questions or feedback? Feel free to reach out to us!</p>
      <form method="POST">
        <label for="sender_name">Name</label>
        <input type="text" id="sender_name" name="sender_name" required><br><br>

        <label for="sender_email">Email</label>
        <input type="email" id="sender_email" name="sender_email" required><br><br>

        <label for="message">Message</label><br>
        <textarea id="message" name="message" rows="4" required></textarea><br><br>

        <input type="submit" name="submit" value="Submit">
      </form>
    </section>
  </main>

  <?php include('footer.php'); ?>
</body>
</html>