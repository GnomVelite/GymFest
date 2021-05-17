<?php
//DET HER DUER IKKE
//header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../../onsite/db/conn.php";
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: https://gymfest.mitstudiekort.dk');
header('Access-Control-Allow-Credentials: true');


$response = [];

$data = json_decode(file_get_contents('php://input'), true);

$email = mysqli_real_escape_string($conn, $data['username']);
$password = mysqli_real_escape_string($conn, $data['password']);
$service = mysqli_real_escape_string($conn, $data['service']);

$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

//$email = "felixfalck@gmail.com";
//$password = "jfr53jks";


$sql = "SELECT id, email, password FROM users WHERE `email` = '".($email)."'";
$fetchedUser = $conn->query($sql);

$fetchPass = "SELECT password FROM users WHERE `email` = '".($email)."'";
$fetchedPass = $conn->query($fetchPass)->fetch_assoc();
$hash = $fetchedPass["password"];

if ($fetchedUser->num_rows > 0 && password_verify($password, $hash) && isset($service)) {
while($row = $fetchedUser -> fetch_assoc()) {
    $id = $row['id'];
    $tokenSql = "SELECT token FROM connectedServices WHERE `user` = '".($id)."' AND `service` = '".($service)."'";
    $fetchedToken = $conn->query($tokenSql);
    if ($fetchedToken->num_rows > 0) {
        while($brow = $fetchedToken -> fetch_assoc()) {
            $bytes = random_bytes(20);
            $token = bin2hex($bytes);
            $updateToken = "UPDATE connectedServices SET `token` = '".$token."' WHERE `user` = '".($id)."' AND `service` = '".($service)."'";
            if ($conn->query($updateToken)) {
                $response['status'] = "OK";
            } else {
                $response['status'] = "ERROR";
            }
        }
    } else {
        $bytes = random_bytes(20);
        $token = bin2hex($bytes);
        $insertToken = "INSERT INTO connectedServices (token, user, service) VALUES ('$token', '$id', '$service')";
        if ($conn->query($insertToken)) {
            $response['status'] = "OK";
        } else {
            $response['status'] = "ERROR";
        }
    }
    $response['token'] = $token;
    //$response['status'] = "OK";

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