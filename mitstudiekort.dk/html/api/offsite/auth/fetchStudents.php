<?php

//header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();
include "../../onsite/db/conn.php";
header("Content-Type: application/json");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://gymfest.mitstudiekort.dk');

$response = [];

$data = json_decode(file_get_contents('php://input'), true);

$token = mysqli_real_escape_string($conn, $data['token']);

// $action = "cfetch";
//$token = "5e228d3b2f0675c61d07f5b77179e566e671830f";

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

            $fetchStudentsSql  = "SELECT users.firstName, users.lastName, users.id FROM `users` INNER JOIN `cards` ON users.id = cards.ownerid WHERE cards.school LIKE '".($schoolName)."'";
            $fetchedStudents = $conn->query($fetchStudentsSql);

            if ($fetchedStudents->num_rows > 0) {
                $i = 0;
                while($crow = $fetchedStudents -> fetch_assoc()) {
                    $fullName = $crow["firstName"]." ".$crow["lastName"];
                    $response[$i]["id"] = $crow["id"];
                    $response[$i]["name"] = $fullName;
                    $i++;
                }
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