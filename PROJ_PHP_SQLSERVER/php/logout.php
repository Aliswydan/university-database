<?php



if (isset($_POST['logoutteacher'])) {

    session_start();
    unset($_SESSION['teacher_id']) ;
    unset($_SESSION['teacher_name']);



    // Redirect to the login page
    header("Location: login.php");
    exit();
}


if (isset($_POST['logoutstudent'])) {

    session_start();
    unset($_SESSION['student_id']) ;
    unset($_SESSION['student_name']);


    // Redirect to the login page
    header("Location: login.php");
    exit();
}


if (isset($_POST['logoutAdmin'])) {

    session_start();
    unset($_SESSION['admin_name']) ;


    // Redirect to the login page
    header("Location: Adminlogin.php");
    exit();
}

?>


