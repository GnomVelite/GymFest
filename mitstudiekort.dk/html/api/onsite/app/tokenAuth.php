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

$email = mysqli_real_escape_string($conn, $data['username']);
$password = mysqli_real_escape_string($conn, $data['password']);
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

//$email = "felixfalck@gmail.com";
//$password = "jfr53jks";


$sql = "SELECT id, email, password FROM users WHERE `email` = '".($email)."'";
$fetchedUser = $conn->query($sql);

$fetchPass = "SELECT password FROM users WHERE `email` = '".($email)."'";
$fetchedPass = $conn->query($fetchPass)->fetch_assoc();
$hash = $fetchedPass["password"];

if ($fetchedUser->num_rows > 0 && password_verify($password, $hash)) {
while($row = $fetchedUser -> fetch_assoc()) {
    $bytes = random_bytes(20);
    $token = bin2hex($bytes);
    $insertToken = "UPDATE users SET `appToken` = '".$token."' WHERE `email` = '".($email)."'";
    $conn->query($insertToken);
    $response['token'] = $token;
    $response['status'] = "OK";
    
    header("HTTP/1.1 200 OK");
    echo json_encode($response);    // <--- encode
    exit;
}
} else {
    $response['status'] = "ERROR";
    header("HTTP/1.1 200 OK");
    echo json_encode($response);    // <--- encode

    //echo "dinmor";
    //header("HTTP/1.1 400 Bad Request");
}



// setup user in database




?>