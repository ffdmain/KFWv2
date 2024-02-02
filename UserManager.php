<?php
class UserManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($username, $password, $email) {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Insert the user with 'normal' as the default user_type directly into the SQL query
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, 'normal')");
        $stmt->bind_param("sss", $username, $hashedPassword, $email);
    
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            // Add error handling to display the SQL error message
            die("Registration failed: " . $stmt->error);
        }
    }
    
    
    

    public function loginUser($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set user type and user ID in session
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_type'] = $row['user_type']; // Set the user type

                return true; // Login successful
            }
        }

        return false; // Login failed
    }
    
}
?>