<?php
// Step 1: Establish connection
$host = 'localhost'; // Define your host
$user = 'root'; 
$password = ''; 
$database = 'tesda';

$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Get the user_id from the URL or session (ensure it's safe)
$user_id = intval($_GET['id']); // Use intval to ensure it's an integer

// Step 3: Prepare the query to fetch user data
$query = "
    SELECT 
        u.*, 
        ppi.profile_image, imageUpload,
        pi.last_name, first_name, middle_name, nationality, sex, civil_status, employment_status, month_of_birth, day_of_birth, year_of_birth, age,
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

// Step 4: Prepare and bind parameters to the query (for secure execution)
if ($stmt = mysqli_prepare($connection, $query)) {
    // Bind the user_id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, 'i', $user_id);

    // Step 5: Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Step 6: Get the result of the query
        $result = mysqli_stmt_get_result($stmt);

        // Step 7: Fetch the result as an associative array
        if ($user = mysqli_fetch_assoc($result)) {
            // Successfully fetched user data
            // Now you can use $user to display the user's information
        } else {
            echo "No user found.";
        }
    } else {
        die("Query execution failed: " . mysqli_error($connection));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    die("Failed to prepare the query.");
}

// Step 8: Handle the update form submission (if any)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated data from the form, sanitize and validate
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $uli_number = mysqli_real_escape_string($connection, $_POST['uli_number']);
    $entry_date = mysqli_real_escape_string($connection, $_POST['entry_date']);
    $middle_name = mysqli_real_escape_string($connection, $_POST['middle_name']);
    $nationality = mysqli_real_escape_string($connection, $_POST['nationality']);
    $sex = mysqli_real_escape_string($connection, $_POST['sex']);
    $civil_status = mysqli_real_escape_string($connection, $_POST['civil_status']);
    $employment_status = mysqli_real_escape_string($connection, $_POST['employment_status']);
    $month_of_birth = mysqli_real_escape_string($connection, $_POST['month_of_birth']);
    $day_of_birth = mysqli_real_escape_string($connection, $_POST['day_of_birth']);
    $year_of_birth = mysqli_real_escape_string($connection, $_POST['year_of_birth']);
    $age = mysqli_real_escape_string($connection, $_POST['age']);
    $birthplace_city_municipality = mysqli_real_escape_string($connection, $_POST['birthplace_city_municipality']);
    $birthplace_province = mysqli_real_escape_string($connection, $_POST['birthplace_province']);
    $birthplace_region = mysqli_real_escape_string($connection, $_POST['birthplace_region']);
    $educational_attainment = mysqli_real_escape_string($connection, $_POST['educational_attainment']);
    $parent_guardian_name = mysqli_real_escape_string($connection, $_POST['parent_guardian_name']);
    $parent_guardian_address = mysqli_real_escape_string($connection, $_POST['parent_guardian_address']);
    $classification = mysqli_real_escape_string($connection, $_POST['classification']);
    $disability = mysqli_real_escape_string($connection, $_POST['disability']);
    $cause_of_disability = mysqli_real_escape_string($connection, $_POST['cause_of_disability']);
    $taken_ncae = mysqli_real_escape_string($connection, $_POST['taken_ncae']);
    $where_ncae = mysqli_real_escape_string($connection, $_POST['where_ncae']);
    $when_ncae = mysqli_real_escape_string($connection, $_POST['when_ncae']);
    $qualification = mysqli_real_escape_string($connection, $_POST['qualification']);
    $scholarship = mysqli_real_escape_string($connection, $_POST['scholarship']);
    $privacy_disclaimer = mysqli_real_escape_string($connection, $_POST['privacy_disclaimer']);
    $applicant_signature = mysqli_real_escape_string($connection, $_POST['applicant_signature']);
    $date_accomplished = mysqli_real_escape_string($connection, $_POST['date_accomplished']);
    $registrar_signature = mysqli_real_escape_string($connection, $_POST['registrar_signature']);
    // Handle profile image upload
    $imageUpload = $_FILES['profile_image']['name'];
    if ($imageUpload) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    // Example of SQL Query to update multiple tables
    $update_query = "
    UPDATE personal_information pi
    SET 
        pi.first_name = ?, 
        pi.last_name = ?, 
        pi.middle_name = ?, 
        pi.nationality = ?, 
        pi.sex = ?, 
        pi.civil_status = ?, 
        pi.employment_status = ?, 
        pi.month_of_birth = ?, 
        pi.day_of_birth = ?, 
        pi.year_of_birth = ?, 
        pi.age = ?, 
        pi.birthplace_city_municipality = ?, 
        pi.birthplace_province = ?, 
        pi.birthplace_region = ?
    WHERE pi.user_id = ?;

    UPDATE contact_information ci
    SET 
        ci.address_number_street = ?, 
        ci.address_barangay = ?, 
        ci.address_district = ?, 
        ci.address_city_municipality = ?, 
        ci.address_province = ?, 
        ci.address_region = ?, 
        ci.contact_no = ?, 
        ci.email_facebook = ?
    WHERE ci.user_id = ?;

    UPDATE profile_images ppi
    SET 
        ppi.imageUpload = ?, 
        ppi.profile_image = ?
    WHERE ppi.user_id = ?;

    UPDATE education ei
    SET 
        ei.educational_attainment = ?, 
        ei.classification = ?, 
        ei.qualification = ?, 
        ei.scholarship = ?
    WHERE ei.user_id = ?;

    UPDATE disability_information di
    SET 
        di.disability = ?, 
        di.cause_of_disability = ?
    WHERE di.user_id = ?;

    UPDATE ncae_information ni
    SET 
        ni.taken_ncae = ?, 
        ni.where_ncae = ?, 
        ni.when_ncae = ?
    WHERE ni.user_id = ?;

    UPDATE registration_details ri
    SET 
        ri.privacy_disclaimer = ?, 
        ri.applicant_signature = ?, 
        ri.registrar_signature = ?, 
        ri.date_accomplished = ?, 
        ri.date_received = ?, 
        ri.registration_complete = ?
    WHERE ri.user_id = ?;

    UPDATE guardian_information gi
    SET 
        gi.parent_guardian_name = ?, 
        gi.parent_guardian_address = ?
    WHERE gi.user_id = ?;

    UPDATE birth_information bi
    SET 
        bi.uli_number = ?, 
        bi.entry_date = ?, 
        bi.birthplace_city_municipality = ?, 
        bi.birthplace_province = ?, 
        bi.birthplace_region = ?
    WHERE bi.user_id = ?;
    ";

    // Prepare and bind parameters for each table update
    if ($stmt = mysqli_prepare($connection, $update_query)) {
        // Bind parameters here (ensure you have all necessary variables from your form)
        mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss',
            // Personal Information
            $first_name, $last_name, $middle_name, $nationality, $sex, $civil_status, $employment_status, $month_of_birth, $day_of_birth, $year_of_birth, $age,
            $birthplace_city_municipality, $birthplace_province, $birthplace_region, $user_id,

            // Contact Information
            $address_number_street, $address_barangay, $address_district, $address_city_municipality, $address_province, $address_region, $contact_no, $email_facebook, $user_id,

            // Profile Image
            $imageUpload, $profile_image, $user_id,

            // Education
            $educational_attainment, $classification, $qualification, $scholarship, $user_id,

            // Disability Information
            $disability, $cause_of_disability, $user_id,

            // NCAE Information
            $taken_ncae, $where_ncae, $when_ncae, $user_id,

            // Registration Details
            $privacy_disclaimer, $applicant_signature, $registrar_signature, $date_accomplished, $date_received, $registration_complete, $user_id,

            // Guardian Information
            $parent_guardian_name, $parent_guardian_address, $user_id,

            // Birth Information
            $uli_number, $entry_date, $birthplace_city_municipality, $birthplace_province, $birthplace_region, $user_id
        );

        // Step 6: Execute the update query
        if (mysqli_stmt_execute($stmt)) {
            echo "Data updated successfully.";
        } else {
            echo "Error updating data: " . mysqli_error($connection);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

// Close the connection
mysqli_close($connection);
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update Form</title>
    
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    margin: 0;
}
h2 {
    text-align: center;
            background: #1182fa;
            color: #fff;
            padding: 10px ;
            margin-top: -8px;
}


.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 70%;
    max-width: 900px;

}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.image-container {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}

