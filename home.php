<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
     /* Global Styles */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
   
}

#header h1{
    
  padding-top: 5px;
   

}
/* Header Styles */
#header {
    background-color: #2575fc;
    padding: 1em;
    height: 75px;
    width: auto; /* Make header responsive by setting the width to 100% */
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin-top: -30px;
    margin-left: -35px;
    
}

h1 {
    font-size: 2em;
    margin: 0;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

/* Home Section Styles */
#home-section {
    background-image: url('dash.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 110vh; /* Full viewport height */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Centers content vertically */
    align-items: center; /* Centers content horizontally */
    color: white;
    text-align: center;
    padding: 2em;
    box-sizing: border-box;
    margin-left: -35px;
}



        /* Box Container Styles */
        .box-container {
            display: flex;
            position: relative;
            top: -70px;
            gap: 15px;
            justify-content: center; /* Centers the boxes horizontally */
            align-items: center; /* Centers the boxes vertically within the container */
            padding-top: 5rem;
        }

        .box {
            flex: 0;
            min-width: 200px;
            padding: 20px;
            height: 8rem;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            background-color: rgba(0, 0, 0, 0.2);
            position: relative;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .box h3 {
            margin: 0;
            color: #333;
        }

        .box p {
            margin: 10px 0 0;
            font-size: 16px;
        }
        
        /* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
    h1 {
        font-size: 1.5em;
    }

    .box {
        padding: 15px;
        flex: 1 1 100%; /* Box takes full width on smaller screens */
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 1.2em;
    }

    #home-section {
        padding: 1.5em;
    }

    .box {
        padding: 10px;
        flex: 1 1 100%; /* Full-width boxes on very small screens */
    }
}
    </style>
</head>
<body>

<!-- Header -->
<div id="header">
    <h1>Welcome Admin</h1>
</div>

<!-- Home Section -->
<section id="home-section">
    <div class="box-container">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = ""; // Update this with your database password
        $dbname = "tesda"; // Update this with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // List of courses
        $courses = [
            "Cookery NC II",
            "Food and Beverage Service NC II",
            "Housekeeping NC II",
            "Front Office Service NC II",
            "SMAW NC I and SMAW NC II"
        ];

        // Prepare SQL to count students for each course
        $course_counts = [];
        foreach ($courses as $course) {
            $sql = "SELECT COUNT(*) AS student_count FROM education WHERE qualification = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Failed to prepare SQL statement: " . $conn->error);
            }

            $stmt->bind_param("s", $course);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                die("Failed to get result: " . $stmt->error);
            }

            $row = $result->fetch_assoc();
            $course_counts[$course] = $row['student_count'];
            $stmt->close();
        }

        $conn->close();
        ?>

        <?php foreach ($courses as $course): ?>
            <div class="box">
                <h3><?php echo htmlspecialchars($course); ?></h3>
                <p>Total Students: <?php echo htmlspecialchars($course_counts[$course] ?? 0); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

</body>
</html>