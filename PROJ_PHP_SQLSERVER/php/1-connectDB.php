<?php

$serverName = "ALI-SWEIDAN";
$database = "univdb";
$uid = "sa";
$pass = "3li@admin"; 

$connectionOptions = [
    "Database" => $database,
    "UID" => $uid,
    "PWD" => $pass,
    "CharacterSet" => "UTF-8",
];

$connect = sqlsrv_connect($serverName, $connectionOptions);

// Check if the connection is successful
if (!$connect) {
    die(print_r(sqlsrv_errors(), true));
}

// Return the connection resource
return $connect;
?>





