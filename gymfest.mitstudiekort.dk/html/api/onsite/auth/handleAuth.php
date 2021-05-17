<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../db/conn.php";
include "msapi.php";

$action = mysqli_real_escape_string($conn, $_REQUEST['ac']);
$token = mysqli_real_escape_string($conn, $_REQUEST['t']);



if ($action == "login") {
    if (isset($token)) {
        handleLogin($token);
    } else {
        echo "missing token";
    }
} else if ($action == "logout") {
    if (isset($token)) {
        handleLogout();
    } else {
        echo "missing token";
    }
} else {
    echo "unexpected error";
}

function handleLogin($token) {
    $_SESSION["mstoken"] = $token;

    $userClass = new User($_SESSION["mstoken"], 1);
    $userClass->fetch_user();
    $userClass->insert_user();
    $userClass->get_role();
    $_SESSION["userdata"] = $userClass->data;

    if ($userClass->get_role() == "admin") {
        header_remove('Location');
        header('Location: https://gymfest.mitstudiekort.dk/admin');
    }

    if ($userClass->get_role() == "student") {
        header_remove('Location');
        header('Location: https://gymfest.mitstudiekort.dk/student');
    }
    
}

function handleLogout() {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    header('Location: /index.php');
}

?>