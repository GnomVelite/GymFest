<?php
include "../api/onsite/db/conn.php";
session_start();

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$pictureId = "";

if (!isset($_SESSION['email'])) {
    header_remove('Location');
    header('Location: /login.php');
} else {
    $id = $_SESSION['id'];
    $barcode = $_SESSION["barcode"];
    $school = $_SESSION["schoolname"];
}

$sql = "SELECT firstName, lastName, email, emailVerifiedAt, loginChange, emailDate, passwordKey, emailKey FROM users WHERE `id` = '".($id)."'";
$result = $conn->query($sql);
$noCard = false;
if ($result->num_rows > 0) {
    while($brow = $result -> fetch_assoc()) {
        $firstName = $brow["firstName"];
        $lastName = $brow["lastName"];
        $email = $brow["email"];
        $emailKey = $brow["emailKey"];
        $verifiedDate = $brow["emailVerifiedAt"];
        $loginChange = $brow["loginChange"];
        $date = $brow["emailDate"];
        $passwordkey = $brow["passwordKey"];
        if ($_SESSION['barcode'] == 'Du har endnu ikke registeret dit studiekort') {
            $noCard = true;
        }
    }
}

$emailVerified = "false";
if ($verifiedDate != NULL){
    $emailVerified = "true";
}
$time = time();
 //hvis der er gået mindre end 1 dag & brugeren har foretaget en ændring
 $emailChange = "false";
 $passwordChange = "false";
 if ($time < ($date + (24 * 60 * 60)) && $loginChange != NULL && $passwordkey == NULL){
    $emailChange = "true";
 }  else if ($time < ($date + (24 * 60 * 60)) && $loginChange != NULL && $emailKey == NULL){
    $passwordChange = "true";

    }

$datessql = "SELECT birthdate, expiry, pictureid FROM cards WHERE `ownerid` = '".($id)."'";
$dateresult = $conn->query($datessql);
if ($dateresult->num_rows > 0) {
    while($trow = $dateresult -> fetch_assoc()) {
        $exEpoch = $trow['expiry'];
        $bEpoch = $trow['birthdate'];
        $pictureId = $trow['pictureid'];
        if ($exEpoch != "" && $bEpoch != ""){
            $exTime = new DateTime("@$exEpoch");
            $bTime = new DateTime("@$bEpoch");
        }
        
        if ($pictureId == "") {
            $pid = "https://mitstudiekort.dk/assets/billedPlaceholder.png";
        } else {
            $pid = "https://mitstudiekort.dk".$pictureId;
        }
    }
} else {
    $exTime = "0";
    $bTime = "0";
}
?>

<!doctype html>

<html lang="da">

<head>
    <meta charset="utf-8">

    <title>Mit Studiekort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link type="text/css" rel="stylesheet" href="/vendor/dkfds/css/dkfds-virkdk.css" />
    <link type="text/css" rel="stylesheet" href="/vendor/progressbar.module.css" />
    <link rel="icon" href="/assets/favicon-32.png">
</head>

