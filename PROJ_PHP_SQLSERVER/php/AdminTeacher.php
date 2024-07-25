<?php
session_start();
include_once '1-connectDb.php';
$admin_name = $_SESSION['admin_name'];
$errorMessage = '';

function addTeacher($connect, $teacherID, $admin_name, $password, $teacherName, $address = null, $phone = null, $speciality = null)
{
            $test = "SELECT 1 FROM Teacher WHERE teacher_id = '$teacherID' ;";
            $Result = sqlsrv_query($connect, $test);

            if (sqlsrv_has_rows($Result)) {
                $sql = "{CALL EditTeacher(?, ?, ?, ?, ?, ?, ?)}";

                $params = array(
                    array(&$teacherID),
                    array(&$admin_name),
                    array(&$password),
                    array(&$teacherName),
                    array(&$address),
                    array(&$phone),
                    array(&$speciality)
                );

                $stmt = sqlsrv_prepare($connect, $sql, $params);

                if (sqlsrv_execute($stmt)) {
                    return 'Teacher Edit successfully.';
                } else {
                    return 'Error editing teacher to the database.';
                }

                sqlsrv_free_stmt($stmt);
            } else {
                $sql = "{CALL AddTeacher(?, ?, ?, ?, ?, ?, ?)}";

                    $params = array(
                    array(&$teacherID),
                    array(&$admin_name),
                    array(&$password),
                    array(&$teacherName),
                    array(&$address),
                    array(&$phone),
                    array(&$speciality)
                );

                $stmt = sqlsrv_prepare($connect, $sql, $params);

                if (sqlsrv_execute($stmt)) {
                    return 'Teacher added successfully.';
                } else {
                    return 'Error adding teacher to the database.';
                }

                sqlsrv_free_stmt($stmt);
         }


    
}






if (isset($_POST['submit'])) {
    $teacherID = $_POST['teachertID'];
    $adminName = $_SESSION['admin_name'];
    $password = $_POST['teacherpass'];
    $teacherName = $_POST['teachertName'];
    $address = isset($_POST['teacherAddress']) ? $_POST['teacherAddress'] : null;
    $phone = isset($_POST['teacherPhone']) ? $_POST['teacherPhone'] : null;
    $speciality = isset($_POST['teacherSpeciality']) ? $_POST['teacherSpeciality'] : null;

    $errorMessage = addTeacher($connect, $teacherID, $adminName, $password, $teacherName, $address, $phone, $speciality);
}


if (isset($_POST['editTeacher'])) {

    $teacherID = $_POST['editTeacher'];
    $password = $_POST['password'];
    $teacher_name = $_POST['teacher_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $speciality = $_POST['speciality'];

   
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
    function getRegisteredTeachers($connect, $admin_name)
    {
        $sql = "SELECT * FROM dbo.GetRegisteredTeachersFunction(?)";
        $stmt = sqlsrv_prepare($connect, $sql, array(&$admin_name));

        if (sqlsrv_execute($stmt)) {
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Teacher ID</th>';
            echo '<th>Password</th>';
            echo '<th>Teacher Name</th>';
            echo '<th>Address</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Speciality</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . ($row['teacher_id']) . '</td>';
                echo '<td>' . ($row['password']) . '</td>';
                echo '<td>' . ($row['teacher_name']) . '</td>';
                echo '<td>' . ($row['address']) . '</td>';
                echo '<td>' . ($row['phone']) . '</td>';
                echo '<td>' . ($row['speciality']) . '</td>';
                echo '<td>';
                    echo '<form method="post" action="">';
                        echo '<input type="hidden" name="editTeacher" value="' . $row['teacher_id'] . '">';
                        echo '<input type="hidden" name="password" value="' . $row['password'] . '">';
                        echo '<input type="hidden" name="teacher_name" value="' . $row['teacher_name'] . '">';
                        echo '<input type="hidden" name="address" value="' . $row['address'] . '">';
                        echo '<input type="hidden" name="phone" value="' . $row['phone'] . '">';
                        echo '<input type="hidden" name="speciality" value="' . $row['speciality'] . '">';
                        echo '<input type="submit" name="edit" value="Edit">';
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

    echo '<div class="available">';
    echo '<h2>Available Teachers </h2>';
    getRegisteredTeachers($connect, $admin_name);
    echo '</div>';
    ?>



<div class="adminForm">




    <form method="post" action="">
        
        <label for="teachertID">Teacher ID:</label>
        <input type="text" name="teachertID" value="<?php echo isset($teacherID) ? $teacherID : ''; ?>" required><br>

        <label for="teachertName">Teacher Name:</label>
        <input type="text" name="teachertName" value="<?php echo isset($teacher_name) ? $teacher_name : ''; ?>" required><br>

        <label for="teacherpass">Password:</label>
        <input type="password" name="teacherpass" value="<?php echo isset($password) ? $password : ''; ?>" required><br> 

        <label for="teacherAddress">Address:</label>
        <input type="text" name="teacherAddress" value="<?php echo isset($address) ? $address : ''; ?>" ><br>

        <label for="teacherPhone">Phone:</label>
        <input type="text" name="teacherPhone" value="<?php echo isset($phone) ? $phone : ''; ?>" ><br>

        <label for="teacherSpeciality">Speciality:</label>
        <input type="text" name="teacherSpeciality" value="<?php echo isset($speciality) ? $speciality : ''; ?>" ><br>

        <input type="submit" name="submit" value="Add Teacher">
        <div id="error-message" style="color: red;"><?php echo $errorMessage; ?></div>
    </form>
    </div>

</main>
</body>
</html>
