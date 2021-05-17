<?php

//header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//session_start();
include "../../onsite/db/conn.php";
header("Content-Type: application/json");

$response = [];

$data = json_decode(file_get_contents('php://input'), true);

$token = mysqli_real_escape_string($conn, $data['token']);

//$action = "cfetch";
//$token = "bb15af2750d03d5f945d4d95b18d8f3dd7a8b34b";

$fetchPass = "SELECT user FROM connectedServices WHERE `token` = '".($token)."'";
$fetchedPass = $conn->query($fetchPass);

if ($fetchedPass->num_rows > 0) {
    while($row = $fetchedPass -> fetch_assoc()) {

        $userid = $row['user'];
        
        $fetchUser = "SELECT id, firstName, lastName, email  FROM users WHERE `id` = '".($userid)."'";
        $fetchedUser = $conn->query($fetchUser);

        $fetchCard = "SELECT id, barcode, school, expiry, birthdate, pictureid FROM cards WHERE `ownerid` = '".($userid)."'";
        $fetchedCard = $conn->query($fetchCard);

        if ($fetchedCard->num_rows > 0 && $fetchedUser->num_rows > 0) {
            while($urow = $fetchedUser -> fetch_assoc()) {
                $response['id'] = $urow['id'];
                $response['firstName'] = $urow['firstName'];
                $response['lastName'] = $urow['lastName'];
                $response['email'] = $urow['email'];
            }
            while($crow = $fetchedCard -> fetch_assoc()) {
                //$expiryEpoch = $crow['expiry'];
                //$birthdateEpoch = $crow['birthdate'];

                //$expirydt = new DateTime("@$expiryEpoch");
                //$birthdatedt = new DateTime("@$birthdateEpoch");

                //$response['expiry'] = $expirydt->format('d/m/Y');
                //$response['birthdate'] = $birthdatedt->format('d/m/Y');

                $response['expiry'] = $crow['expiry'];
                $response['birthdate'] = $crow['birthdate'];
                $response['barcode'] = $crow['barcode'];
                $response['school'] = $crow['school'];
                $response['pictureid'] = $crow['pictureid'];
                
                //$path = '../../../dashboard/cardstore/users/feli0423.png';
                //$type = pathinfo($path, PATHINFO_EXTENSION);
                //$data = file_get_contents($path);
                //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                //$response['pic64'] = $base64;

                $response['status'] = "OK";

                header("HTTP/1.1 200 OK");
                $utfResponse = array_map("utf8_encode", $response);
                echo json_encode($utfResponse);    // <--- encode
                //var_dump($response);
                //exit;
            }
        } else {
            $response['status'] = "NOCARD";
            header("HTTP/1.1 200 OK");
            echo json_encode($response);    // <--- encode
            exit;
        }
    }
} else {
    $response['status'] = "ERROR";

    header("HTTP/1.1 200 OK");
    echo json_encode($response);    // <--- encode
    exit;
}



// setup user in database




?>