<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Change this if your username is different
$password = ""; // Change this if you have set a password for the user
$dbname = "store"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];

    // Validate passwords match
    if ($pass !== $confirmPass) {
        die("Passwords do not match.");
    }

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page or another page if needed
        // header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
