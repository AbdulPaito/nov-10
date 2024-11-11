<?php
require_once('database.php'); // Make sure this file includes your database connection

// Perform query
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);

// Check if query execution was successful
if (!$result) {
    die("Database query failed."); // Handle the error appropriately
}
?>

<section id="settings-section">
    <h1>Admin</h1>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <table class="settings-table">
        <thead>
        <tr>
          <th><i class="fas fa-id-badge"></i> ID</th>
            <th><i class="fas fa-user"></i> Username</th>
            <th><i class="fas fa-key"></i> Password</th>
            <th><i class="fas fa-envelope"></i> Email</th>
            <th><i class="fas fa-edit"></i> Edit</th>
            <th><i class="fas fa-trash-alt"></i> Delete</th>
        </tr>

        </thead>
        <tbody>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($row['username_admin']); ?></td>
                    <td>
                        <input type="password" value="<?php echo htmlspecialchars($row['password_admin']); ?>" id="password-<?php echo $row['admin_id']; ?>" class="password-field" readonly>
                        <i class="fas fa-eye" onclick="togglePassword(<?php echo $row['admin_id']; ?>)" style="cursor: pointer;"></i>
                    </td>
                    <td><?php echo htmlspecialchars($row['email_admin']); ?></td>
                    <td><a class="edit-button" href="admin_edit.php?id=<?php echo $row['admin_id']; ?>">Edit</a></td>
                    <td><a class="delete-button" href="admin_delete.php?id=<?php echo $row['admin_id']; ?>">Delete</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>

<script>
function togglePassword(id) {
    var passwordField = document.getElementById('password-' + id);
    var eyeIcon = passwordField.nextElementSibling;

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>

<?php
// More PHP code here if needed
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    #settings-section {   
        position: relative;
        padding: 15px;
        position: relative;
        width: auto;
        margin-top: -36px;
        margin-left: -35px;
    }

    #settings-section h1 {
        text-align: center;
        background: #1182fa;;
        color: #fff;
        padding: 20px 0;
        margin: 0;
    }

    .settings-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .settings-table th, .settings-table td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .settings-table th {
        background: #f4f4f9;
    }

    .settings-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .settings-table tr:hover {
        background: #f1f1f1;
    }

    .edit-button, .delete-button {
        display: inline-block;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }

    .edit-button {
        background: #007bff;
        color: #fff;
    }

    .edit-button:hover {
        background: #45a049;
    }

    .delete-button {
        background: #f44336;
        color: #fff;
    }

    .delete-button:hover {
        background: #e53935;
    }
    .password-field {
    border: none;
    background: transparent;
    font-size: 1em;
    width: auto;
    text-align: center;
    font-family: inherit;
    margin-right: 5px;
}

.password-field:focus {
    outline: none;
}

td i {
    color: black;
}

td i:hover {
    color: #0056b3;
}
</style>
