<!DOCTYPE html>
<html lang="en">
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Workshop Guestbook</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<h1>Welcome to Our Guestbook!</h1>
</header>
<main class="container">
<section class="form-section">
<h2>Leave a Comment</h2>
<?php
// Display feedback messages if redirected with status
if (isset($_GET['status'])) {
if ($_GET['status'] == 'success') {
echo '<p style="color: green;">Comment submitted
successfully!</p>';
} elseif ($_GET['status'] == 'error' &&
isset($_GET['message'])) {
echo '<p style="color: red;">' .
htmlspecialchars($_GET['message']) . '</p>';
}
}
?>
<form action="process_form.php" method="post">
<!-- Form elements as before -->
<div class="form-group">
<label for="name">Name:</label>
<input type="text" id="name" name="user_name"
required>
</div>
<div class="form-group">
<label for="comment">Comment:</label>
<textarea id="comment" name="user_comment" rows="4"
required></textarea>
</div>
<button type="submit">Submit Comment</button>
</form>
</section>
<section class="entries-section">
<h2>Entries</h2>
<?php
// Database connection details (reuse or include from a config file)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "workshop_db";
$conn = mysqli_connect($servername, $username, $password,
$dbname);
if (!$conn) {
echo "<p>Error connecting to database.</p>";
} else {
// SQL query to select all entries, ordered by submission date descending
$sql = "SELECT user_name, user_comment, submission_date
FROM guestbook_entries ORDER BY submission_date DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
// Output data of each row
while($row = mysqli_fetch_assoc($result)) {
echo "<div class='entry'>";
echo "<p><strong>" .
htmlspecialchars($row["user_name"]) . "</strong> (" . date("Y-m-d H:i",
strtotime($row["submission_date"])) . ")</p>";
echo "<p>" .
nl2br(htmlspecialchars($row["user_comment"])) . "</p>"; // nl2br converts newlines to <br>
echo "</div>";
}
} else {
echo "<p>No entries yet. Be the first to comment!</
p>";
}
mysqli_close($conn);
}
?>
</section>
</main>
<footer>
<p>&copy; 2025 Workshop Team</p>
</footer>
</body>
</html>