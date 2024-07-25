<?php
session_start();
require_once '1-connectDB.php';

$errorMessage = '';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $admin_name = $_POST["admin_name"];
    $password = $_POST["password"];

    // Use parameterized query to prevent SQL injection
    $sql = "SELECT * FROM Adminstrator WHERE admin_name = ? AND password = ?";
    $params = array($admin_name, $password);

    $result = sqlsrv_query($connect, $sql, $params);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true)); // Print detailed error information
    }

    if (sqlsrv_has_rows($result)) {
    // Admin login successful
    $_SESSION['admin_name'] = $admin_name;
    header("location: AdminCourse.php"); // Redirect to admin dashboard
    }else {
        $errorMessage = 'Invalid ID or Password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/AdminLogin.css">
    <title>Login Page</title>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <label for="admin_name">Admin Name:</label>
            <input type="text" id="admin_name" name="admin_name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <div id="error-message" style="color: red;"><?php echo $errorMessage; ?></div>

        </form>
    </div>
</body>
</html>
