<?php
session_start(); // Start the session
require_once '1-connectDB.php';
$studentID = $_SESSION['student_id'];





$sql = "SELECT * FROM Student WHERE student_id = ?";
$params = array($studentID);
$result = sqlsrv_query($connect, $sql, $params);

// Check for errors
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if the student exists
if (sqlsrv_has_rows($result)) {
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    $birthdate = $row["birthdate"];





// Execute the stored procedure for passed courses
$sqlPassedCourses = "{CALL GetPassedCourses(?)}";
$paramsPassedCourses = array($studentID);
$resultPassedCourses = sqlsrv_query($connect, $sqlPassedCourses, $paramsPassedCourses);

// Check for errors
if ($resultPassedCourses === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the results for passed courses
$passedCourses = array();
while ($row2 = sqlsrv_fetch_array($resultPassedCourses, SQLSRV_FETCH_ASSOC)) {
    $passedCourses[] = $row2;
}


// Execute the stored procedure for failed courses
$sqlFailedCourses = "{CALL GetFailedCourses(?)}";
$paramsFailedCourses = array($studentID);
$resultFailedCourses = sqlsrv_query($connect, $sqlFailedCourses, $paramsFailedCourses);

// Check for errors
if ($resultFailedCourses === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the results for failed courses
$failedCourses = array();
while ($rowFailed = sqlsrv_fetch_array($resultFailedCourses, SQLSRV_FETCH_ASSOC)) {
    $failedCourses[] = $rowFailed;
}




// Call the SQL Server scalar-valued function to get the total credits for the student
$sqlTotalCredits = "SELECT dbo.CalculateTotalStudentCredits(?) AS totalCredits";
$paramsTotalCredits = array($studentID);
$resultTotalCredits = sqlsrv_query($connect, $sqlTotalCredits, $paramsTotalCredits);

if ($resultTotalCredits !== false) {
    $rowTotalCredits = sqlsrv_fetch_array($resultTotalCredits);
    $totalCredits = $rowTotalCredits['totalCredits'];
} else {
    // Handle the error or provide a default value
    $totalCredits = 0;
}


?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/StudentProfile.css">
        <title>Student Information</title>
    </head>
    <body>
    <header>
        <nav>
            <a href="profileS.php">Profile</a>

            <a href="course.php">Courses</a>
            <form action="logout.php" method="post">
                 <button type="submit" name="logoutstudent" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
             </form>
        </nav>
    </header>
    <div class="main-content">
         <div class="student-info">
            <h2>Student Information</h2>
            <p><strong>Student ID:</strong> <?php echo $row["student_id"]; ?></p>
            <p><strong>Password:</strong> <?php echo $row["password"]; ?></p>
            <p><strong>Student Name:</strong> <?php echo $row["student_name"]; ?></p>
            <p><strong>Birthday:</strong> <?php echo $birthdate->format('Y-m-d'); ?></p>
            <p><strong>Address:</strong> <?php echo $row["address"]; ?></p>
            <p><strong>Phone:</strong> <?php echo $row["phone"]; ?></p>
            <p><strong>GPA:</strong> <?php echo $row["GPA"]; ?></p>
        </div>

        <div class="passed-courses">
            <!-- Passed courses section -->
            <h2>Passed Courses</h2>
            <?php if (!empty($passedCourses)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($passedCourses as $course) : ?>
                            <tr>
                                <td><?php echo $course['course_id']; ?></td>
                                <td><?php echo $course['course_name']; ?></td>
                                <td><?php echo $course['semester']; ?></td>
                                <td><?php echo $course['mark']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No passed courses found.</p>
            <?php endif; ?>
        </div>
            <div class="failed-courses">
            <!-- Failed courses section -->
            <h2>Failed Courses</h2>
            <?php if (!empty($failedCourses)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($failedCourses as $courseFailed) : ?>
                            <tr>
                                <td><?php echo $courseFailed['course_id']; ?></td>
                                <td><?php echo $courseFailed['course_name']; ?></td>
                                <td><?php echo $courseFailed['semester']; ?></td>
                                <td><?php echo $courseFailed['mark']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No failed courses found.</p>
            <?php endif; ?>
        </div>
        

        <!-- Add additional content on the right here -->
        <div class="credits-info">
    <h2>Sum Credits</h2>
    <p><strong>Total Credits:</strong> <?php echo $totalCredits; ?></p>
</div>
    </div>
    </body>
    </html>
    <?php
} else {
    echo "Student not found.";
}
