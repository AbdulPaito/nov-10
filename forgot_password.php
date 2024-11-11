<?php
session_start();
include 'database.php'; // Include your database connection file

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['email'])) {
        // Use trim() to remove any extra spaces and strtolower() for case insensitivity
        $username = strtolower(trim($_POST['username']));
        $email = strtolower(trim($_POST['email']));

        // Check in the admins table first
        $stmt = $conn->prepare("SELECT admin_id FROM admins WHERE LOWER(username_admin) = ? AND LOWER(email_admin) = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: admin_reset_password.php"); // Redirect to admin password reset page
            exit();
        }

        // If not found in admins, check in the users table
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE LOWER(username) = ? AND LOWER(email) = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: reset_password.php"); // Redirect to user/student password reset page
            exit();
        }

        // If no matches are found in both tables
        $error_message = "Invalid username or email.";
    } else {
        $error_message = "Username and email are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="log.css">
  <style>
    .error-message {
      color: red;
      font-weight: bold;
    }
    .inputBox {
      text-align: center;
      border-radius: 20px;
      margin-top: 10px;
    }
    .inputBox input {
      padding: 10px;
      width: 60%;
      border-radius: 20px;
    }
    .inputBox1 input {
      padding: 10px;
      width: 60%;
      text-align: center;
      border-radius: 20px;
    }
    .inputBox1 {
      text-align: center;
      border-radius: 20px;
      margin-top: -10px;
    }
  </style>
</head>
<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Forgot Password</h2>
        <?php if (!empty($error_message)): ?>
          <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form class="form" action="forgot_password.php" method="POST">
          <div class="inputBox">
            <input type="text" name="username"  placeholder="Username">
          </div>
          <div class="inputBox">
            <input type="email" name="email" placeholder="Email">
          </div>
          <div class="inputBox1">
            <input type="submit" value="Request Password Reset">
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
