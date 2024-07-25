
<script>
        if ( window.history.replaceState )  {
            window.history.replaceState( null, null, window.location.href );
                                            }
    </script> 
<?php
session_start();
require_once '1-connectDB.php';
$teacherID = $_SESSION['teacher_id'];

function displayTable($courseID, $coursesResult) {
    echo '<table border="1">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Student ID</th>';
    echo '<th>Course ID</th>';
    echo '<th>Course Name</th>';
    echo '<th>Semester</th>';
    echo '<th>Mark</th>';
    echo '<th>Action</th>'; // Added column for Edit action
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = sqlsrv_fetch_array($coursesResult, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['student_id'] . '</td>';
        echo '<td>' . $courseID . '</td>';
        echo '<td>' . $row['course_name'] . '</td>';
        echo '<td>' . $row['semester'] . '</td>';
        echo '<td>';

        if ($row['mark'] !== null) {
            // Display the current mark
            echo $row['mark'];
        } else {
            // Display a form to add a new mark
            echo '<form method="post" action="mark.php">';
            echo '<input type="hidden" name="course_id" value="' . $courseID . '">';
            echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
            echo '<input type="text" name="new_mark" placeholder="Enter mark">';
            echo '<input type="submit" name="Submit" value="Submit">';
            echo '</form>';
        }

        echo '</td>';

        // Edit action column
        echo '<td>';
        echo '<form method="post" action="mark.php">';
        echo '<input type="hidden" name="course_id" value="' . $courseID . '">';
        echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
        echo '<input type="submit" name="Edit" value="Edit">';
        echo '</form>';

        if (isset($_POST['Edit']) && isset($_POST['course_id']) && isset($_POST['student_id']) && $_POST['course_id'] == $courseID && $_POST['student_id'] == $row['student_id']) {
            // Display a form to add a new mark
            echo '<form method="post" action="mark.php">';
            echo '<input type="hidden" name="course_id" value="' . $courseID . '">';
            echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
            echo '<input type="text" name="new_mark" placeholder="Enter mark">';
            echo '<input type="submit" name="Submit" value="Submit">';
            echo '</form>';
        }

        echo '</td>';

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/course.css" rel="stylesheet">
    <title>Teacher Page</title>
</head>

<body>
    <header>
        <nav>

            <a href="teacher.php">Courses</a>
            <a href="mark.php">Marks</a>
            <form action="logout.php" method="post">
                 <button type="submit" name="logoutstudent" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
             </form>
        </nav>
    </header>
    <main>

    <div class="available-courses">
    <?php
    $getCoursesQuery = "SELECT DISTINCT course_id FROM MarkRegister";
    $getCoursesResult = sqlsrv_query($connect, $getCoursesQuery);

    if (sqlsrv_has_rows($getCoursesResult)) {
        echo '<h2>Courses and Their Students with Marks</h2>';

        while ($courseRow = sqlsrv_fetch_array($getCoursesResult, SQLSRV_FETCH_ASSOC)) {
            $currentCourseID = $courseRow['course_id'];
            $enrolledStudentsQuery = "EXEC GetCourseForMark '$currentCourseID' , '$teacherID'";
            $courseStudentsResult = sqlsrv_query($connect, $enrolledStudentsQuery);

            if ($courseStudentsResult !== false && sqlsrv_has_rows($courseStudentsResult)) {
                echo '<h3>Course ID: ' . $currentCourseID . '</h3>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="course_id" value="' . $currentCourseID . '">';
                echo '<input type="submit" name="compansate" value="Compensate">';
                echo '</form>';

                displayTable($currentCourseID, $courseStudentsResult);
            }
        }
    } else {
        echo '<h2>No exam for courses</h2>';
    }
    ?>
</div>

<?php
if (isset($_POST['compansate'])) {
    $currentCourseID = $_POST['course_id'];

    $sql = "{CALL UpdateMarksForCourse(?)}";
    $params = array(
        array(&$currentCourseID)
    );
    $stmt = sqlsrv_prepare($connect, $sql, $params);

    sqlsrv_execute($stmt);

    $_SESSION['form_submitted'] = true;

            // Redirect to prevent form resubmission
            header('Location: mark.php');
            exit();
}



        if (isset($_POST['Submit']) && isset($_POST['student_id']) && isset($_POST['course_id']) && isset($_POST['new_mark'])) {
            $mark = ($_POST['new_mark']);
            $currentStudentID = $_POST['student_id'];
            $currentCourseID = $_POST['course_id'];

            $query = "EXEC AddMarksForExam @course_id = '$currentCourseID', @student_id = '$currentStudentID', @mark = '$mark'";
            $teacherexam = sqlsrv_query($connect, $query);

            $_SESSION['form_submitted'] = true;

            // Redirect to prevent form resubmission
            header('Location: mark.php');
            exit();
        }

        if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
            $_SESSION['form_submitted'] = false;
        }

        ?>
    </main>
</body>

</html>
