<?php
// Step 1: Establish database connection
$host = 'localhost';  // Replace with your host
$user = '';   // Replace with your database username
$password = ''; // Replace with your database password
$database = 'tesda'; // Replace with your database name

$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Handle search query with batch, date, and year parsing
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$course = '';
$batch = '';
$year = '';
$startDate = '';
$endDate = '';

// Parse search query to extract course, batch, and optional year
preg_match('/(.*?)\s*(batch\s+\d+)\s*(\d{4})?/i', $search, $matches);
if ($matches) {
    $course = trim($matches[1]);               // Course name
    $batch = trim($matches[2]);                 // Batch number
    $year = isset($matches[3]) ? $matches[3] : '';  // Year (optional)
} else {
    $course = $search;  // If no batch is specified, treat the whole search term as course name
}

// Convert batch number to an integer (if a batch is provided)
$batchNumber = $batch ? (int) filter_var($batch, FILTER_SANITIZE_NUMBER_INT) : 0;

// Handle date search, if provided
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = mysqli_real_escape_string($connection, $_GET['start_date']);
    $endDate = mysqli_real_escape_string($connection, $_GET['end_date']);
}

// Step 3: Build the query based on the parsed search input
$query = "
    SELECT * FROM (
        SELECT 
            pi.user_id, 
            pi.first_name, 
            pi.last_name, 
            u.status,
            e.qualification,  
            img.profile_image AS image_path,  
            bi.entry_date,
            CEIL(ROW_NUMBER() OVER (PARTITION BY e.qualification, YEAR(bi.entry_date) ORDER BY bi.entry_date) / 25) AS batch,
            YEAR(bi.entry_date) AS entry_year
        FROM personal_information pi
        LEFT JOIN users u ON u.user_id = pi.user_id
        LEFT JOIN profile_images img ON pi.user_id = img.user_id
        LEFT JOIN birth_information bi ON pi.user_id = bi.user_id
        LEFT JOIN education e ON pi.user_id = e.user_id
        WHERE e.qualification LIKE '%$course%' 
";

// Add additional condition for searching by name
if (!empty($search)) {
    $query .= " OR CONCAT(pi.first_name, ' ', pi.last_name) LIKE '%$search%'";
}

// Add date filtering to the query if provided
if ($startDate && $endDate) {
    $query .= " AND bi.entry_date BETWEEN '$startDate' AND '$endDate'";
}

$query .= ") AS numbered_users";

// Step 4: Filter by batch number and year if specified
if ($batchNumber > 0) {
    $query .= " WHERE batch = $batchNumber";
}
if (!empty($year)) {
    $query .= (strpos($query, 'WHERE') !== false ? " AND " : " WHERE ") . "entry_year = $year";
}

$query .= " ORDER BY entry_date";  // Order by entry date for display

// Execute the query
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
    <title>Profile</title>
    <style>
        /* General section styling */
        #profile-section {
            position: relative;
            padding: 15px;
            width: auto;
            margin-top: -36px;
            margin-left: -35px;
        }

        /* Heading styling */
        #profile-section h1 {
            text-align: center;
            background: #1182fa;
            color: #fff;
            padding: 20px 0;
            margin: 0;
        }

        /* Table styling */
        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .profile-table th, .profile-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .profile-table th {
            background: #f9f9f9;
        }

        .profile-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .profile-table tr:hover {
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

        /* Search Form Styling */
        form {
            display: flex;
            justify-content: right;
            margin-bottom: 20px;
            position: relative;
            top: 10px;
        }

        form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            margin-right: 10px;
            box-sizing: border-box;
        }

        form button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #0056b3;
        }

        form input[type="text"]::placeholder {
            color: #aaa;
            font-style: italic;
        }

        form input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<section id="profile-section">
    <h1>Profile Information</h1>

    <!-- Search Form -->
    <form method="GET" action="dashboard.php">
        <input type="hidden" name="page" value="profile">
        <input type="text" name="search" placeholder="Search by name, course, or batch" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Profile Table -->
    <table class="profile-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>COURSE</th>
                <th>Entry Date</th>
                <th>STATUS</th>
                <th>BATCH</th> 
                <th>EDIT</th>
                <th>DELETE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display results from the query
            $counter = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                    <td><?php echo htmlspecialchars($row['entry_date']); ?></td>
                    <td>
                        <select class="status-select" data-id="<?php echo $row['user_id']; ?>">
                            <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Enroll" <?php echo ($row['status'] == 'Enroll') ? 'selected' : ''; ?>>Enroll</option>
                            <option value="Graduate" <?php echo ($row['status'] == 'Graduate') ? 'selected' : ''; ?>>Graduate</option>
                            <option value="Drop" <?php echo ($row['status'] == 'Drop') ? 'selected' : ''; ?>>Drop</option>
                        </select>
                    </td>
                    <td><?php echo htmlspecialchars($row['batch']); ?></td>
                    <td><a class="edit-button" href="edit-profile.php?id=<?php echo $row['user_id']; ?>">Edit</a></td>
                    <td><a class="delete-button" href="delete-profile.php?id=<?php echo $row['user_id']; ?>">Delete</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>

</body>
</html>

<?php
// Close the connection
mysqli_close($connection);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-select').change(function() {
            var status = $(this).val();
            var id = $(this).data('id');
            
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { id: id, status: status },
                success: function(response) {
                    console.log('Status updated successfully:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating status:', error);
                }
            });
        });
    });
</script>