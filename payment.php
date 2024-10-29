<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update with your DB username
$password = "";     // Update with your DB password
$dbname = "store"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and trim whitespace
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$city = trim($_POST['city']);
$state = trim($_POST['state']);
$zip_code = trim($_POST['zip_code']);
$card_name = trim($_POST['card_name']);
$card_number = trim($_POST['card_number']);
$exp_month = trim($_POST['exp_month']);
$exp_year = trim($_POST['exp_year']);
$cvv = trim($_POST['cvv']);

// Check for empty fields
if (empty($full_name) || empty($email) || empty($address) || empty($city) || 
    empty($state) || empty($zip_code) || empty($card_name) || 
    empty($card_number) || empty($exp_month) || empty($exp_year) || 
    empty($cvv)) {
    
    // Display an error message
    echo "<p style='color: red;'>Please fill in all fields.</p>";
    exit(); // Stop further execution
}

// Insert data into payments table
$sql = "INSERT INTO payment (full_name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssis", $full_name, $email, $address, $city, $state, $zip_code, $card_name, $card_number, $exp_month, $exp_year, $cvv);

if ($stmt->execute()) {
    header("Location:./login.html"); // Redirect to the final page
    exit(); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>