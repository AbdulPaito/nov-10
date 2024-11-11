<?php
// update_status.php

$host = 'localhost';  // Replace with your host
$user = ' ';   // Replace with your database username
$password = ' '; // Replace with your database password
$database = 'tesda'; // Replace with your database name

// Establish database connection
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the POST data
$id = isset($_POST['id']) ? $_POST['id'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

// Validate inputs
if ($id === null || $status === null) {
    die("Invalid input");
}

if (!in_array($status, ['Enroll', 'Graduate', 'Drop', 'Pending'])) {
    die("Invalid status");
}

// Prepare and execute the update query
$query = "UPDATE users SET status = ? WHERE user_id = ?";
$stmt = mysqli_prepare($connection, $query);

if ($stmt === false) {
    die("Prepare failed: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($stmt, 'si', $status, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "Status updated successfully";
} else {
    echo "Error updating status: " . mysqli_error($connection);
}

mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
