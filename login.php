<?php
// Start session
session_start();

// Database configuration
$host = "localhost";          // Database host
$dbname = "store";            // Database name
$username = "root";           // Database username (default for XAMPP)
$password = "";                // Database password (default for XAMPP)

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $user, $user);
    
    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Check if a user was found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the password
            if ($pass === $row['password']) { // Using plain text comparison
                // Set session variables for successful login
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Redirect to a welcome page or dashboard
                header("Location: ./index.html");
                exit();
            } else {
                // Invalid password
                echo "Invalid password.";
            }
        } else {
            // No matching user found
            echo "User not found.";
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
}

// Close the connection
$conn->close();
?>
