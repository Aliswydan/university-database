<?php
session_start();
include_once '1-connectDb.php';
$adminName = $_SESSION['admin_name'];
$errorMessage = '';

function addCourseAndExam($connect, $courseID, $teacherID, $adminName, $courseName, $hours, $credits, $semester, $examID, $examDate, $startTime, $endTime)
{
    // Add Course
    $sqlAddCourse = "{CALL AddCourse(?, ?, ?, ?, ?, ?, ?)}";
    $paramsAddCourse = array(
        array(&$courseID),
        array(&$teacherID),
        array(&$adminName),
        array(&$courseName),
        array(&$hours),
        array(&$credits),
        array(&$semester)
    );
    $stmtAddCourse = sqlsrv_prepare($connect, $sqlAddCourse, $paramsAddCourse);

    if (sqlsrv_execute($stmtAddCourse)) {
        $resultMessage = 'Course added successfully.';
    } else {
        $resultMessage = 'Error adding Course to the database.';
    }

    sqlsrv_free_stmt($stmtAddCourse);

    // Add Exam
    $sqlAddExam = "{CALL AddExam(?, ?, ?, ?, ?)}";
    $paramsAddExam = array(
        array(&$examID),
        array(&$courseID),
        array(&$examDate),
        array(&$startTime),
        array(&$endTime)
    );
    $stmtAddExam = sqlsrv_prepare($connect, $sqlAddExam, $paramsAddExam);

    if (sqlsrv_execute($stmtAddExam)) {
        $resultMessage .= '<br>Exam added successfully.';
    } else {
        $resultMessage .= '<br>Error adding Exam to the database.';
    }

    sqlsrv_free_stmt($stmtAddExam);

    return $resultMessage;
}


// Check if the form was submitted for adding or editing
if (isset($_POST['submit'])) {
    $courseID = $_POST['courseID'];
    $teacherID = $_POST['teacherID'];
    $courseName = $_POST['courseName'];
    $hours = $_POST['hours'];
    $credits = $_POST['credits'];
    $semester = $_POST['semester'];
    $examID = $_POST['examID'];
    $examDate = $_POST['examDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    
    <link rel="stylesheet" href="../css/AdminCourse.css">

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>

<header>
    <nav>
        <a href="AdminCourse.php">Courses</a> 
        <a href="AdminStudent.php">Students</a> 
        <a href="AdminTeacher.php">Teachers</a> 
        <form action="logout.php" method="post">
            <button type="submit" name="logoutAdmin" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
        </form>
    </nav>
</header>

<main>
    <div class="adminForm">
        <div id="error-message" style="color: red;"><?php echo $errorMessage; ?></div>

        <form method="post" action="">
            <h2>Add Course and Exam</h2>
            
            <label for="courseID">Course ID:</label>
            <input type="text" name="courseID" required><br>

            <label for="teacherID">Teacher ID:</label>
            <select name="teacherID" required>
                <?php
                // Fetch available teachers and populate the dropdown options
                $sqlGetTeachers = "SELECT teacher_id, teacher_name FROM Teacher";
                $stmtGetTeachers = sqlsrv_query($connect, $sqlGetTeachers);

                while ($row = sqlsrv_fetch_array($stmtGetTeachers, SQLSRV_FETCH_ASSOC)) {
                    echo '<option value="' . $row['teacher_id'] . '">' . $row['teacher_name'] . ' (' . $row['teacher_id'] . ')</option>';
                }
                ?>
            </select><br>

            <label for="courseName">Course Name:</label>
            <input type="text" name="courseName" required><br>

            <label for="hours">Hours:</label>
            <input type="number" name="hours" required><br>

            <label for="credits">Credits:</label>
            <input type="number" name="credits" required><br>

        </div>
        
        <div class="adminForm2">
            <label for="semester">Semester:</label>
            <select name="semester" required>
                <option value="semester-1">semester-1</option>
                <option value="semester-2">semester-2</option>
                <option value="semester-3">semester-3</option>
                <option value="semester-4">semester-4</option>
            </select>

            <label for="examID">Exam ID:</label>
            <input type="text" name="examID" required><br>

            <label for="examDate">Exam Date:</label>
            <input type="date" name="examDate" required><br>

            <label for="startTime">Start Time:</label>
            <input type="time" name="startTime" required><br>

            <label for="endTime">End Time:</label>
            <input type="time" name="endTime" required><br>

            <!-- Add a hidden input field for editing -->
            <input type="hidden" name="editCourseID" value="">
            
            <input type="submit" name="submit" value="Add Course and Exam">
        </form>
        
    </div>

    <?php
    function viewCoursesAndExams($connect, $adminName)
    {
        $sql = "SELECT * FROM dbo.ViewCoursesAndExams(?)";
        $params = array(array(&$adminName));

        $stmt = sqlsrv_query($connect, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>teacher Name</th>';
        echo '<th>Hours</th>';
        echo '<th>Credits</th>';
        echo '<th>Semester</th>';
        echo '<th>Exam ID</th>';
        echo '<th>Exam Date</th>';
        echo '<th>Start Time</th>';
        echo '<th>End Time</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['teacher_name'] . '</td>';
            echo '<td>' . $row['hours'] . '</td>';
            echo '<td>' . $row['credits'] . '</td>';
            echo '<td>' . $row['semester'] . '</td>';
            echo '<td>' . ($row['exam_id'] ?? '') . '</td>';
            echo '<td>' . ($row['exam_date'] ? $row['exam_date']->format('Y-m-d') : '') . '</td>';
            echo '<td>' . ($row['start_time'] ? $row['start_time']->format(' H:i:s') : '') . '</td>';
            echo '<td>' . ($row['end_time'] ? $row['end_time']->format(' H:i:s') : '') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        sqlsrv_free_stmt($stmt);
    }
    ?>

    <div class="available-Course"> 
        <?php viewCoursesAndExams($connect, $adminName); ?>
    </div>

</main>
</body>
</html>