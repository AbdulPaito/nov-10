<?php
// Database connection
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "tesda"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Ensure session is started

// Collect session data from previous pages
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // Removed real_escape_string()

// Ensure user_id is set before proceeding
if (empty($user_id)) {
    die("User not logged in. Access denied.");
}

// Handle file uploads
$upload_dir = 'Upload-image/';
$profile_image = '';
$imageUpload = '';

// Handle profile image upload
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $profile_image = $upload_dir . basename($_FILES['profile_image']['name']);
    if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image)) {
        echo "Error uploading profile image.";
        exit;
    }
}

// Handle additional image upload
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
    $imageUpload = $upload_dir . basename($_FILES['imageUpload']['name']);
    if (!move_uploaded_file($_FILES['imageUpload']['tmp_name'], $imageUpload)) {
        echo "Error uploading additional image.";
        exit;
    }
}

// Collect session data (no need for real_escape_string() for arrays)
$uli_number = isset($_SESSION['uli_number']) ? $_SESSION['uli_number'] : '';
$entry_date = isset($_SESSION['entry_date']) ? $_SESSION['entry_date'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$middle_name = isset($_SESSION['middle_name']) ? $_SESSION['middle_name'] : '';
$address_number_street = isset($_SESSION['address_number_street']) ? $_SESSION['address_number_street'] : '';
$address_barangay = isset($_SESSION['address_barangay']) ? $_SESSION['address_barangay'] : '';
$address_district = isset($_SESSION['address_district']) ? $_SESSION['address_district'] : '';
$address_city_municipality = isset($_SESSION['address_city_municipality']) ? $_SESSION['address_city_municipality'] : '';
$address_province = isset($_SESSION['address_province']) ? $_SESSION['address_province'] : '';
$address_region = isset($_SESSION['address_region']) ? $_SESSION['address_region'] : '';
$email_facebook = isset($_SESSION['email_facebook']) ? $_SESSION['email_facebook'] : '';
$contact_no = isset($_SESSION['contact_no']) ? $_SESSION['contact_no'] : '';
$nationality = isset($_SESSION['nationality']) ? $_SESSION['nationality'] : '';
$sex = isset($_SESSION['sex']) ? $_SESSION['sex'] : '';
$civil_status = isset($_SESSION['civil_status']) ? $_SESSION['civil_status'] : '';
$employment_status = isset($_SESSION['employment_status']) ? $_SESSION['employment_status'] : '';
$month_of_birth = isset($_SESSION['month_of_birth']) ? $_SESSION['month_of_birth'] : '';
$day_of_birth = isset($_SESSION['day_of_birth']) ? $_SESSION['day_of_birth'] : '';
$year_of_birth = isset($_SESSION['year_of_birth']) ? $_SESSION['year_of_birth'] : '';
$age = isset($_SESSION['age']) ? $_SESSION['age'] : '';
$birthplace_city_municipality = isset($_SESSION['birthplace_city_municipality']) ? $_SESSION['birthplace_city_municipality'] : '';
$birthplace_province = isset($_SESSION['birthplace_province']) ? $_SESSION['birthplace_province'] : '';
$birthplace_region = isset($_SESSION['birthplace_region']) ? $_SESSION['birthplace_region'] : '';
$educational_attainment = isset($_SESSION['educational_attainment']) ? $_SESSION['educational_attainment'] : '';
$parent_guardian_name = isset($_SESSION['parent_guardian_name']) ? $_SESSION['parent_guardian_name'] : '';
$parent_guardian_address = isset($_SESSION['parent_guardian_address']) ? $_SESSION['parent_guardian_address'] : '';
$classification = isset($_SESSION['classification']) ? $_SESSION['classification'] : '';
$disability = isset($_SESSION['disability']) ? $_SESSION['disability'] : '';
$cause_of_disability = isset($_SESSION['cause_of_disability']) ? $_SESSION['cause_of_disability'] : '';
$taken_ncae = isset($_SESSION['taken_ncae']) ? $_SESSION['taken_ncae'] : '';
$where = isset($_SESSION['where']) ? $_SESSION['where'] : '';
$when = isset($_SESSION['when']) ? $_SESSION['when'] : '';
$qualification = isset($_SESSION['qualification']) ? $_SESSION['qualification'] : '';
$scholarship = isset($_SESSION['scholarship']) ? $_SESSION['scholarship'] : '';
$privacy_disclaimer = isset($_SESSION['privacy_disclaimer']) ? $_SESSION['privacy_disclaimer'] : '';
$applicant_signature = isset($_POST['applicant_signature']) ? $_POST['applicant_signature'] : '';
$date_accomplished = isset($_POST['date_accomplished']) ? $_POST['date_accomplished'] : '';
$registrar_signature = isset($_POST['registrar_signature']) ? $_POST['registrar_signature'] : '';
$date_received = isset($_POST['date_received']) ? $_POST['date_received'] : '';


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  
// Insert data into personal_information table
$sql1 = "INSERT INTO personal_information (user_id, first_name, last_name, middle_name, nationality, sex, civil_status, employment_status, month_of_birth, day_of_birth, year_of_birth, age)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ssssssssssss', $user_id, $first_name, $last_name, $middle_name, $nationality, $sex, $civil_status, $employment_status, $month_of_birth, $day_of_birth, $year_of_birth, $age);
$stmt1->execute();

// Insert data into contact_information table
$sql2 = "INSERT INTO contact_information (user_id, address_number_street, address_barangay, address_district, address_city_municipality, address_province, address_region, email_facebook, contact_no)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('sssssssss', $user_id, $address_number_street, $address_barangay, $address_district, $address_city_municipality, $address_province, $address_region, $email_facebook, $contact_no);
$stmt2->execute();

// Insert data into profile_images table
$sql3 = "INSERT INTO profile_images (user_id, profile_image, imageUpload)
VALUES (?, ?, ?)";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('sss', $user_id, $profile_image, $imageUpload);
$stmt3->execute();

// Insert data into educational table
$sql4 = "INSERT INTO educational (user_id, educational_attainment, classification, qualification, scholarship)
VALUES (?, ?, ?, ?, ?)";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('sssss', $user_id, $educational_attainment, $classification, $qualification, $scholarship);
$stmt4->execute();

// Insert data into disability_information table
$sql5 = "INSERT INTO disability_information (user_id, disability, cause_of_disability)
VALUES (?, ?, ?)";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('sss', $user_id, $disability, $cause_of_disability);
$stmt5->execute();

// Insert data into ncae_information table
$sql6 = "INSERT INTO ncae_information (user_id, taken_ncae, where, when)
VALUES (?, ?, ?, ?)";
$stmt6 = $conn->prepare($sql6);
$stmt6->bind_param('ssss', $user_id, $taken_ncae, $where, $when);
$stmt6->execute();

// Insert data into registration_details table
$sql7 = "INSERT INTO registration_details (user_id, applicant_signature, date_accomplished, registrar_signature, date_received, privacy_disclaimer)
VALUES (?, ?, ?, ?, ?, ?)";
$stmt7 = $conn->prepare($sql7);
$stmt7->bind_param('ssssss', $user_id, $applicant_signature, $date_accomplished, $registrar_signature, $date_received, $privacy_disclaimer);
$stmt7->execute();

// Insert data into guardian_information table
$sql8 = "INSERT INTO guardian_information (user_id, parent_guardian_name, parent_guardian_address)
VALUES (?, ?, ?)";
$stmt8 = $conn->prepare($sql8);
$stmt8->bind_param('sss', $user_id, $parent_guardian_name, $parent_guardian_address);
$stmt8->execute();

// Insert data into birth_information table
$sql9 = "INSERT INTO birth_information (user_id, birthplace_city_municipality, birthplace_province, birthplace_region, uli_number, entry_date)
VALUES (?, ?, ?, ?, ?, ?)";
$stmt9 = $conn->prepare($sql9);
$stmt9->bind_param('ssssss', $user_id, $birthplace_city_municipality, $birthplace_province, $birthplace_region, $uli_number, $entry_date);
$stmt9->execute();

// Update the user_profile table to set registration_complete to 1
$sql10 = "UPDATE user_profile SET registration_complete = 1 WHERE user_id = ?";
$stmt10 = $conn->prepare($sql10);
$stmt10->bind_param('i', $user_id);
$stmt10->execute();

// Check if all queries were successful
if ($stmt1->affected_rows > 0 && $stmt2->affected_rows > 0 && $stmt3->affected_rows > 0 &&
    $stmt4->affected_rows > 0 && $stmt5->affected_rows > 0 && $stmt6->affected_rows > 0 &&
    $stmt7->affected_rows > 0 && $stmt8->affected_rows > 0 && $stmt9->affected_rows > 0 && $stmt10->affected_rows > 0) {
    
    echo "Registration complete and data inserted successfully.";
    header('Location: login.php');
    exit(); // Ensure the script stops after redirect

} else {
    echo "Error executing queries.";
}

// Close statements and connection
$stmt1->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$stmt5->close();
$stmt6->close();
$stmt7->close();
$stmt8->close();
$stmt9->close();
$stmt10->close();
$conn->close();
