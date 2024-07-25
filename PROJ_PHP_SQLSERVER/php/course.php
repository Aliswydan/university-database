<script>
        if ( window.history.replaceState )  {
            window.history.replaceState( null, null, window.location.href );
                                            }
    </script> 
    
    <?php
session_start(); // Start the session
require_once '1-connectDB.php';
$studentID = $_SESSION['student_id'];

if (isset($_POST['enroll_course']) && isset($_POST['semester'])  ) {

    $courseID = $_POST['enroll_course'];
    $semester = $_POST['semester'];
    $Credit = $_POST['credits'];

    if($semester == 'semester-1'){
        // Call the stored procedure to enroll the student in the course
        $enrollProcedure = "EXEC EnrollStudentInSemester1 @student_id = ?, @course_id = ?, @semester = ?;";
        $params = array($studentID, $courseID, $semester);
        $enrollResult = sqlsrv_query($connect, $enrollProcedure, $params);

        
    }elseif($semester == 'semester-2'){
    // Call the stored procedure to enroll the student in the course
    $enrollProcedure = "EXEC EnrollStudentInSemester @student_id = ?, @course_id = ?, @semester = ?;";
    $params = array($studentID, $courseID, $semester);
    $enrollResult = sqlsrv_query($connect, $enrollProcedure, $params);

    }elseif($semester == 'semester-3'){
        // Call the stored procedure to enroll the student in the course
        $enrollProcedure = "EXEC EnrollStudentInSemester @student_id = ?, @course_id = ?, @semester = ?;";
        $params = array($studentID, $courseID, $semester);
        $enrollResult = sqlsrv_query($connect, $enrollProcedure, $params);
    }elseif($semester == 'semester-4'){
        // Call the stored procedure to enroll the student in the course
        $enrollProcedure = "EXEC EnrollStudentInSemester @student_id = ?, @course_id = ?, @semester = ?;";
        $params = array($studentID, $courseID, $semester);
        $enrollResult = sqlsrv_query($connect, $enrollProcedure, $params);
    }

    $sqlTotalCredits = "SELECT dbo.CalculateTotalStudentCredits(?) AS totalCredits";
    $paramsTotalCredits = array($studentID);
    $resultTotalCredits = sqlsrv_query($connect, $sqlTotalCredits, $paramsTotalCredits);
    
    if ($enrollResult === false) {
        
            echo '<script>alert("You can not enroll because you will exceed 30 credits.");</script>';
        }
    }
            





// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unenroll_course'])) {
    // Enroll in the selected course
    $courseID = $_POST['unenroll_course'];

    
        // Call the stored procedure to enroll the student in the course
        $unenrollProcedure = "EXEC UnenrollStudentFromCourse @student_id = '$studentID', @course_id = '$courseID';";
        $unenrollResult = sqlsrv_query($connect, $unenrollProcedure);
    

        if ($unenrollResult) { ?>
                <script>alert('Operation successful');</script>
        <?php    }
         else {
         ?> 
                <script>alert('You can not unenrolled because the mark is 50 or above.');</script>
        <?php } 
    }?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/course.css" rel="stylesheet">
    <title>Student Page</title>
    
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
    <main>

        <?php
        // SQL query to get enrolled courses for the student
        $enrolledCoursesQuery = "EXEC GetStudentCoursesAndMarksWithSemesterAndCredit '$studentID';";
        $enrolledCoursesResult = sqlsrv_query($connect, $enrolledCoursesQuery);
        ?>

        <!-- Display Enrolled Courses -->
        <div class="Enrolled-Courses">
            <h2>Enrolled Courses</h2>
            <?php
            if (sqlsrv_has_rows($enrolledCoursesResult)) {
                echo '<table border="1">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Course ID</th>';
                echo '<th>Course Name</th>';
                echo '<th>Semester</th>';
                echo '<th>Credits</th>';
                echo '<th>Mark</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = sqlsrv_fetch_array($enrolledCoursesResult, SQLSRV_FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . ($row['course_id']) . '</td>';
                    echo '<td>' . ($row['course_name']) . '</td>';
                    echo '<td>' . ($row['semester']) . '</td>';
                    echo '<td>' . ($row['credits']) . '</td>';
                    echo '<td>' . ($row['mark']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No enrolled courses found for the student.';
            }
            ?>
        </div>



<?php
function displayCourses($connect , $semester, $studentID)
{
// SQL query to get all available semester-1 courses
$availableCoursesQuery = "SELECT course_id, course_name, credits, semester FROM Course WHERE semester='$semester';";
$availableCoursesResult = sqlsrv_query($connect, $availableCoursesQuery);

    if (sqlsrv_has_rows($availableCoursesResult)) {
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>credit</th>';
        echo '<th>semester</th>';
        echo '<th>Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($row = sqlsrv_fetch_array($availableCoursesResult, SQLSRV_FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . ($row['course_id']) . '</td>';
            echo '<td>' . ($row['course_name']) . '</td>';
            echo '<td>' . ($row['credits']) . '</td>';
            echo '<td>' . ($row['semester']) . '</td>';

            echo '<td>';
            // Check if the current course is already enrolled
            $checkEnrollmentQuery = "SELECT 1 FROM StudentCourses WHERE student_id = '$studentID' AND course_id = '{$row['course_id']}';";
            $checkEnrollmentResult = sqlsrv_query($connect, $checkEnrollmentQuery);

            if (sqlsrv_has_rows($checkEnrollmentResult)) {
                echo '<button type="submit" name="unenroll_course" value="' . ($row['course_id']) . '">UnEnroll</button>';
            } else {
                echo '<input type="hidden" name="credits" value="' . $row['credits'] . '"/>';
                echo '<input type="hidden" name="semester" value="' . $row['semester'] . '"/>';
                echo '<button type="submit" name="enroll_course" value="' . ($row['course_id']) . '">Enroll</button>';
            }
            echo '</td>'; // Enroll button
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No available courses found.';
    }
}

echo '<div class="available-courses">';

// Display Available Courses for semester-1
echo '<h2>Semester-1 Courses</h2>';
echo '<form method="post" action="">';
displayCourses($connect , 'semester-1', $studentID);
echo '</form>';



// Display Available Courses for semester-2

echo '<h2>Semester-2 Courses</h2>';
echo '<form method="post" action="">';
displayCourses( $connect , 'semester-2', $studentID);
echo '</form>';



// Display Available Courses for semester-3

echo '<h2>Semester-3 Courses</h2>';
echo '<form method="post" action="">';
displayCourses( $connect , 'semester-3', $studentID);
echo '</form>';


// Display Available Courses for semester-3

echo '<h2>Semester-4 Courses</h2>';
echo '<form method="post" action="">';
displayCourses( $connect , 'semester-4', $studentID);
echo '</form>';



echo '</div>';


?>


    </main>
</body>
</html>
