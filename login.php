<?php
session_start();
include 'database.php'; // Include your database connection file

$error_message = ''; // Initialize the error message variable

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // If connection fails, show error
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if username and password fields are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password']; // Use plain text password for comparison

        // Check admin credentials in the admins table
        $stmt = $conn->prepare("SELECT admin_id, password_admin FROM admins WHERE username_admin = ?");
        if ($stmt === false) {
            die("Prepare failed for admins table: " . $conn->error); // Output detailed error message for admins table
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Admin user check
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Direct comparison for plain text password
            if ($password === $admin['password_admin']) {
                $_SESSION['user_id'] = $admin['admin_id']; // Adjusted column name from 'id' to 'admin_id'
                $_SESSION['username'] = $username; // Set session username correctly
                $_SESSION['role'] = 'admin'; // Set session role as admin

                header("Location: dashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                $error_message = "Invalid password for admin."; // Set error message
            }
        } else {
            // No admin found, check credentials in the users table
            $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
            if ($stmt === false) {
                die("Prepare failed for users table: " . $conn->error); // Output detailed error message for users table
            }

            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if a user was found
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $user_id = $user['user_id']; // Get the user_id from the users table

                // Check if the user's password matches
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['user_id']; // Store user_id in session
                    $_SESSION['username'] = $username; // Set session username correctly
                    $_SESSION['role'] = 'user'; // Set session role as user

                    // Check if the user has completed their registration
                    $stmt = $conn->prepare("SELECT registration_complete FROM registration_details WHERE user_id = ?");
                    if ($stmt === false) {
                        die("Prepare failed for registration details: " . $conn->error); // Output detailed error message for registration details table
                    }

                    $stmt->bind_param("i", $user_id); // Bind user_id
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if registration details are found
                    if ($result->num_rows > 0) {
                        $user_details = $result->fetch_assoc();
                        
                        // If registration is complete
                        if ($user_details['registration_complete'] == 1) {
                          header("Location: info_edit.php?user_id=" . $_SESSION['user_id']); // Pass user_id in URL
                        } else {
                            header("Location: page1.php"); // Redirect to page1.php if registration is incomplete
                        }
                        exit();
                    } else {
                        $error_message = "No registration details found for user."; // Handle case where no registration details are found
                        echo $error_message; // Debugging message
                        header("Location: page1.php"); // Redirect to the registration form if no details exist
                        exit();
                    }

                } else {
                    $error_message = "Invalid password for user."; // Set error message for invalid password
                }
            } else {
                $error_message = "No user found with that username "; // Set error message if no user found
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
  <title>Login</title>

  <link rel="icon" href="TESDA icon.png" type="image/png">
  <link rel="stylesheet" href="log.css">
  <link rel="stylesheet" href="log.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .error-message {
      color: red;
      font-weight: bold;
    }

    .inputBox1 input{
      padding: 10px;
      width: 60%;
      text-align: center;
      position: relative;
      border-radius: 20px;
      
    }
    .inputBox1 {
      text-align: center;
      border-radius: 20px;
      margin-top: -15px;
    }


    .eye-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #aaa; /* Icon color */
      font-size: 20px; /* Adjust size */
    }

    .eye-icon.active {
      color: #000; /* Icon color when active */
    }



    .forgot-password {
      margin-top: -10px;
      text-align: right;
      padding: auto;
    }

    .forgot-password p {
      margin: 0;
    }

    .forgot-password a {
      color: white;
      text-decoration: none;
    }

    .forgot-password a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
          <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form class="form" action="login.php" method="POST">
          <div class="inputBox">
            <input type="text" name="username" placeholder="Username" required>
          </div>

          <div class="inputBox">
            <input type="password" id="password" placeholder="Password" name="password" required>
            <i class="fa fa-eye eye-icon" id="togglePassword" onclick="togglePassword()"></i>
          </div>
 
          <div class="forgot-password">
          <p><a href="forgot_password.php">Forgot Password?</a></p>
         </div>

          <div class="inputBox1">
            <input type="submit" value="Login">
          </div>


        </form>
        <div class="signup">
          <p>Don't have an account? <a href="signup.php" class="sign-up-link" onclick="openSignUpModal()">Sign up</a></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Sign Up Modal -->
  <div id="signupModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeSignUpModal()">&times;</span>
      <h2>Sign Up</h2>
      <form class="form" action="signup.php" method="POST">
        <div class="inputBox">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>
        <div class="inputBox">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <div class="inputBox">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <div class="inputBox">
          <input type="submit" value="Sign Up">
        </div>
      </form>
    </div>
  </div>

  <script>
    function openSignUpModal() {
      document.getElementById('signupModal').style.display = 'block';
    }

    function closeSignUpModal() {
      document.getElementById('signupModal').style.display = 'none';
    }
  </script>

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
