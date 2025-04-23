<?php
// Database Connection
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "farmer"; // Use the correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Validate and sanitize input
if (!isset($_POST['email']) || empty($_POST['email'])) {
    die("Please enter a valid email.");
}

$email = $conn->real_escape_string(trim($_POST['email']));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Insert data into database (avoid duplicates)
$sql = "INSERT INTO subscribers (email) VALUES ('$email')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    if ($conn->errno == 1062) {
        echo "This email is already subscribed.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
