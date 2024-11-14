<?php
$host = 'localhost';  // Replace with your host
$user = '';   // Replace with your database username
$password = ''; // Replace with your database password
$database = 'tesda'; // Replace with your database name

$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle search query
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// Modify query to include search functionality and join profile_images and birth_information tables
$query = "
    SELECT 
        pi.user_id, 
        pi.first_name, 
        img.profile_image AS image_path,  -- Corrected reference to profile_image in profile_images table
        bi.entry_date
    FROM personal_information pi
    LEFT JOIN profile_images img ON pi.user_id = img.user_id
    LEFT JOIN birth_information bi ON pi.user_id = bi.user_id
    WHERE pi.first_name LIKE '%$search%'
";



$result = mysqli_query($connection, $query);

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Table</title>
    <style>
        /* Sets the background color for the entire page */
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Page background color */
            margin: 0;
            padding: 0;
        }

        #registration-section {
            position: relative;
            padding: 10px;
            width: auto;
            margin-top: -30px;
            margin-left: -36px;
        } 
       
        /* Header styling within the registration section */
        #registration-section h1 {
        text-align: center;
        background: #1182fa;;
        color: #fff;
        padding: 20px 0;
        margin: 0;
           
        }

        .table-responsive {
            overflow-x: auto;
        }

        .registration-table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            top: -20px;
            background-color: #ccc;
        }

        .registration-table th, .registration-table td {
            padding: 5px; /* Reduced padding */
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .registration-table th {
            background: white;
            font-size: larger;
        }

        .registration-table td {
            font-size: large;
        }

        .registration-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .registration-table tr:hover {
            background: #f1f1f1;
        }
        /* Style for Info button */
.info {
    display: inline-block; /* Ensures the button behaves like a block element */
    padding: 10px 20px; /* Adds padding around the text */
    margin: 5px; /* Adds margin around the button */
    background-color: #007bff; /* Blue background color */
    color: white; /* White text color */
    text-decoration: none; /* Removes underline from the link */
    border-radius: 5px; /* Rounded corners */
    font-weight: bold; /* Makes the text bold */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover effect */
}

/* Hover effect for Info button */
.info:hover {
    background-color: #0056b3; /* Darker blue on hover */
    color: #e9ecef; /* Light color on hover */
}


        .registration-table img {
            width: 100px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
            max-height: 100px; /* Adjust the height as needed */
            display: block; /* Ensure it behaves like a block-level element */
            margin: 0 auto; /* Center image in the cell */
        }

        /* Style for cells containing images */
        .registration-table td img {
            border-radius: 4px;
        }


        form {
    margin-bottom: 20px;
    text-align: right;
    position: relative;
    top: 10px;
}

input[type="text"] {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 300px;
}

button {
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
<section id="registration-section">
    <div class="container">
        <h1>Trainee Information</h1>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <form method="GET" action="dashboard.php">
        <input type="hidden" name="page" value="registration">
            <input type="text" name="search" placeholder="Search by first name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
        <div class="table-responsive">
    <table class="registration-table">
        <thead>
            <tr>
                <th><i class="fas fa-id-badge"></i> ID</th>
                <th><i class="fas fa-image"></i> ID Picture</th>
                <th><i class="fas fa-user"></i> First Name</th>
                <th><i class="fas fa-user-check"></i> Entry Date</th>
                <th><i class="fas fa-info-circle"></i> Info</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Profile Image" style="height: 60px;"></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['entry_date']); ?></td>
                    <td><a class="info" href="info.php?id=<?php echo $row['user_id']; ?>">Info</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
