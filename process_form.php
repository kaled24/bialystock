<?php
// Database connection details
// IMPORTANT: Replace with your actual database credentials!
$servername = "localhost"; // Often 'localhost' for XAMPP
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty)
$dbname = "workshop_db"; // Replace with your database name
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
// Check if form data has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve and sanitize form data
// htmlspecialchars() helps prevent XSS attacks
$name = isset($_POST['user_name']) ?
htmlspecialchars(trim($_POST['user_name'])) : '';
$comment = isset($_POST['user_comment']) ?
htmlspecialchars(trim($_POST['user_comment'])) : '';
// Basic validation (ensure fields are not empty)
if (!empty($name) && !empty($comment)) {
// Prepare SQL statement to prevent SQL injection
// Using prepared statements is the recommended practice
$sql = "INSERT INTO guestbook_entries (user_name, user_comment)
VALUES (?, ?)";
if ($stmt = mysqli_prepare($conn, $sql)) {
// Bind variables to the prepared statement as parameters
// "ss" means both parameters are strings
mysqli_stmt_bind_param($stmt, "ss", $name, $comment);
// Attempt to execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    // Redirect back to the main page after successful submission
    header("Location: index.php?status=success"); // Add status for feedback
    exit(); // Important to prevent further script execution after redirect
    } else {
    echo "Error: Could not execute query: " .
    mysqli_error($conn);
    }
    // Close statement
    mysqli_stmt_close($stmt);
    } else {
    echo "Error: Could not prepare query: " . mysqli_error($conn);
    }
    } else {
    // Handle empty fields - redirect back with an error message
    header("Location: index.php?
    status=error&message=Please+fill+in+all+fields.");
    exit();
    }
    } else {
    // If accessed directly without POST data, redirect to form
    header("Location: index.php");
    exit();
    }
    // Close connection
    mysqli_close($conn);
    ?>