<body>

    <header class="header">

        <!--1A: Portal header -->
        <div class="portal-header ">
            <div class="container portal-header-inner">
                <a href="index.php" title="Hjem" class="logo alert-leave">
                </a>
                <button class="button button-secondary button-menu-open js-menu-open ml-auto d-print-none"
                    aria-haspopup="menu" title="Åben mobil menu">Menu</button>

                <!-- 1B: Portal header: info + actions-->
                <div class="portal-info">

                    <p class="user">
                        <span class="username weight-semibold">
                            <?php echo $firstName." ".$lastName; ?>
                        </span>
                        <br/>
                        <?php echo $school; ?>
                    </p>
                    <a class="button button-secondary alert-leave d-print-none" href="/api/onsite/user/handleLogout.php">
                        Log af
                    </a>
                </div>
            </div>
        </div>

        <nav class=" nav">
            <!-- collapsible-->
            <button class="button button-secondary button-menu-close js-menu-close" title="Luk mobil menu"><svg
                    class="icon-svg" focusable="false" aria-hidden="true">
                    <use xlink:href="#close"></use>
                </svg>Luk</button>
            <!-- 3: Main navigation-->
            <div class="navbar navbar-primary">
                <!--3A: Main navigation-->
                <div class="navbar-inner container">
                    <ul class="nav-primary">
                        <li>
                            <a href="index.php" class="nav-link" title="Min profil">
                                <span>Mit studiekort</span>
                            </a>
                        </li>
                        <li>
                            <a href="myServices" class="nav-link" title="Eksempler">
                                <span>Mine tjenester</span>
                            </a>
                        </li>
                        <li class="current">
                            <a href="#" class="nav-link" title="Kom godt i gang">
                                <span>Indstillinger</span>
                            </a>
                        </li>
                        <?php if ($_SESSION["barcode"] == 'Du har endnu ikke registeret dit studiekort') { echo "<li><a href='/dashboard/addCard.php'class='nav-link' title='Opret dit studiekort nu!'><span>Opret studiekort</span></a></li>";} ?>
                    </ul>
                </div>
            </div>
            <!-- 3: Main navigation end-->

            <div class="portal-info-mobile">
                <p class="user bold"> <?php echo $firstName." ".$lastName; ?> </p>
                <a href="/api/onsite/user/handleLogout.php" class="button button-secondary button-signout alert-leave">
                    Log af
                </a>
            </div>

            <div class="solution-info-mobile">
                <p class="h5 authority-name">Mit studiekort </p>
                <p>(c) 2021<a href="#" class="icon-link function-link alert-leave"> Kontakt <svg class="icon-svg"
                            aria-hidden="true" focusable="false">
                            <use xlink:href="#open-in-new"></use>
                        </svg></a>
                </p>
            </div>
        </nav> <!-- collapsible nav end-->
    </header>
    <div class="hide-base-svg">
        <svg xmlns="http://www.w3.org/2000/svg"><symbol id="add" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></symbol><symbol id="alert-outline" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2L1 21h22M12 6l7.53 13H4.47M11 10v4h2v-4m-2 6v2h2v-2"/></symbol><symbol id="angle-arrow-down-white" viewBox="0 0 24 24"><path fill="#fff" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6-6-6 1.41-1.42z"/></symbol><symbol id="angle-arrow-down" viewBox="0 0 24 24"><path d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6-6-6 1.41-1.42z"/></symbol><symbol id="angle-arrow-up" viewBox="0 0 24 24"><path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6 1.41 1.41z"/></symbol><symbol id="arrow-left" viewBox="0 0 24 24"><path d="M20 11v2H8l5.5 5.5-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5 8 11h12z"/></symbol><symbol id="arrow-right" viewBox="0 0 24 24"><path d="M4 11v2h12l-5.5 5.5 1.42 1.42L19.84 12l-7.92-7.92L10.5 5.5 16 11H4z"/></symbol><symbol id="book-open" viewBox="0 0 24 24"><path d="M13 12h7v1.5h-7m0-4h7V11h-7m0 3.5h7V16h-7m8-12H3a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2m0 15h-9V6h9"/></symbol><symbol id="calendar" viewBox="0 0 24 24"><path d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-1V1m-1 11h-5v5h5v-5z"/></symbol><symbol id="card-text-outline" viewBox="0 0 24 24"><path d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z" /></symbol><symbol id="cash-multiple" viewBox="0 0 24 24"><path d="M5 6h18v12H5V6m9 3a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3M9 8a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2v-4a2 2 0 0 1-2-2H9m-8 2h2v10h16v2H1V10z"/></symbol><symbol id="check-box-checked" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path fill="#1A1A1A" d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm12.293 4.293l-6.921 6.921-3.665-3.664-1.414 1.414 5.079 5.079 8.335-8.336-1.414-1.414z"/></g></symbol><symbol id="check-box-disabled" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><rect width="16" height="16" x="4" y="4" fill="#F5F5F5" stroke="#BFBFBF" stroke-width="2" rx="2"/></g></symbol><symbol id="check-box-focus" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path fill="#FEBB30" d="M0 0h24v24H0V0z"/><rect width="16" height="16" x="4" y="4" fill="#FFF" stroke="#1A1A1A" stroke-width="2" rx="2"/></g></symbol><symbol id="check-box-unchecked" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><rect width="16" height="16" x="4" y="4" fill="#FFF" stroke="#1A1A1A" stroke-width="2" rx="2"/></g></symbol><symbol id="check-circle-outline" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10A10 10 0 0 1 2 12 10 10 0 0 1 12 2m0 2a8 8 0 0 0-8 8 8 8 0 0 0 8 8 8 8 0 0 0 8-8 8 8 0 0 0-8-8m-1 12.5L6.5 12l1.41-1.41L11 13.67l5.59-5.58L18 9.5l-7 7z"/></symbol><symbol id="check" viewBox="0 0 24 24"><path d="M21 7L9 19l-5.5-5.5 1.41-1.41L9 16.17 19.59 5.59 21 7z"/></symbol><symbol id="checkbox-blank-outline" viewBox="0 0 24 24"><path d="M19 3H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 2v14H5V5h14z"/></symbol><symbol id="checkbox-marked" viewBox="0 0 24 24"><path d="M10 17l-5-5 1.41-1.42L10 14.17l7.59-7.59L19 8m0-5H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/></symbol><symbol id="chevron-left" viewBox="0 0 24 24"><path d="M15.41 16.58L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.42z"/></symbol><symbol id="chevron-right" viewBox="0 0 24 24"><path d="M8.59 16.58L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.42z"/></symbol><symbol id="close-circle-outline" viewBox="0 0 24 24"><path d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z"/></symbol><symbol id="close-circle" viewBox="0 0 24 24"><path d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z"/></symbol><symbol id="close" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></symbol><symbol id="delete-outline" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"/><path fill="none" d="M0 0h24v24H0V0z"/></symbol><symbol id="delete" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"/><path fill="none" d="M0 0h24v24H0V0z"/></symbol><symbol id="dots-vertical" viewBox="0 0 24 24"><path d="M12 16a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2z"/></symbol><symbol id="download" viewBox="0 0 24 24"><path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/><path fill="none" d="M0 0h24v24H0z"/></symbol><symbol id="error" viewBox="0 0 24 24"><path d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z"/></symbol><symbol id="email" viewBox="0 0 24 24"><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/></symbol><symbol id="feedback" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17l-.59.59-.58.58V4h16v12zm-9-4h2v2h-2zm0-6h2v4h-2z"/></symbol><symbol id="file-document-box" viewBox="0 0 24 24"><path d="M5 3c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h14c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2H5m0 2h14v14H5V5m2 2v2h10V7H7m0 4v2h10v-2H7m0 4v2h7v-2H7z"/></symbol><symbol id="file-pdf-outline" viewBox="0 0 24 24"><path d="M14,2L20,8V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2H14M18,20V9H13V4H6V20H18M10.92,12.31C10.68,11.54 10.15,9.08 11.55,9.04C12.95,9 12.03,12.16 12.03,12.16C12.42,13.65 14.05,14.72 14.05,14.72C14.55,14.57 17.4,14.24 17,15.72C16.57,17.2 13.5,15.81 13.5,15.81C11.55,15.95 10.09,16.47 10.09,16.47C8.96,18.58 7.64,19.5 7.1,18.61C6.43,17.5 9.23,16.07 9.23,16.07C10.68,13.72 10.9,12.35 10.92,12.31M11.57,13.15C11.17,14.45 10.37,15.84 10.37,15.84C11.22,15.5 13.08,15.11 13.08,15.11C11.94,14.11 11.59,13.16 11.57,13.15M14.71,15.32C14.71,15.32 16.46,15.97 16.5,15.71C16.57,15.44 15.17,15.2 14.71,15.32M9.05,16.81C8.28,17.11 7.54,18.39 7.72,18.39C7.9,18.4 8.63,17.79 9.05,16.81M11.57,11.26C11.57,11.21 12,9.58 11.57,9.53C11.27,9.5 11.56,11.22 11.57,11.26Z"></path></symbol><symbol id="file" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><g><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></g></symbol><symbol id="folder-multiple" viewBox="0 0 24 24"><path d="M22 4a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h6l2 2h8M2 6v14h18v2H2a2 2 0 0 1-2-2V6h2m4 0v10h16V6H6z"/></symbol><symbol id="help-circle" viewBox="0 0 24 24"><path d="M11 18h2v-2h-2v2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-14a4 4 0 0 0-4 4h2a2 2 0 0 1 2-2 2 2 0 0 1 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5a4 4 0 0 0-4-4z"/></symbol><symbol id="info" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M11 7h2v2h-2zM11 11h2v6h-2z"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></symbol><symbol id="language" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 0 0-1.38-3.56A8.03 8.03 0 0 1 18.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 0 1 5.08 16zm2.95-8H5.08a7.987 7.987 0 0 1 4.33-3.56A15.65 15.65 0 0 0 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></symbol><symbol id="magnify" viewBox="0 0 24 24"><path d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 0 1 9.5 16 6.5 6.5 0 0 1 3 9.5 6.5 6.5 0 0 1 9.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14 14 12 14 9.5 12 5 9.5 5z"/></symbol><symbol id="menu-down" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5H7z"/></symbol><symbol id="menu-left" viewBox="0 0 24 24"><path d="M14 7l-5 5 5 5V7z"/></symbol><symbol id="menu-right" viewBox="0 0 24 24"><path d="M10 17l5-5-5-5v10z"/></symbol><symbol id="menu-up" viewBox="0 0 24 24"><path d="M7 15l5-5 5 5H7z"/></symbol><symbol id="message" viewBox="0 0 24 24"><path d="M20 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h16M4 4v13.17L5.17 16H20V4H4m2 3h12v2H6V7m0 4h9v2H6v-2z"/></symbol><symbol id="minus" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></symbol><symbol id="open-in-new" viewBox="0 0 24 24"><path d="M14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3m-2 16H5V5h7V3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7h-2v7z"/></symbol><symbol id="palette" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M12 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.04 10 9c0 3.31-2.69 6-6 6h-1.77c-.28 0-.5.22-.5.5 0 .12.05.23.13.33.41.47.64 1.06.64 1.67 0 1.38-1.12 2.5-2.5 2.5zm0-18c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7z"/><circle cx="6.5" cy="11.5" r="1.5"/><circle cx="9.5" cy="7.5" r="1.5"/><circle cx="14.5" cy="7.5" r="1.5"/><circle cx="17.5" cy="11.5" r="1.5"/></symbol><symbol id="pencil" viewBox="0 0 24 24"><path xmlns="http://www.w3.org/2000/svg" d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"/></symbol><symbol id="plus" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></symbol><symbol id="printer" viewBox="0 0 24 24"><path xmlns="http://www.w3.org/2000/svg" d="M19 8h-1V3H6v5H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zM8 5h8v3H8V5zm8 12v2H8v-4h8v2zm2-2v-2H6v2H4v-4c0-.55.45-1 1-1h14c.55 0 1 .45 1 1v4h-2z"/></symbol><symbol id="radio-disabled" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><circle cx="12" cy="12" r="8" fill="#F5F5F5" stroke="#BFBFBF" stroke-width="2"/></g></symbol><symbol id="refresh" viewBox="0 0 24 24"><path d="M17.65 6.35A7.958 7.958 0 0 0 12 4a8 8 0 0 0-8 8 8 8 0 0 0 8 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18a6 6 0 0 1-6-6 6 6 0 0 1 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></symbol><symbol id="save" viewBox="0 0 24 24"><path xmlns="http://www.w3.org/2000/svg" d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"/></symbol><symbol id="settings" viewBox="0 0 24 24"><path d="M19.43 12.97l2.11 1.66c.19.15.24.42.12.64l-2 3.46c-.12.22-.39.3-.61.22l-2.49-1.01c-.52.4-1.06.73-1.69.99l-.37 2.65c-.04.24-.25.42-.5.42h-4c-.25 0-.46-.18-.5-.42l-.37-2.65c-.63-.25-1.17-.59-1.69-.99l-2.49 1.01c-.22.08-.49 0-.61-.22l-2-3.46a.493.493 0 0 1 .12-.64l2.11-1.66L4.5 12l.07-1-2.11-1.63a.493.493 0 0 1-.12-.64l2-3.46c.12-.22.39-.31.61-.22l2.49 1c.52-.39 1.06-.73 1.69-.98l.37-2.65c.04-.24.25-.42.5-.42h4c.25 0 .46.18.5.42l.37 2.65c.63.25 1.17.59 1.69.98l2.49-1c.22-.09.49 0 .61.22l2 3.46c.12.22.07.49-.12.64L19.43 11l.07 1-.07.97M6.5 12c0 .58.09 1.13.25 1.66l-2.07 1.7.75 1.3 2.52-.94c.74.81 1.73 1.4 2.85 1.65l.44 2.63h1.5l.44-2.63c1.12-.24 2.12-.83 2.87-1.64l2.51.94.75-1.3-2.07-1.7c.17-.53.26-1.09.26-1.67 0-.57-.09-1.13-.25-1.65l2.06-1.69-.75-1.3-2.5.93a5.526 5.526 0 0 0-2.87-1.66L12.75 4h-1.5l-.44 2.63c-1.12.25-2.12.84-2.87 1.66l-2.5-.94-.75 1.3 2.06 1.7c-.16.52-.25 1.08-.25 1.65M12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5m0 2a1.5 1.5 0 0 0-1.5 1.5 1.5 1.5 0 0 0 1.5 1.5 1.5 1.5 0 0 0 1.5-1.5 1.5 1.5 0 0 0-1.5-1.5z"/></symbol><symbol id="sort-ascending" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path fill="#1A1A1A" d="M6 13l6 6 6-6z"/><path stroke="#1A1A1A" d="M16.793 10.5L12 5.707 7.207 10.5h9.586z"/></g></symbol><symbol id="sort-descending" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path stroke="#1A1A1A" d="M7.207 13.5L12 18.293l4.793-4.793H7.207z"/><path fill="#1A1A1A" d="M18 11l-6-6-6 6z"/></g></symbol><symbol id="sort-none" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path d="M7.207 13.5L12 18.293l4.793-4.793H7.207zm9.586-3L12 5.707 7.207 10.5h9.586z" stroke="#1A1A1A"/></g></symbol><symbol id="success" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10A10 10 0 0 1 2 12 10 10 0 0 1 12 2m0 2a8 8 0 0 0-8 8 8 8 0 0 0 8 8 8 8 0 0 0 8-8 8 8 0 0 0-8-8m-1 12.5L6.5 12l1.41-1.41L11 13.67l5.59-5.58L18 9.5l-7 7z"/></symbol><symbol id="warning" viewBox="0 0 24 24"><path d="M12 2L1 21h22M12 6l7.53 13H4.47M11 10v4h2v-4m-2 6v2h2v-2"/></symbol></svg>
    </div>


    <main class="container page-container" style="padding-top: 0;">

        <div class="row justify-content-center">
            <div class="col-8">
                <div id="info-alert">
                    <?php if( $noCard ){echo '<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Du har ikke noget kort</p><p class="alert-text"> Vi kan se du ikke har noget kort tilknyttet Mit Studiekort,  <a href="https://www.mitstudiekort.dk/dashboard/addCard.php">tryk her</a> for at fuldføre din oprettelse samt knytte dit fysiske studiekort til Mit Studiekort. </p></div></div>'; } ?>
                </div>
                <h1 class="h1 mt-6 mt-md-7">Dine oplysninger</h1>
                <div class="hej">
                    <table class="table table--zebra table--compact table--responsive-headers">
                        <tbody>
                            <tr>
                                <th class="w-percent-md-30">Navn</th>
                                <td><?php echo $firstName." ".$lastName; ?></td>
                                <td class="align-text-md-right"></td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Studiekort ID</th>
                                <td><?php echo $barcode?></td>
                                <td class="align-text-md-right"></td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Studiekort udløbsdato</th>
                                <td><?php if ($exTime != 0){ echo $exTime->format('m/d-Y'); } ?></td>
                                <td class="align-text-md-right"></td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Udannelsesinstitution</th>
                                <td> <?php echo $school; ?></td>
                                <td class="align-text-md-right"></td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Fødslesdato</th>
                                <td><?php if ($bTime != 0){ echo $bTime->format('m/d-Y'); } ?></td>
                                <td class="align-text-md-right"></td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Email</th>
                                <td><?php echo $email?></td>
                                <td class="align-text-md-right" id="email-edit-button">
                                <button class="button button-unstyled"  data-module="modal"  data-target="edit-email"><svg class="icon-svg" focusable="false" aria-hidden="true" ><use xlink:href="#pencil"></use></svg></button>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-percent-md-30">Kodeord</th>
                                <td>********</td>
                                <td class="align-text-md-right" id="password-edit-button">
                                <button class="button button-unstyled"  data-module="modal"  data-target="edit-password"><svg class="icon-svg" focusable="false" aria-hidden="true" ><use xlink:href="#pencil"></use></svg></button>
                                </td>
                            </tr>
                      
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12" >
                <h4 style="text-align: center !important; max-width: 100%;">Studiekort foto</h4>
                <div class="imgContainer" style="text-align:center;">             
                    <img  <?php if ($pictureId == "") {  echo 'class="js-tooltip button-unstyled" data-tooltip="Vi har ikke et billede af dig endnu, opret dit kort for at få et ind." data-tooltip-position="bottom" style ="width:100%; max-width:350px;" src="https://mitstudiekort.dk/assets/billedPlaceholder.png" alt="Profile picture"'; } else { echo 'style ="width:100%; max-width:275px;  border-radius:3%" src="'.$pid.'" alt="Profile picture"';} ?> >
                </div>
            </div>
        </div>

    <div class="fds-modal" id="edit-email" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-email-title">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-email-title">
                    Rediger Email
                </h2>
                <button class="modal-close button button-unstyled"
                    aria-label="Luk"
                    data-modal-close><svg class="icon-svg" focusable="false" aria-hidden="true"><use xlink:href="#close"></use></svg></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group" id="email-form">
                            <label class="form-label" id="email-label" for="new-email">Indtast din nye email</label>
                            <input class="form-input mb-5" id="email-input" value="<?php echo $email?>" name="email" style="max-width: none;"type="text">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button button-primary" id = "save-email-button" onclick="updateEmail();">Gem</button>
                <button class="button button-secondary" onclick="resetEmailModal();" data-modal-close> Luk</button>
            </div>
        </div>
    </div>
    <div class="fds-modal" id="edit-password" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-password-title">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-password-title">
                    Rediger kodeord
                </h2>
                <button class="modal-close button button-unstyled" onclick="resetPasswordModal();" aria-label="Luk" data-modal-close><svg class="icon-svg" focusable="false" aria-hidden="true"><use xlink:href="#close"></use></svg></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group" id="password-form">
                            <label class="form-label" id="old-password-label" for="old-password">Indtast dit gamle kodeord</label>
                            <input class="form-input mb-5" id="old-password-input" value="" name="old-password" style="max-width: none;"type="text">
                            <label class="form-label" id="new-password-label" for="new-password">Indtast dit ønskede kodeord</label>
                            <input class="form-input mb-5" id="new-password-input" value="" name="new-password" style="max-width: none;"type="text">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button button-primary" id = "save-password-button" onclick="updatePassword();">Gem</button>
                <button class="button button-secondary" onclick="resetPasswordModal();" data-modal-close> Luk</button>
            </div>
        </div>
    </div>
    <div id="verify-alert"></div>
    </main>
   

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src='/vendor/dkfds/js/dkfds.js'></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Handler when the DOM is fully loaded
            DKFDS.init();
            VerifyLoginChange();
        });
    </script>
     <script>
    function updateEmail(){
      var xhttp = new XMLHttpRequest();
      var url = '/api/onsite/edits/handleEmailEdit.php';
      var xhttpError = "";

      xhttp.open("POST", url, true);
      xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         output = this.responseText;
         console.log(output);
            if (output.trim() == "emailValid"){
                $("#save-email-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                VerifyNewEmail();
            } else if (output.trim() == "usedEmail"){
                $("#save-email-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {                    
                   $("#email-form").html('<div class="form-group form-error"> <label class="form-label " for="Edit-email">  Indtast din nye email </label>  <span class="form-error-message" id="email-label"> <span class="sr-only">Fejl:</span> Den indtastede email er allerede i brug</span><input class="form-input mb-5" required="" id="email-input" value="<?php echo $email?>" name="form-error" type="text" aria-invalid="true" aria-describedby="email edit error" /> </div>  ');
                    $("#save-email-button").html('gem');
                }, 700);
                
                
            }else if (output.trim() == "noEmail"){
                $("#save-email-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {    
                $("#email-form").html('<div class="form-group form-error"><label class="form-label " for="Edit-email"> Indtast din nye email </label>  <span class="form-error-message" id="email-label"> <span class="sr-only">Fejl:</span>Husk at en email indeholder et @ og et . </span><input class="form-input mb-5" required="" id="email-input" value="<?php echo $email?>" name="form-error" type="text" aria-invalid="true" aria-describedby="email edit error" /> </div>  ');
                $("#save-email-button").html('gem');
            }, 700);
            } else{
                $("#save-email-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {    
                $("#email-form").html('<div class="form-group form-error"> <label class="form-label " for="Edit-email">  Indtast din nye email</label>  <span class="form-error-message" id="email-label"> <span class="sr-only">Fejl:</span>Vi beklager, der er sket en fejl. </span><input class="form-input mb-5" required="" id="email-input" value="<?php echo $email?>" name="form-error" type="text" aria-invalid="true" aria-describedby="email edit error" /> </div>');
                $("#save-email-button").html('gem');
            }, 700);
            }
        }
      }
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("newEmail=" + document.getElementById("email-input").value);
    }

    function resetEmailModal(){
        $("#email-form").html('<div class="form-group" id="email-form"> <label class="form-label" id="email-label" for="new-email"> Indtast din nye email  </label>   <input class="form-input mb-5" id="email-input" value="<?php echo $email?>" name="email" style="max-width: none;" type="text"> </div>');
        $("#save-email-button").html('gem');
    }
