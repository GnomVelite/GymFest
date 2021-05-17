<?php

//header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//session_start();
include "../db/conn.php";
header("Content-Type: application/json");

$response = [];

$data = json_decode(file_get_contents('php://input'), true);

$token = mysqli_real_escape_string($conn, $data['token']);

//$email = "felixfalck@gmail.com";
//$password = "jfr53jks";



$fetchToken = "SELECT id FROM users WHERE `appToken` = '".($token)."'";
$fetchedToken = $conn->query($fetchToken);

if ($fetchedToken->num_rows > 0) {
while($row = $fetchedToken -> fetch_assoc()) {
    $response['status'] = "OK";
    $response['token'] = $token;
    
    header("HTTP/1.1 200 OK");
    echo json_encode($response);    // <--- encode
    exit;
}
} else {
    $response['status'] = "DINMOR!";
    $response['token'] = "hey";
    header("HTTP/1.1 200 OK");
    echo json_encode($response);    // <--- encode

    //echo "dinmor";
    //header("HTTP/1.1 400 Bad Request");
}



// setup user in database




?>