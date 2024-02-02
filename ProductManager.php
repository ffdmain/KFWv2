<?php
require_once 'database.php'; // Include the database connection script

class ProductManager {
    private $db;

    public function __construct() {
        global $db; // Use the database connection from database.php
        $this->db = $db;
    }

    public function createProduct($product_name, $description, $price, $stock_quantity, $image_path) {
        // Prepare the SQL statement
        $createProductQuery = "INSERT INTO products (product_name, description, price, stock_quantity, image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($createProductQuery);

        if (!$stmt) {
            return "Query preparation error: " . $this->db->error;
        }

        // Bind parameters and execute
        $stmt->bind_param("ssdss", $product_name, $description, $price, $stock_quantity, $image_path);
        $result = $stmt->execute();

        // Close the prepared statement
        $stmt->close();

        if ($result) {
            return true; // Product creation successful
        } else {
            return "Product creation failed: " . $this->db->error;
        }
    }

    public function getProductById($product_id) {
        $getProductQuery = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($getProductQuery);

        if (!$stmt) {
            return false; // Query preparation failed
        }

        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        // Close the prepared statement
        $stmt->close();

        return $product; // Return the product details or false if not found
    }

    public function updateProduct($product_id, $updated_product_name, $updated_product_description, $updated_price, $updated_quantity) {
        $updateProductQuery = "UPDATE products SET product_name = ?, product_description = ?, price = ?, quantity = ? WHERE product_id = ?";
        $stmt = $this->db->prepare($updateProductQuery);
        $stmt->bind_param("ssdii", $updated_product_name, $updated_product_description, $updated_price, $updated_quantity, $product_id);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Product update successful
        } else {
            $stmt->close();
            return false; // Product update failed
        }
    }

    public function deleteProduct($product_id) {
        $deleteProductQuery = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($deleteProductQuery);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Product deletion successful
        } else {
            $stmt->close();
            return false; // Product deletion failed
        }
    }

    public function getAllProducts() {
        $productQuery = "SELECT * FROM products";
        $result = $this->db->query($productQuery);

        if (!$result) {
            die("Product query failed: " . $this->db->error);
        }

        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function closeConnection() {
        $this->db->close();
    }
}
?>