</script>
<script>
    function updatePassword(){
      var xhttp = new XMLHttpRequest();
      var url = '/api/onsite/edits/handlePasswordEdit.php';
      var xhttpError = "";

      xhttp.open("POST", url, true);
      xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         output = this.responseText;
         console.log(output);
            if (output.trim() == "passwordValid"){
                $("#save-password-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                VerifyNewPassword();
            } else if (output.trim() == "invalidPassword"){
                $("#save-password-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {                    
                   $("#password-form").html('<div class="form-group form-error"><label class="form-label " for="Edit-password">Rediger kodeord</label><span class="form-error-message" id="password-label"> <span class="sr-only">Fejl:</span>Du skrev dit gamle kodeord forkert.</span><input class="form-input mb-5" required="" id="old-password-input" value="" name="old-password-input" type="text" aria-invalid="true" aria-describedby="password edit error"/></div><label class="form-label" id="new-password-label" for="new-password">Indtast dit ønskede kodeord</label><input class="form-input mb-5" id="new-password-input" value="" name="new-password" style="max-width: none;"type="text">');
                    $("#save-password-button").html('gem');
                }, 700);
                
                
            }else if (output.trim() == "tooShort"){
                $("#save-password-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {                    
                    $("#password-form").html('<label class="form-label" id="old-password-label" for="old-password">Indtast dit gamle kodeord</label><input class="form-input mb-5" id="old-password-input" value="" name="old-password" style="max-width: none;"type="text"><div class="form-group form-error"><span class="form-error-message" id="password-label"> <span class="sr-only">Fejl:</span>Dit nye kodeord skal være 8 karakterer langt</span><input class="form-input mb-5" required="" id="new-password-input" value="" name="new-password-input" type="text" aria-invalid="true" aria-describedby="password edit error"/></div>');
                    $("#save-password-button").html('gem');
                }, 700);
            } else{
                $("#save-password-button").html('<div style = "margin-inline-start: 3px; margin-inline-end: 30px; left: 45%; transform: translateX(-50%); font-size:6px;" class="spinner-white"> </div>');
                setTimeout(function () {                    
                   $("#password-form").html('<div class="form-group form-error"><label class="form-label " for="Edit-password">Rediger kodeord</label><span class="form-error-message" id="password-label"> <span class="sr-only">Fejl:</span>Noget gik galt prøv igen</span><input class="form-input mb-5" required="" id="old-password-input" value="" name="old-password-input" type="text" aria-invalid="true" aria-describedby="password edit error"/><label class="form-label" id="new-password-label" for="new-password">Indtast dit ønskede kodeord</label><input class="form-input mb-5" id="new-password-input" value="" name="new-password" style="max-width: none;"type="text"></div>');
                   $("#save-password-button").html('gem');
                }, 700);
            }
        }
      }
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("password=" + document.getElementById("old-password-input").value+"&newPassword=" + document.getElementById("new-password-input").value);
    }

    function resetPasswordModal(){
        $("#password-form").html('<div class="form-group" id="password-form"><label class="form-label" id="old-password-label" for="old-password">Indtast dit gamle kodeord</label><input class="form-input mb-5" id="old-password-input" value="" name="old-password" style="max-width: none;"type="text"><label class="form-label" id="new-password-label" for="new-password">Indtast dit ønskede kodeord</label><input class="form-input mb-5" id="new-password-input" value="" name="new-password" style="max-width: none;"type="text"></div>');
        $("#save-password-button").html('gem');
    }
