<?php
// Step 1: Establish database connection
$host = 'localhost';  // Replace with your host
$user = ' ';   // Replace with your database username
$password = ' '; // Replace with your database password
$database = 'tesda'; // Replace with your database name

$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Handle search query with batch and date parsing
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$course = '';
$batch = '';
$startDate = '';
$endDate = '';

// Parse search query to extract course and batch
preg_match('/(.*?)\s*(batch\s+\d+)/i', $search, $matches);  // Extract course and batch
if ($matches) {
    $course = trim($matches[1]);  // Course name
    $batch = trim($matches[2]);   // Batch number
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
            CEIL(ROW_NUMBER() OVER (PARTITION BY e.qualification ORDER BY bi.entry_date) / 25) AS batch -- Example batch calculation
        FROM personal_information pi
        LEFT JOIN users u ON u.user_id = pi.user_id
        LEFT JOIN profile_images img ON pi.user_id = img.user_id
        LEFT JOIN birth_information bi ON pi.user_id = bi.user_id
        LEFT JOIN education e ON pi.user_id = e.user_id
        WHERE e.qualification LIKE '%$course%' 
";


// Add additional condition for searching by name
if (!empty($search)) {
    $query .= " OR CONCAT(first_name, ' ', last_name) LIKE '%$search%'";
}

// Add date filtering to the query if provided
if ($startDate && $endDate) {
    $query .= " AND entry_date BETWEEN '$startDate' AND '$endDate'";
}

$query .= ") AS numbered_users";

// If a batch number is specified, filter by batch; otherwise, show all batches
if ($batchNumber > 0) {
    $query .= " WHERE batch = $batchNumber";
}

$query .= " ORDER BY entry_date";  // Ordering by registration date for display

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
    <title>Reports</title>
    <style>
         body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }
        /* General section styling */
        #report-section {
            position: relative;
        padding: 15px;
        position: relative;
        width: auto;
        margin-top: -36px;
        margin-left: -35px;
        }

        /* Heading styling */
        #report-section h1 {
        text-align: center;
        background: #1182fa;;
        color: #fff;
        padding: 20px 0;
        margin: 0;
        }

        /* Paragraph styling */
        #report-section p {
            font-size: 1.2em;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table styling */
        .reports-table {
            width: 100%;
        border-collapse: collapse;
        margin: 0;
        }

        .reports-table th,
        .reports-table td {
            padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        }

        .reports-table th {
            background: #f9f9f9;
        }

        .reports-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .reports-table tr:hover {
            background-color: #ddd;
        }
        .print-button, .delete-button {
        display: inline-block;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        }

        .print-button {
            background: #007bff;
            color: #fff;
        }

        .print-button:hover {
            background: #45a049;
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
</head>
<body>

<section id="report-section">
    <h1>Reports</h1>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <form method="GET" action="dashboard.php">
        <input type="hidden" name="page" value="reports">
        <input type="text" name="search" placeholder="Search by name, course, or batch" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>
    <table class="reports-table">
        <thead>
        <tr>
            <th><i class="fas fa-id-badge"></i> ID</th>
            <th><i class="fas fa-user"></i> NAME</th>
            <th><i class="fas fa-calendar-alt"></i> Entry Date</th>
            <th><i class="fas fa-users"></i> BATCH</th>
            <th><i class="fas fa-info-circle"></i> STATUS</th>
            <th><i class="fas fa-book-open"></i> COURSE</th>
            <th><i class="fas fa-print"></i> PRINT</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['entry_date']); ?></td>
                <td><?php echo htmlspecialchars($row['batch']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                <td><a class="print-button" href="print1.php?id=<?php echo $row['user_id']; ?>"> <i class="fas fa-print"></i> Print</a></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</section>

</body>
</html>