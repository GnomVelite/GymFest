<?php

//header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//session_start();
include "../../onsite/db/conn.php";
header("Content-Type: application/json");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://gymfest.mitstudiekort.dk');

$response = [];

$data = json_decode(file_get_contents('php://input'), true);

$token = mysqli_real_escape_string($conn, $data['token']);

// $action = "cfetch";
// $token = "42866c8a889aaf7b25c9d058c0371495cfc016f4";

$fetchPass = "SELECT user FROM connectedServices WHERE `token` = '".($token)."'";
$fetchedPass = $conn->query($fetchPass);

if ($fetchedPass->num_rows > 0) {
    while($row = $fetchedPass -> fetch_assoc()) {

        $userid = $row['user'];
        
        $fetchSchool = "SELECT school FROM cards WHERE `ownerid` = '".($userid)."'";
        $fetchedSchool = $conn->query($fetchSchool);

        if ($fetchedSchool->num_rows > 0) {
            while($srow = $fetchedSchool -> fetch_assoc()) {
                $schoolName = $srow["school"];
            }

            $fetchSchoolId = "SELECT id FROM schools WHERE `name` = '".($schoolName)."'";
            $fetchedSchoolId = $conn->query($fetchSchoolId);

            while($crow = $fetchedSchoolId -> fetch_assoc()) {
                $schoolId = $crow["id"];
            }

            $fetchClasses = "SELECT name FROM classes WHERE `schoolId` = '".($schoolId)."'";
            $fetchedClasses = $conn->query($fetchClasses);
            
            while($ccrow = $fetchedClasses -> fetch_assoc()) {
                array_push($response, $ccrow["name"]);
            }

            //$response['status'] = "OK";
            echo json_encode($response);    // <--- encode
            exit;
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