</script>
<script>
     function VerifyNewPassword(){
     var xhttp = new XMLHttpRequest();
     var url = '/api/onsite/user/handlePasswordVerification.php'
     var xhttpError = "";
     console.log(url);
     xhttp.open("POST", url, true);
     xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            output = this.responseText;

        if (output.trim() == "emailSent"){
            console.log("email has been sent");
            setTimeout(function () {
                resetPasswordModal();
                let modal = new DKFDS.Modal(document.getElementById('edit-password'));
                modal.hide();
                $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information"><div class="alert-body"><p class="alert-heading">Dit kodeord er ikke opdateret endnu</p><p class="alert-text">Vi har sendt en mail afsted til din email, tryk på linket i denne mail for at gennemføre ændringen i dit kodeord. </p></div>');
            }, 700);

            } else {
                setTimeout(function () {                    
                   $("#password-form").html('<div class="form-group form-error"><label class="form-label " for="Edit-password">Rediger kodeord</label><span class="form-error-message" id="password-label"> <span class="sr-only">Fejl:</span>Noget gik galt prøv igen</span><input class="form-input mb-5" required="" id="old-password-input" value="" name="old-password-input" type="text" aria-invalid="true" aria-describedby="password edit error"/><label class="form-label" id="new-password-label" for="new-password">Indtast dit ønskede kodeord</label><input class="form-input mb-5" id="new-password-input" value="" name="new-password" style="max-width: none;"type="text"></div>');
                   $("#save-password-button").html('gem');
                }, 700);
            }
        } 
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
</script>
<script>
     function VerifyNewEmail(){
     var xhttp = new XMLHttpRequest();
     var url = '/api/onsite/user/handleEmailVerification.php'
     var xhttpError = "";
     console.log(url);
     xhttp.open("POST", url, true);
     xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            output = this.responseText;

        if (output.trim() == "emailSent"){
            console.log("email has been sent");
            setTimeout(function () {
                resetEmailModal();
                let modal = new DKFDS.Modal(document.getElementById('edit-email'));
                modal.hide();
                $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information"><div class="alert-body"><p class="alert-heading">Din email er ikke opdateret endnu</p><p class="alert-text">Vi har sendt en mail afsted til din nye email, tryk på linket i denne mail for at aktiverer din nye email. </p></div>');
            }, 700);

            } else {
                    setTimeout(function () {    
                        $("#email-form").html('<div class="form-group form-error">     <label class="form-label " for="Edit-email">  Indtast din nye email</label>  <span class="form-error-message" id="email-label"> <span class="sr-only">Fejl:</span>Vi beklager, der er sket en fejl. </span><input class="form-input mb-5" required="" id="email-input" value="<?php echo $email?>" name="form-error" type="text" aria-invalid="true" aria-describedby="email edit error" /> </div>');
                        $("#save-email-button").html('gem');
                    }, 700);
            }
        } 
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
</script>

