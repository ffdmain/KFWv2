<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php"); // Redirect non-admin users to the login page
    exit();
}

require_once 'database.php'; // Include the database connection script

// Fetch all records from the users table
$userQuery = "SELECT * FROM users";
$userResult = $db->query($userQuery);

if (!$userResult) {
    die("User query failed: " . $db->error);
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id_to_delete = $_POST['user_id_to_delete'];

    // Perform SQL DELETE to delete the user from the database
    $deleteUserQuery = "DELETE FROM users WHERE user_id = ?";
    $deleteUserStmt = $db->prepare($deleteUserQuery);
    $deleteUserStmt->bind_param("i", $user_id_to_delete);

    if ($deleteUserStmt->execute()) {
        // User deletion successful
        header("Location: admin_dashboard.php"); // Redirect to refresh the page
        exit();
    } else {
        echo "User deletion failed: " . $deleteUserStmt->error;
    }

    $deleteUserStmt->close();
}

require_once 'ProductManager.php'; // Include the ProductManager class

// Instantiate the ProductManager class
$productManager = new ProductManager();

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $image_path = 'public/images/' . $_FILES['product_image']['name'];
    $image_tmp = $_FILES['product_image']['tmp_name'];

    if (move_uploaded_file($image_tmp, $image_path)) {
        if ($productManager->createProduct($product_name, $product_description, $product_price, $product_quantity, $image_path)) {
            // Product creation successful
            header("Location: admin_dashboard.php"); // Redirect to refresh the page
            exit();
        } else {
            echo "Product creation failed.";
        }
    } else {
        echo "Image upload failed. Please try again.";
    }
}

// Handle product updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $updated_product_name = $_POST['updated_product_name'];
    $updated_product_description = $_POST['updated_product_description'];
    $updated_price = $_POST['updated_product_price'];
    $updated_quantity = $_POST['updated_product_quantity'];

    if ($productManager->updateProduct($product_id, $updated_product_name, $updated_product_description, $updated_price, $updated_quantity)) {
        // Product update successful
        echo "Product updated successfully.";
    } else {
        echo "Product update failed.";
    }
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id_to_delete = $_POST['product_id_to_delete'];

    if ($productManager->deleteProduct($product_id_to_delete)) {
        // Product deletion successful
        echo "Product deleted successfully.";
    } else {
        echo "Product deletion failed.";
    }
}

// Fetch all products
$products = $productManager->getAllProducts();

// Fetch all contact form submissions
$contactQuery = "SELECT * FROM contactform";
$contactResult = $db->query($contactQuery);

if (!$contactResult) {
    die("Contact form query failed: " . $db->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script>
        function updateProduct(productId) {
            // Collect updated product information from the user
            var updatedProductName = prompt("Enter updated product name:");
            var updatedProductDescription = prompt("Enter updated product description:");
            var updatedProductPrice = parseFloat(prompt("Enter updated product price:"));
            var updatedProductQuantity = parseInt(prompt("Enter updated product quantity:"));

            // Send the updated information to the server using AJAX
            if (updatedProductName !== null && updatedProductDescription !== null && !isNaN(updatedProductPrice) && !isNaN(updatedProductQuantity)) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        alert(this.responseText);
                        location.reload(); // Refresh the page to update the product list
                    }
                };
                xhttp.open("POST", "admin_dashboard.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("update_product=1&product_id=" + productId + "&updated_product_name=" + updatedProductName + "&updated_product_description=" + updatedProductDescription + "&updated_product_price=" + updatedProductPrice + "&updated_product_quantity=" + updatedProductQuantity);
            }
        }

        function deleteProduct(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                // Send the product ID to be deleted to the server using AJAX
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        alert(this.responseText);
                        location.reload(); // Refresh the page to update the product list
                    }
                };
                xhttp.open("POST", "admin_dashboard.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("delete_product=1&product_id_to_delete=" + productId);
            }
        }
    </script>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>User Records</h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Action</th>
        </tr>
        <?php while ($userRow = $userResult->fetch_assoc()) : ?>
            <tr>
                <td><?= $userRow['user_id']; ?></td>
                <td><?= $userRow['username']; ?></td>
                <td><?= $userRow['email']; ?></td>
                <td><?= $userRow['user_type']; ?></td>
                <td>
                    <!-- Form for user deletion -->
                    <form method="post" action="admin_dashboard.php">
                        <input type="hidden" name="user_id_to_delete" value="<?= $userRow['user_id']; ?>">
                        <input type="submit" name="delete_user" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Product Management</h2>
    <!-- Form for creating a new product -->
    <h3>Create New Product</h3>
    <form method="post" action="admin_dashboard.php" enctype="multipart/form-data">
        Product Name: <input type="text" name="product_name" required><br>
        Description: <textarea name="product_description" required></textarea><br>
        Price: <input type="number" name="product_price" step="0.01" required><br>
        Quantity: <input type="number" name="product_quantity" required><br>
        Image: <input type="file" name="product_image" accept="image/*" required><br>
        <input type="submit" name="create_product" value="Create Product">
    </form>

    <h3>Product List</h3>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $productRow) : ?>
            <tr>
                <td><?= $productRow['product_id']; ?></td>
                <td><?= $productRow['product_name']; ?></td>
                <td><?= $productRow['description']; ?></td>
                <td><?= $productRow['price']; ?></td>
                <td><?= $productRow['stock_quantity']; ?></td>
                <td><img src="<?= $productRow['image_path']; ?>" alt="Product Image" width="100"></td>
                <td>
                    <button onclick="updateProduct(<?= $productRow['product_id']; ?>)">Update</button>
                    <button onclick="deleteProduct(<?= $productRow['product_id']; ?>)">Delete</button>
                    <a href="product_detail.php?product_id=<?= $productRow['product_id']; ?>">View Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Contact Form Submissions</h2>
    <table border="1">
        <tr>
            <th>Submission ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Submission Date</th>
        </tr>
        <?php while ($submission = $contactResult->fetch_assoc()) : ?>
            <tr>
                <td><?= $submission['form_id']; ?></td>
                <td><?= $submission['sender_name']; ?></td>
                <td><?= $submission['sender_email']; ?></td>
                <td><?= $submission['message']; ?></td>
                <td><?= $submission['submission_date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="logout.php">Logout</a></p>