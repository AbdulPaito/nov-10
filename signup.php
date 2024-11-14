<?php
session_start();
include 'database.php'; // Include your database connection file

$error_message = ''; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $pin = $_POST['pin']; // Retrieve the PIN

    // Basic validation
    if (empty($username) || empty($password) || empty($email) || empty($pin)) {
        $error_message = "All fields are required.";
    } elseif (!ctype_digit($pin) || strlen($pin) !== 6) {
        $error_message = "PIN must be exactly 6 digits.";
    } else {
        // Check if username is already taken
        $check_user_sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_user_sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error); // Output detailed error message
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows > 0) {
            $error_message = "Username already exists.";
        } else {
            // Check if email is already taken
            $check_email_sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($check_email_sql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error); // Output detailed error message
            }
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $email_result = $stmt->get_result();

            if ($email_result->num_rows > 0) {
                $error_message = "Email address already in use.";
            } else {
                // Insert new user into users table with raw password
                $insert_sql = "INSERT INTO users (username, password, email, pin, status) VALUES (?, ?, ?, ?, 'Pending')";
                $stmt = $conn->prepare($insert_sql);
                if ($stmt === false) {
                    die("Prepare failed: " . $conn->error); // Output detailed error message
                }
                $stmt->bind_param("ssss", $username, $password, $email, $pin);

                if ($stmt->execute()) {
                    // Automatically log the user in after successful registration
                    $_SESSION['user_id'] = $conn->insert_id; // Store the new user's ID in session
                    
                    // Redirect to page1.php after successful registration
                    header('Location: page1.php'); // Redirect to page1.php
                    exit;
                } else {
                    $error_message = "Error registering user: " . $stmt->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="log.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .error-container {
      color: red;
      font-weight: bold;
    }
    .inputBox2 input, .inputBox input {
      padding: 10px;
      width: 60%;
      text-align: center;
      border-radius: 20px;
      position: relative;
      top: -10px;
    }
    .inputBox2 {
      text-align: center;
      border-radius: 20px;
      margin-top: -10px;
    }
    .eye-icon {
      position: absolute;
      right: 10px;
      top: 30%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #aaa;
      font-size: 20px;
      
    }
    .eye-icon.active {
      color: #000;
    }
  </style>
</head>
<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Sign Up</h2>
        <?php if (!empty($error_message)): ?>
          <div class="error-container"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form class="form" action="signup.php" method="POST">
          <div class="inputBox">
            <input type="text" name="username" placeholder="Username" required>
          </div>

          <div class="inputBox">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <i class="fa fa-eye eye-icon" id="togglePassword" onclick="togglePassword()"></i>
          </div>

          <div class="inputBox">
            <input type="email" name="email" placeholder="Email" required>
          </div>

          <div class="inputBox">
            <input type="text" name="pin" placeholder="6-Digit PIN" pattern="\d{6}" title="PIN must be exactly 6 digits" required>
          </div>

          <div class="inputBox2">
            <input type="submit" value="Sign Up">
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
  function togglePassword() {
      var passwordField = document.getElementById('password');
      var eyeIcon = document.getElementById('togglePassword');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.add('active');
      } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('active');
      }
    }
  </script>
</body>
</html>