<script>
function VerifyLoginChange(){
    var emailVerified = <?php echo $emailVerified ?>;
    var emailChange = <?php echo $emailChange ?>;
    var passwordChange =  <?php echo $passwordChange ?>;
    if (!emailVerified || emailChange || passwordChange){
        if (!emailVerified){
            $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Verificer din email</p><p class="alert-text">Vi kan se din email ikke er verifceret endnu, <a onClick="sendEmail()">tryk her</a> for at sende en ny verifications email til din emailkonto: <?php echo $email ?>. Du har ikke mulighed for at ændre dine andre oplysninger før du har verificeret din konto.</p></div>');
            $("#password-edit-button").html('');
            $("#email-edit-button").html('');
        } else if (emailChange){
            $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Verificer din email</p><p class="alert-text">Vi kan se du har forsøgt at ændre din email, denne ændring træder ikke i kraft før den bliver verificeret.   <a onClick="sendEmail()">Tryk her</a> for at sende en ny verifications email til din ændrede emailkonto: <?php echo $loginChange ?>. </p></div>');  
        } else{
            $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Dit kodeord er ikke ændret endnu</p><p class="alert-text">Vi kan se du har forsøgt at ændre dit kodeord, denne ændring træder ikke i kraft før den bliver verificeret gennem din email. <a onClick="sendEmail()">Tryk her</a> for at sende en ny verifications email til din emailkonto: <?php echo $email ?>. </p></div>');  
        }
    }
}
function sendEmail(){
    var emailVerified = <?php echo $emailVerified ?>;
    var emailChange = <?php echo $emailChange ?>;
    var passwordChange =  <?php echo $passwordChange ?>;
    var xhttp = new XMLHttpRequest();
    var url = '/api/onsite/user/handleEmailVerification.php'
    if (passwordChange){
    var url = '/api/onsite/user/handleEmailChange.php'
    }
     var xhttpError = "";
     console.log(url);
     xhttp.open("POST", url, true);
     xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                output = this.responseText;
                console.log(output);
            if (output.trim() == "emailSent"){
                if (!emailVerified){
                    $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Email sendt afsted!</p><p class="alert-text">En mail er sendt afsted til din email konto, tryk på linket for at verificerer at <?php echo $email ?> er din email.</p></div>');
                }else if (emailChange){
                    $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Email sendt afsted!</p><p class="alert-text">En mail er sendt afsted til din email konto, tryk på linket for at verificerer at <?php echo $loginChange ?> er din email.</p></div>');
                } else {
                    $("#info-alert").html('<div class="alert alert-info alert--show-icon" role="alert" aria-atomic="true" aria-label="Beskedbox der viser information" ><div class="alert-body"><p class="alert-heading">Email sendt afsted!</p><p class="alert-text">En mail er sendt afsted til din email konto, tryk på linket for at gennemfører ændringen af dit kodeord.</p></div>');
                }
            }
        }
     }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
</script>
</body>

</html>