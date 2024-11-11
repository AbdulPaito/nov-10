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

// Step 2: Fetch student ID from URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id == 0) {
    die("Invalid student ID.");
}

// Step 3: Execute query to fetch data for the specific student with JOIN
$query = "
   SELECT 
    u.*, 
    ppi.profile_image, imageUpload,
    pi.last_name, first_name,middle_name,nationality,sex, civil_status, employment_status, month_of_birth, day_of_birth, year_of_birth, age,
    bi.*, 
    ci.*, 
    di.*, 
    ei.*, 
    gi.*, 
    ni.*, 
    ri.*
FROM users u
LEFT JOIN personal_information pi ON u.user_id = pi.user_id
LEFT JOIN birth_information bi ON u.user_id = bi.user_id
LEFT JOIN contact_information ci ON u.user_id = ci.user_id
LEFT JOIN disability_information di ON u.user_id = di.user_id
LEFT JOIN education ei ON u.user_id = ei.user_id
LEFT JOIN guardian_information gi ON u.user_id = gi.user_id
LEFT JOIN ncae_information ni ON u.user_id = ni.user_id
LEFT JOIN registration_details ri ON u.user_id = ri.user_id
LEFT JOIN profile_images ppi ON u.user_id = ppi.user_id
WHERE u.user_id = ?;
";

// Prepare the statement
$stmt = mysqli_prepare($connection, $query);

// Check if the statement preparation was successful
if ($stmt === false) {
    die("Query preparation failed: " . mysqli_error($connection));
}

// Step 4: Bind the student ID to the prepared statement
mysqli_stmt_bind_param($stmt, 'i', $student_id);

// Step 5: Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die("Statement execution failed: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

// Check if the student exists
if (mysqli_num_rows($result) == 0) {
    die("Student not found.");
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
      }

      .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
      }

      th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
      }

      th {
        background-color: #f7f7f7;
        font-weight: bold;
        color: #333;
        width: 30%;
      }

      td {
        background-color: #fff;
        color: #555;
        width: 50%;
      }

      img {
        border-radius: 4px;
      }

      #id-picture img, .profile-image img {
        width: 150px;
        height: 100px;
      }

      .profile-image {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        width: auto;
      }

      @media (max-width: 600px) {
        table {
          display: block;
          overflow-x: auto;
          white-space: nowrap;
        }
        th, td {
          display: block;
          width: 100%;
          box-sizing: border-box;
        }
        th {
          text-align: right;
          background: #f7f7f7;
        }
        td {
          text-align: left;
          border-bottom: 1px solid #ddd;
        }
        td::before {
          content: attr(data-label);
          float: left;
          font-weight: bold;
          margin-right: 10px;
        }
      }
    </style>
</head>
<body>

