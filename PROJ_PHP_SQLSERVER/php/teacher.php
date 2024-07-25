<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<?php
session_start(); // Start the session
require_once '1-connectDB.php';
$teacherID = $_SESSION['teacher_id']; 

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

        <?php
        // SQL query to get courses taught by the teacher
        $teacherCoursesQuery = "EXEC GetTeacherCourses '$teacherID';";
        $teacherCoursesResult = sqlsrv_query($connect, $teacherCoursesQuery);
        ?>

        <!-- Display Courses Taught by Teacher -->
        <div class="available-courses">
            <h2>Courses Taught by You</h2>
            <?php
            if (sqlsrv_has_rows($teacherCoursesResult)) {
                echo '<table border="1">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Course ID</th>';
                echo '<th>Course Name</th>';
                echo '<th>Semester</th>';
                echo '<th>Credits</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = sqlsrv_fetch_array($teacherCoursesResult, SQLSRV_FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . ($row['course_id']) . '</td>';
                    echo '<td>' . ($row['course_name']) . '</td>';
                    echo '<td>' . ($row['semester']) . '</td>';
                    echo '<td>' . ($row['credits']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'You are not currently teaching any courses.';
            }
            ?>
        </div>







        <?php

$query = "EXEC GetTeacherExams @teacher_id = '$teacherID'";
$teacherexam = sqlsrv_query($connect, $query);
?>

        <?php
if (sqlsrv_has_rows($teacherexam)) { ?>
    <div class="available-courses">
        <h2>Exams Schedule for Teacher <?php echo $teacherID; ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Exam Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($exam = sqlsrv_fetch_array($teacherexam, SQLSRV_FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $exam['course_id']; ?></td>
                        <td><?php echo $exam['course_name']; ?></td>
                        <td><?php echo $exam['exam_date']->format('Y-m-d'); ?></td>
                        <td><?php echo $exam['start_time']->format('H:i:s'); ?></td>
                        <td><?php echo $exam['end_time']->format('H:i:s'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p>No exams found for Your course.</p>
<?php } ?>




</body>
</html>