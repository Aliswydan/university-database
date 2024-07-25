<?php
session_start(); // Start the session

require_once '1-connectDB.php';


$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if ($_POST['role'] === 'student') {
        
    
    $tablename = 'Student';
    $name = $_POST['id'];  
    $pass = $_POST['password'];

    $sql = "SELECT * FROM $tablename WHERE student_id = ? AND password = ?";
    $params = array($name, $pass);

    $result = sqlsrv_query($connect, $sql, $params);

    if (sqlsrv_has_rows($result)) {
        $userData = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        $_SESSION['student_id'] = $userData['student_id'];
        $_SESSION['student_name'] = $userData['student_name'];

        header("Location: course.php");
        exit();
                                }else {
                                    $errorMessage = 'Invalid ID or Password';
                                }

    }elseif ($_POST['role'] === 'teacher') {

        $tablename = 'Teacher';
        $name = $_POST['id']; 
        $pass = $_POST['password'];
    
        $sql = "SELECT * FROM $tablename WHERE teacher_id = ? AND password = ?";
        $params = array($name, $pass);
    
        $result = sqlsrv_query($connect, $sql, $params);
    
        if (sqlsrv_has_rows($result)) {
            $userData = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
            $_SESSION['teacher_id'] = $userData['teacher_id'];
            $_SESSION['teacher_name'] = $userData['teacher_name'];


            header("Location: teacher.php");
            exit();
        }else {
            $errorMessage = 'Invalid ID or Password';
        }
    } else {
        $errorMessage = 'Invalid ID or Password';
    }
}

sqlsrv_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet">
    <title>Log in</title>
</head>
<body>
    <div id="login">
        <form method="post" action="../php/login.php">
            <h1>Login</h1>

            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <div class="role-options">
                    <input type="radio" name="role" value="student" id="student" checked>
                    <label for="student">Student</label>
                    <input type="radio" name="role" value="teacher" id="teacher">
                    <label for="teacher">Teacher</label>
                </div>
            </div>

            <div class="form-group">  
                <input type="submit" name="submit" value="Login">
            </div>
            <div id="error-message" style="color: red;"><?php echo $errorMessage; ?></div>
            
        </form>
    </div>
</body>
</html>