<div class="container">
    <table>
        <tbody>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
            </tr>
            <tr>
                <th>I.D Picture</th>
                <td id="id-picture">
                    <img src="<?= htmlspecialchars($row['profile_image']) ?>" alt="ID Picture">
                </td>
            </tr>
            <tr>
                <th>ULI Number</th>
                <td><?php echo htmlspecialchars($row['uli_number']); ?></td>
            </tr>
            <tr>
                <th>Entry Date</th>
                <td><?php echo htmlspecialchars($row['entry_date']); ?></td>
            </tr>
            <tr>
                <th>Last Name, Extension Name (Jr., Sr.)</th>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
            </tr>
            <tr>
                <th>Middle Name</th>
                <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
            </tr>
            <tr>
                <th>Number, Street</th>
                <td><?php echo htmlspecialchars($row['address_number_street']); ?></td>
            </tr>
            <tr>
                <th>Barangay</th>
                <td><?php echo htmlspecialchars($row['address_barangay']); ?></td>
            </tr>
            <tr>
                <th>District</th>
                <td><?php echo htmlspecialchars($row['address_district']); ?></td>
            </tr>
            <tr>
                <th>City/Municipality</th>
                <td><?php echo htmlspecialchars($row['address_city_municipality']); ?></td>
            </tr>
            <tr>
                <th>Province</th>
                <td><?php echo htmlspecialchars($row['address_province']); ?></td>
            </tr>
            <tr>
                <th>Region</th>
                <td><?php echo htmlspecialchars($row['address_region']); ?></td>
            </tr>
            <tr>
                <th>Email Address/Facebook Account</th>
                <td><?php echo htmlspecialchars($row['email_facebook']); ?></td>
            </tr>
            <tr>
                <th>Contact No:</th>
                <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
            </tr>
            <tr>
                <th>Nationality</th>
                <td><?php echo htmlspecialchars($row['nationality']); ?></td>
            </tr>
            <tr>
                <th>Sex</th>
                <td><?php echo htmlspecialchars($row['sex']); ?></td>
            </tr>
            <tr>
                <th>Civil Status</th>
                <td><?php echo htmlspecialchars($row['civil_status']); ?></td>
            </tr>
            <tr>
                <th>Employment Status (before the training)</th>
                <td><?php echo htmlspecialchars($row['employment_status']); ?></td>
            </tr>
            <tr>
                <th>Month of Birth</th>
                <td><?php echo htmlspecialchars($row['month_of_birth']); ?></td>
            </tr>
            <tr>
                <th>Day of Birth</th>
                <td><?php echo htmlspecialchars($row['day_of_birth']); ?></td>
            </tr>
            <tr>
                <th>Year of Birth</th>
                <td><?php echo htmlspecialchars($row['year_of_birth']); ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo htmlspecialchars($row['age']); ?></td>
            </tr>
            <tr>
                <th>City/Municipality (Birthplace)</th>
                <td><?php echo htmlspecialchars($row['birthplace_city_municipality']); ?></td>
            </tr>
            <tr>
                <th>Province (Birthplace)</th>
                <td><?php echo htmlspecialchars($row['birthplace_province']); ?></td>
            </tr>
            <tr>
                <th>Region (Birthplace)</th>
                <td><?php echo htmlspecialchars($row['birthplace_region']); ?></td>
            </tr>
            <tr>
                <th>Educational Attainment</th>
                <td><?php echo htmlspecialchars($row['educational_attainment']); ?></td>
            </tr>
            <tr>
                <th>Parent/Guardian</th>
                <td><?php echo htmlspecialchars($row['parent_guardian_name']); ?></td>
            </tr>
            <tr>
                <th>Complete Permanent Mailing Address</th>
                <td><?php echo htmlspecialchars($row['parent_guardian_address']); ?></td>
            </tr>
            <tr>
                <th>Learner/Trainee/Student (Clients) Classification</th>
                <td><?php echo htmlspecialchars($row['classification']); ?></td>
            </tr>
            <tr>
                <th>Type of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
                <td><?php echo htmlspecialchars($row['disability']); ?></td>
            </tr>
            <tr>
                <th>Causes of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
                <td><?php echo htmlspecialchars($row['cause_of_disability']); ?></td>
            </tr>
            <tr>
                <th>Taken NCAE/YP4SC Before</th>
                <td><?php echo htmlspecialchars($row['taken_ncae']); ?></td>
            </tr>
            <tr>
                <th>Where</th>
                <td><?php echo htmlspecialchars($row['where_ncae']); ?></td>
            </tr>
            <tr>
                <th>When</th>
                <td><?php echo htmlspecialchars($row['when_ncae']); ?></td>
            </tr>
            <tr>
                <th>Name of Course/Qualification</th>
                <td><?php echo htmlspecialchars($row['qualification']); ?></td>
            </tr>
            <tr>
                <th>If Scholar, What Type of Scholarship Package (TWSP, PESFA, STEP, others)?</th>
                <td><?php echo htmlspecialchars($row['scholarship']); ?></td>
            </tr>
            <tr>
                <th>Privacy Disclaimer</th>
                <td><?php echo htmlspecialchars($row['privacy_disclaimer']); ?></td>
            </tr>
            <tr>
                <th>Applicant Signature Over Printed Name</th>
                <td><?= htmlspecialchars($row['applicant_signature']) ?></td>
            </tr>
            <tr>
                <th>Date ACCOMPLISHED</th>
                <td><?php echo htmlspecialchars($row['date_accomplished']); ?></td>
            </tr>
            <tr>
                <th>Registrar/School Administrator</th>
                <td><?php echo htmlspecialchars($row['registrar_signature']); ?></td>
            </tr>
            <tr>
                <th>Date Received</th>
                <td><?php echo htmlspecialchars($row['date_received']); ?></td>
            </tr>
            <tr>
                <th>Profile Picture</th>
                <td class="profile-image">
                    <img src="<?= htmlspecialchars($row['imageUpload']) ?>" alt="Profile Image">
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
