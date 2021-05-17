<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../db/conn.php";

$action = mysqli_real_escape_string($conn, $_REQUEST['action']);

$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
$password = mysqli_real_escape_string($conn, $_REQUEST['pass']);
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

echo $email, $password;

if ($action == "login") {
    if (isset($password) && isset($email)) {
        handleLogin($email, $password, $conn);
    } else {
        echo "missing params";
    }
} else if ($action == "logout") {
    if (isset($password) && isset($email)) {
        handleLogout($sql);
    } else {
        echo "missing params";
    }
} else {
    echo "unexpected error";
}

function handleLogin($email, $password, $conn) {
    echo $email;
    $sql = "SELECT id, email, password FROM users WHERE `email` = '".($email)."'";
    $fetchedUser = $conn->query($sql);

    $fetchPass = "SELECT password FROM users WHERE `email` = '".($email)."'";
    $fetchedPass = $conn->query($fetchPass)->fetch_assoc();
    $hash = $fetchedPass["password"];

    if ($fetchedUser->num_rows > 0 && password_verify($password, $hash)) {
    while($row = $fetchedUser -> fetch_assoc()) {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $row["id"];
        echo "logged in";
        echo $_SESSION['email'];

        $cardsql = "SELECT barcode, school FROM cards WHERE `ownerid` = '".($_SESSION['id'])."' ";
        $result2 = $conn->query($cardsql);
            if ($result2->num_rows > 0) {
            while($trow = $result2 -> fetch_assoc()) {
                $_SESSION["schoolname"] = $trow["school"];
                $_SESSION["barcode"] = $trow["barcode"];
            }
        } else {
            $_SESSION["schoolname"] = "Du har endnu ikke registeret dit studiekort";
            $_SESSION["barcode"] = "Du har endnu ikke registeret dit studiekort";
        }
        
        header_remove('Location');
        header('Location: /dashboard');
        exit;
    }
    } else {
    header_remove('Location');
    header('Location: /login.php?err=1');
    }
}

function handleLogout() {
    echo "logged out";
    session_destroy();
}



// setup user in database




?>