.image-container img {
    max-width: 100px;
    height: auto;
    border-radius: 50%;
}

input[type="submit"] {
    background-color: #007bff;   /* Default blue color */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease; /* Smooth transition for color change */
}

input[type="submit"]:hover {
    background-color: #0056b3;   /* Darker blue on hover */
}

input[type="submit"]:active {
    background-color: #003366;   /* Even darker blue when clicked */
}




</style>
</head>
<body>
<div class="form-container">
    <h2>Update Profile Information</h2>

    <label for="profile_image">Profile Image:</label>
    <div class="image-container">
        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image">
    </div>
    <input type="file" name="profile_image" accept="image/*">
    <br><br>

    <div class="form-row">
        <div class="form-group">
            <label for="uli_number">ULI Number:</label>
            <input type="text" name="uli_number" value="<?php echo htmlspecialchars($user['uli_number']); ?>">
        </div>
        <div class="form-group">
            <label for="entry_date">Entry Date:</label>
            <input type="date" name="entry_date" value="<?php echo htmlspecialchars($user['entry_date']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?php echo htmlspecialchars($user['middle_name']); ?>">
        </div>
        <div class="form-group">
            <label for="address_number_street">Address (Number/Street):</label>
            <input type="text" name="address_number_street" value="<?php echo htmlspecialchars($user['address_number_street']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="address_barangay">Address (Barangay):</label>
            <input type="text" name="address_barangay" value="<?php echo htmlspecialchars($user['address_barangay']); ?>">
        </div>
        <div class="form-group">
            <label for="address_district">Address (District):</label>
            <input type="text" name="address_district" value="<?php echo htmlspecialchars($user['address_district']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="address_city_municipality">Address (City/Municipality):</label>
            <input type="text" name="address_city_municipality" value="<?php echo htmlspecialchars($user['address_city_municipality']); ?>">
        </div>
        <div class="form-group">
            <label for="address_province">Address (Province):</label>
            <input type="text" name="address_province" value="<?php echo htmlspecialchars($user['address_province']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="address_region">Address (Region):</label>
            <input type="text" name="address_region" value="<?php echo htmlspecialchars($user['address_region']); ?>">
        </div>
        <div class="form-group">
            <label for="email_facebook">Email/Facebook:</label>
            <input type="text" name="email_facebook" value="<?php echo htmlspecialchars($user['email_facebook']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="contact_no">Contact Number:</label>
            <input type="text" name="contact_no" value="<?php echo htmlspecialchars($user['contact_no']); ?>">
        </div>
        <div class="form-group">
            <label for="nationality">Nationality:</label>
            <input type="text" name="nationality" value="<?php echo htmlspecialchars($user['nationality']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="sex">Sex:</label>
            <input type="text" name="sex" value="<?php echo htmlspecialchars($user['sex']); ?>">
        </div>
        <div class="form-group">
            <label for="civil_status">Civil Status:</label>
            <input type="text" name="civil_status" value="<?php echo htmlspecialchars($user['civil_status']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="employment_status">Employment Status:</label>
            <input type="text" name="employment_status" value="<?php echo htmlspecialchars($user['employment_status']); ?>">
        </div>
        <div class="form-group">
            <label for="month_of_birth">Month of Birth:</label>
            <input type="text" name="month_of_birth" value="<?php echo htmlspecialchars($user['month_of_birth']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="day_of_birth">Day of Birth:</label>
            <input type="text" name="day_of_birth" value="<?php echo htmlspecialchars($user['day_of_birth']); ?>">
        </div>
        <div class="form-group">
            <label for="year_of_birth">Year of Birth:</label>
            <input type="text" name="year_of_birth" value="<?php echo htmlspecialchars($user['year_of_birth']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="text" name="age" value="<?php echo htmlspecialchars($user['age']); ?>">
        </div>
        <div class="form-group">
            <label for="birthplace_city_municipality">Birthplace (City/Municipality):</label>
            <input type="text" name="birthplace_city_municipality" value="<?php echo htmlspecialchars($user['birthplace_city_municipality']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="birthplace_province">Birthplace (Province):</label>
            <input type="text" name="birthplace_province" value="<?php echo htmlspecialchars($user['birthplace_province']); ?>">
        </div>
        <div class="form-group">
            <label for="birthplace_region">Birthplace (Region):</label>
            <input type="text" name="birthplace_region" value="<?php echo htmlspecialchars($user['birthplace_region']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="educational_attainment">Educational Attainment:</label>
            <input type="text" name="educational_attainment" value="<?php echo htmlspecialchars($user['educational_attainment']); ?>">
        </div>
        <div class="form-group">
            <label for="parent_guardian_name">Parent/Guardian Name:</label>
            <input type="text" name="parent_guardian_name" value="<?php echo htmlspecialchars($user['parent_guardian_name']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="parent_guardian_address">Parent/Guardian Address:</label>
            <input type="text" name="parent_guardian_address" value="<?php echo htmlspecialchars($user['parent_guardian_address']); ?>">
        </div>
        <div class="form-group">
            <label for="classification">Classification:</label>
            <input type="text" name="classification" value="<?php echo htmlspecialchars($user['classification']); ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="disability">Disability:</label>
            <input type="text" name="disability" value="<?php echo htmlspecialchars($user['disability']); ?>">
        </div>
        <div class="form-group">
            <label for="cause_of_disability">Cause of Disability:</label>
            <input type="text" name="cause_of_disability" value="<?php echo htmlspecialchars($user['cause_of_disability']); ?>">
        </div>
    </div>

    <div class="form-row">
    <div class="form-group">
            <label for="scholarship">Scholarship TWSP, PESFA, STEP, others?</label>
            <input type="text" name="scholarship" value="<?php echo htmlspecialchars($user['scholarship']); ?>">
        </div>
    <div class="form-group">
            <label for="privacy_disclaimer">Privacy Disclaimer</label>
            <input type="text" name="privacy_disclaimer" value="<?php echo htmlspecialchars($user['privacy_disclaimer']); ?>">
        </div>
    </div>

    <div class="form-row">
    <div class="form-group">
            <label for="applicant_signature">Applicant Signature Over Printed Name</label>
            <input type="text" name="applicant_signature" value="<?php echo htmlspecialchars($user['applicant_signature']); ?>">
        </div>
    <div class="form-group">
            <label for="date_accomplished">Date ACCOMPLISHED</label>
            <input type="text" name="date_accomplished" value="<?php echo htmlspecialchars($user['date_accomplished']); ?>">
        </div>
    </div>

    <label for="imageUpload">Picture:</label>
    <div class="image-container">
        <img src="<?php echo htmlspecialchars($user['imageUpload']); ?>" alt="Picture">
    </div>
    <input type="file" name="imageUpload" accept="image/*">
    <br>

    <input type="submit" value="Update Information">
</div>
</body>
</html>
