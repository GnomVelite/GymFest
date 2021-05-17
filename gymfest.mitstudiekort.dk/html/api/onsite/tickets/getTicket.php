<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 
include "../db/conn.php";
include "../db/conndds.php";

$barcode = mysqli_real_escape_string($conn, $_REQUEST['uid']);
$barcode = htmlspecialchars($barcode, ENT_QUOTES, 'UTF-8');

$eventid = mysqli_real_escape_string($conn, $_REQUEST['eid']);
$eventid = htmlspecialchars($eventid, ENT_QUOTES, 'UTF-8');

$return = [];

if (isset($barcode) && isset($eventid)) {

    $owneridsql = "SELECT ownerid, class FROM cards WHERE `barcode` = '".($barcode)."'";
    $ownerResult = $conndds->query($owneridsql);

    if($ownerResult->num_rows > 0) {
        while($srow = $ownerResult -> fetch_assoc()) {
            $studentId = $srow["ownerid"];
            $className = $srow["class"];

            $ticketsql = "SELECT ticketToken, status, type FROM tickets WHERE `userId` = '".($studentId)."' AND `eventId` = '".($eventid)."'";
            $ticketResult = $conn->query($ticketsql);

            if($ticketResult->num_rows > 0) {
                while($brow = $ticketResult -> fetch_assoc()) {
                    if ($brow["type"] == "PERSONAL") {
                        $ticketToken = $brow["ticketToken"];
                        $return["status"] = $brow["status"];
                        $return["ticketToken"] = $ticketToken;
                        $return["className"] = $className;

                        $studentsql = "SELECT firstName, lastName FROM users WHERE `id` = '".($studentId)."'";
                        $studentResult = $conndds->query($studentsql);

                        if($studentResult->num_rows > 0) {
                            while($trow = $studentResult -> fetch_assoc()) {
                                $firstName = $trow["firstName"];
                                $lastName = $trow["lastName"];
                                $return["studentName"] = $firstName." ".$lastName;
                            }
                        }
                    } else {
                        $return["plusone"] = "TRUE";
                    }

                    $ticketupdatesql = "UPDATE tickets SET `status` = 'ARRIVED', `arrivedAt` = CURRENT_TIME() WHERE `userId` = '".($studentId)."' AND `eventId` = '".($eventid)."'";
                    $conn->query($ticketupdatesql);
                }
            } else {
                $return["status"] = "ERROR";
                $return["ticketToken"] = "NONE";            
            }

        }
    } else {
        $return["status"] = "ERROR";
        $return["ticketToken"] = "NONE";   
    }
} else {
    $return["status"] = "ERROR";
    $return["ticketToken"] = "NONE";   
}

echo json_encode($return);

?>