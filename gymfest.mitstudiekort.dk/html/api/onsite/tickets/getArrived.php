<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";
include "../db/conndds.php";

$eventid = mysqli_real_escape_string($conn, $_REQUEST['eid']);
$eventid = htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8');

$scanToken = mysqli_real_escape_string($conn, $_REQUEST['t']);
$scanToken = htmlspecialchars($scanToken, ENT_QUOTES, 'UTF-8');

$return = [];
$authed = false;

$scanTokenSql = "SELECT id FROM events WHERE `scanToken` = '".($scanToken)."'";
$scanTokenResult = $conn->query($scanTokenSql);

if($scanTokenResult->num_rows > 0) {
    while($crow = $scanTokenResult -> fetch_assoc()) {
        $fetchedId = $crow["id"];
        if ($fetchedId == $eventid) {
            $authed = true;
        }
    }
}

if (isset($eventid) && $authed) {
    $ticketsql = "SELECT userId, type FROM tickets WHERE `status` = 'ARRIVED' AND `eventId` = '".($eventid)."'";
    $ticketResult = $conn->query($ticketsql);

    if($ticketResult->num_rows > 0) {
        $i = 0;
        while($brow = $ticketResult -> fetch_assoc()) {
            $userId = $brow["userId"];
            $ticketType = $brow["type"];

            $owneridsql = "SELECT class FROM cards WHERE `ownerId` = '".($userId)."'";
            $ownerResult = $conndds->query($owneridsql);
        
            if($ownerResult->num_rows > 0) {
                while($srow = $ownerResult -> fetch_assoc()) {
                    $className = $srow["class"];
                }
            }
            if ($ticketType == "PLUSONE") {
                $return[$i]["className"] = "PLUS ONE";
            } else {
                $return[$i]["className"] = $className;
            }

            $studentsql = "SELECT firstName, lastName FROM users WHERE `id` = '".($userId)."'";
            $studentResult = $conndds->query($studentsql);

            if($studentResult->num_rows > 0) {
                while($trow = $studentResult -> fetch_assoc()) {
                    $firstName = $trow["firstName"];
                    $lastName = $trow["lastName"];
                    if ($ticketType == "PLUSONE") {
                        $return[$i]["studentName"] = $firstName." ".$lastName." - PLUS ONE";
                    } else {
                        $return[$i]["studentName"] = $firstName." ".$lastName;
                    }
                }
            }

            $i++;
        }
    } else {
        $return["status"] = "ERROR";
    }

}

echo json_encode($return);

?>