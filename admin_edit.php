<?php
session_start();
require_once('database.php'); // Ensure this includes your database connection

$new_password = "";
$confirm_password = "";
$message = "";

// Fetch admin ID if provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Initialize query variables
    $query = "UPDATE admins SET password_admin = ? WHERE admin_id = ?"; // Correct query for admin table
    $params = [];
    $types = "si"; // s for string (password), i for integer (admin_id)

    // Check if new password and confirm password match
    if (!empty($new_password)) {
        if ($new_password === $confirm_password) {
            $params[] = $new_password;
            $params[] = $id;

            // Prepare and execute the query
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                    $message = "Password updated successfully.";
                } else {
                    $message = "Error updating password: " . mysqli_error($conn);
                }
            } else {
                $message = "Prepare statement failed: " . mysqli_error($conn);
            }
        } else {
            $message = "Passwords do not match.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body, input, button {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        
        .form-container {
            width: 100%;
            max-width: 350px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9em;
        }
        
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px 35px 10px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        
        .form-group .eye-icon {
            position: absolute;
            right: 10px;
            top: 40px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2em;
            color: #aaa;
        }
        
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        
        .form-group button:hover {
            background-color: #0056b3;
        }

        .form-group a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }

        .form-group a:hover {
            text-decoration: underline;
        }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2>Change Password</h2>
        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="POST">
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password">
                <i class="fas fa-eye eye-icon" onclick="togglePassword('password')"></i>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
                <i class="fas fa-eye eye-icon" onclick="togglePassword('confirm_password')"></i>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Change Password</button>
                <a href="dashboard.php?page=admin">Go Back</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;
            if (field.type === "password") {
                field.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>
</html>
