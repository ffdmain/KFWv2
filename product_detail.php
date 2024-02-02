<!DOCTYPE html>
<html>
<head>
    <title>Product Detail</title>
</head>
<body>
    <?php
    // Check if the 'product_id' parameter is present in the URL
    if (isset($_GET['product_id'])) {
        // Get the product ID from the URL
        $product_id = $_GET['product_id'];

        // Retrieve product details from the database based on the product ID
        require_once 'ProductManager.php'; // Include the ProductManager class
        $productManager = new ProductManager();
        $product = $productManager->getProductById($product_id);

        if ($product) {
            // Display product details
            echo "<h1>Product Details</h1>";
            echo "<p><strong>Product ID:</strong> " . $product['product_id'] . "</p>";
            echo "<p><strong>Product Name:</strong> " . $product['product_name'] . "</p>";
            echo "<p><strong>Description:</strong> " . $product['description'] . "</p>";
            echo "<p><strong>Price:</strong> $" . number_format($product['price'], 2) . "</p>";
            echo "<p><strong>Quantity in Stock:</strong> " . $product['stock_quantity'] . "</p>";
            echo "<img src='" . $product['image_path'] . "' alt='Product Image' width='300'>";
        } else {
            echo "<p>Product not found.</p>";
        }

        // Close the database connection
        $productManager->closeConnection();
    } else {
        echo "<p>Invalid product ID.</p>";
    }
    ?>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
