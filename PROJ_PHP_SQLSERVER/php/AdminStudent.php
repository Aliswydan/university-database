<?php
session_start();
include_once '1-connectDb.php';

$errorMessage = '';

// Check if the admin_name session variable is set
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : '';

function addStudent($connect, $studentID, $admin_name, $password, $studentName, $birthdate = null, $address = null, $phone = null)
{
    $sql = "{CALL AddStudent(?, ?, ?, ?, ?, ?, ?)}";

    $params = array(
        array(&$studentID),
        array(&$admin_name),
        array(&$password),
        array(&$studentName),
        array(&$birthdate),
        array(&$address),
        array(&$phone)
    );

    $stmt = sqlsrv_prepare($connect, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        return 'Student added successfully.';
    } else {
        return 'Error adding student to the database.';
    }

    sqlsrv_free_stmt($stmt);
}

if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $adminName = $admin_name; // Use the admin_name obtained from the session
    $password = $_POST['studentpass'];
    $studentName = $_POST['studentName'];
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;
    $address = isset($_POST['studentAddress']) ? $_POST['studentAddress'] : null;
    $phone = isset($_POST['studentPhone']) ? $_POST['studentPhone'] : null;

    $errorMessage = addStudent($connect, $studentID, $adminName, $password, $studentName, $birthdate, $address, $phone);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    
    <link rel="stylesheet" href="../css/AdminHome.css">

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
    <?php
    function getRegisteredStudents($connect, $admin_name)
    {
        $sql = "SELECT * FROM dbo.GetRegisteredStudentsFunction(?)";
        $stmt = sqlsrv_prepare($connect, $sql, array(&$admin_name));

        if (sqlsrv_execute($stmt)) {
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Student ID</th>';
            echo '<th>Password</th>';
            echo '<th>Student Name</th>';
            echo '<th>Birthdate</th>';
            echo '<th>Address</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['student_id'] . '</td>';
                echo '<td>' . $row['password'] . '</td>';
                echo '<td>' . $row['student_name'] . '</td>';
                echo '<td>' . ($row['birthdate'] ? $row['birthdate']->format('Y-m-d') : '') . '</td>';

                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
                
                // Add a "Delete" button and a hidden input for each row
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="studentID" value="' . $row['student_id'] . '">';
                echo '<button type="submit" name="buttondelete">Delete</button>';
                echo '</form>';
                echo '</td>';
                
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'Error executing SQL query.';
        }
    }



    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["studentID"]) && isset($_POST['buttondelete'])) {
        $studentID = $_POST["studentID"];
    
        // Call the stored procedure to delete the student by ID
        $tsql = "{call DeleteStudentById(?)}";
        $params = array(
            array($studentID, SQLSRV_PARAM_IN)
        );
    
        $stmt = sqlsrv_query($connect, $tsql, $params);
    
    
    
        sqlsrv_free_stmt($stmt);
    }



    
    echo '<div class="available">';
    echo '<h2>Available Students </h2>';
    getRegisteredStudents($connect, $admin_name);
    echo '</div>';
    ?>

    <div class="adminForm">
        <form method="post" action="">
            
            <label for="studentID">Student ID:</label>
            <input type="text" name="studentID" required><br>

            <label for="studentName">Student Name:</label>
            <input type="text" name="studentName" required><br>

            <label for="studentpass">Password:</label>
            <input type="password" name="studentpass" required><br>

            <label for="birthdate">Birthdate:</label>
            <input type="date" name="birthdate"><br>

            <label for="studentAddress">Address:</label>
            <input type="text" name="studentAddress"><br>

            <label for="studentPhone">Phone:</label>
            <input type="text" name="studentPhone"><br>

            <input type="submit" name="submit" value="Add Student">
            <div id="error-message" style="color: red;"><?php echo $errorMessage; ?></div>
        </form>
    </div>
</main>
</body>
</html>
