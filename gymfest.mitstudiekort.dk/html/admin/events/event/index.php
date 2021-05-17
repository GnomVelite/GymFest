<?php
session_start();
include "../../../api/onsite/auth/msapi.php";
include "../../../api/onsite/db/conn.php";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['mstoken'])) {
    header_remove('Location');
    header('Location: /');
}

if (isset($_SESSION["userdata"])) {
    $user = $_SESSION["userdata"];
} else {
  $user = new User($_SESSION["mstoken"], 1);
  $user->fetch_user();
}

//Data fra URL
$eventID =  mysqli_real_escape_string($conn, $_REQUEST['id']);


$redirect = false;

//Verificer integritet af data
if ($eventID != null) {
    $sql = "SELECT * FROM `events` WHERE ownerId = '".($user->id)."' AND events.id = '".($eventID)."'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($brow = $result -> fetch_assoc()) {
      $eventOwner = $brow["ownerId"];
      if ($eventOwner == $user->id){
        $eventName = $brow["name"];
        $startDate = $brow["startDate"];
        $endDate = $brow["endDate"];
        $publishDate = $brow["publishedAt"];
        $price = $brow["price"];
        $tickets = $brow["tickets"];
        $description = $brow["description"];
        $lat = $brow["lat"];
        $lng = $brow["lng"];
        $scanToken = $brow["scanToken"];
      } else{
        $redirect = true;
      }
    }
  } else{
    $redirect = true;
  }
} else {
  $redirect = true;
}

if ($redirect){
  header_remove('Location');
  header('Location: /admin/events');
}

?>
<!doctype html>

<!-- GYMFEST -> ADMIN -> EVENTS -> Event -> id -->

<html lang="da">

<head>
  <meta charset="utf-8">

  <title>GymFest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link type="text/css" rel="stylesheet" href="/vendor/dkfds/css/dkfds-virkdk.css" />
  <link rel="apple-touch-icon" sizes="57x57" href="/assets/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/assets/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/assets/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/assets/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/assets/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
  <link rel="manifest" href="/assets/manifest.json">
  <link type="text/css" rel="stylesheet" href="event.module.css" />
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/assets/ms-icon-144x144.png">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <meta name="theme-color" content="#ffffff">
  <!-- <link rel="icon" href="/assets/favicon-32.png"> -->
  <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
    </style>
</head>

<body>

  <header class="header">

    <!--1A: Portal header -->
    <div class="portal-header ">
      <div class="container portal-header-inner">
        <a href="#" title="Hjem" class="logo alert-leave">
        </a>
        <h4>Admin</h4>
        <button class="button button-secondary button-menu-open js-menu-open ml-auto d-print-none" aria-haspopup="menu"
          title="Åben mobil menu">Menu</button>

        <!-- 1B: Portal header: info + actions-->
        <div class="portal-info">

          <p class="user">
            <span class="username weight-semibold">
              <?php echo $user->firstName." ".$user->lastName; ?>
            </span>
            <br />
            <?php echo $user->school ?>
          </p>
          <a class="button button-primary alert-leave d-print-none" href="/student/index.php">
            Gå til Student
          </a>
          <a class="button button-secondary alert-leave d-print-none" href="/api/onsite/auth/handleAuth?t=<?php echo $_SESSION['mstoken']?>&ac=logout">
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
                <a href="/admin/" class="nav-link" title="Min profil">
                  <span>Overblik</span>
                </a>
              </li>
              <li>
                <a href="/admin/opret" class="nav-link" title="Opret begivenhed">
                  <span>Opret begivenhed</span>
                </a>
              </li>
              <li class="current">
                <a href="/admin/events" class="nav-link" title="Fester">
                  <span>Planlagte begivenheder</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- 3: Main navigation end-->
        <div class="portal-info-mobile">
        <p class="user">
            <span class="username weight-semibold">
              <?php echo $user->firstName." ".$user->lastName; ?>
            </span>
            <br />
            <?php echo $user->school ?>
          </p>
          <a class="button button-primary alert-leave d-print-none" style="width:auto;"
          href="/student/">
          Gå til Student
        </a>
          <a href="/api/onsite/auth/handleAuth?t=<?php echo $_SESSION['mstoken']?>&ac=logout" class="button button-secondary button-signout alert-leave">
            Log af
          </a>
        </div>

        <div class="solution-info-mobile">
          <p class="h5 authority-name">GymFest 1.0.1b</p>
          <p>(c) 2021 · <a href="#" class="icon-link function-link alert-leave">Kontakt<svg class="icon-svg"
                aria-hidden="true" focusable="false">
                <use xlink:href="#open-in-new"></use>
              </svg></a>
          </p>
        </div>

    </nav> <!-- collapsible nav end-->
  </header>

  <div class="hide-base-svg">
    <svg xmlns="http://www.w3.org/2000/svg">
      <symbol id="add" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none" />
        <path
          d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
      </symbol>
      <symbol id="alert-outline" viewBox="0 0 24 24">
        <path fill="currentColor" d="M12 2L1 21h22M12 6l7.53 13H4.47M11 10v4h2v-4m-2 6v2h2v-2" />
      </symbol>
      <symbol id="angle-arrow-down-white" viewBox="0 0 24 24">
        <path fill="#fff" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6-6-6 1.41-1.42z" />
      </symbol>
      <symbol id="angle-arrow-down" viewBox="0 0 24 24">
        <path d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6-6-6 1.41-1.42z" />
      </symbol>
      <symbol id="angle-arrow-up" viewBox="0 0 24 24">
        <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6 1.41 1.41z" />
      </symbol>
      <symbol id="arrow-left" viewBox="0 0 24 24">
        <path d="M20 11v2H8l5.5 5.5-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5 8 11h12z" />
      </symbol>
      <symbol id="arrow-right" viewBox="0 0 24 24">
        <path d="M4 11v2h12l-5.5 5.5 1.42 1.42L19.84 12l-7.92-7.92L10.5 5.5 16 11H4z" />
      </symbol>
      <symbol id="book-open" viewBox="0 0 24 24">
        <path
          d="M13 12h7v1.5h-7m0-4h7V11h-7m0 3.5h7V16h-7m8-12H3a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2m0 15h-9V6h9" />
      </symbol>
      <symbol id="calendar" viewBox="0 0 24 24">
        <path
          d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-1V1m-1 11h-5v5h5v-5z" />
      </symbol>
      <symbol id="card-text-outline" viewBox="0 0 24 24">
        <path
          d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z" />
      </symbol>
      <symbol id="cash-multiple" viewBox="0 0 24 24">
        <path
          d="M5 6h18v12H5V6m9 3a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3M9 8a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2v-4a2 2 0 0 1-2-2H9m-8 2h2v10h16v2H1V10z" />
      </symbol>
      <symbol id="check-box-checked" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <path fill="#1A1A1A"
            d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm12.293 4.293l-6.921 6.921-3.665-3.664-1.414 1.414 5.079 5.079 8.335-8.336-1.414-1.414z" />
        </g>
      </symbol>
      <symbol id="check-box-disabled" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <rect width="16" height="16" x="4" y="4" fill="#F5F5F5" stroke="#BFBFBF" stroke-width="2" rx="2" />
        </g>
      </symbol>
      <symbol id="check-box-focus" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path fill="#FEBB30" d="M0 0h24v24H0V0z" />
          <rect width="16" height="16" x="4" y="4" fill="#FFF" stroke="#1A1A1A" stroke-width="2" rx="2" />
        </g>
      </symbol>
      <symbol id="check-box-unchecked" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <rect width="16" height="16" x="4" y="4" fill="#FFF" stroke="#1A1A1A" stroke-width="2" rx="2" />
        </g>
      </symbol>
      <symbol id="check-circle-outline" viewBox="0 0 24 24">
        <path
          d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10A10 10 0 0 1 2 12 10 10 0 0 1 12 2m0 2a8 8 0 0 0-8 8 8 8 0 0 0 8 8 8 8 0 0 0 8-8 8 8 0 0 0-8-8m-1 12.5L6.5 12l1.41-1.41L11 13.67l5.59-5.58L18 9.5l-7 7z" />
      </symbol>
      <symbol id="check" viewBox="0 0 24 24">
        <path d="M21 7L9 19l-5.5-5.5 1.41-1.41L9 16.17 19.59 5.59 21 7z" />
      </symbol>
      <symbol id="checkbox-blank-outline" viewBox="0 0 24 24">
        <path d="M19 3H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 2v14H5V5h14z" />
      </symbol>
      <symbol id="checkbox-marked" viewBox="0 0 24 24">
        <path
          d="M10 17l-5-5 1.41-1.42L10 14.17l7.59-7.59L19 8m0-5H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" />
      </symbol>
      <symbol id="chevron-left" viewBox="0 0 24 24">
        <path d="M15.41 16.58L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.42z" />
      </symbol>
      <symbol id="chevron-right" viewBox="0 0 24 24">
        <path d="M8.59 16.58L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.42z" />
      </symbol>
      <symbol id="close-circle-outline" viewBox="0 0 24 24">
        <path
          d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z" />
      </symbol>
      <symbol id="close-circle" viewBox="0 0 24 24">
        <path
          d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z" />
      </symbol>
      <symbol id="close" viewBox="0 0 24 24">
        <path
          d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
      </symbol>
      <symbol id="delete-outline" viewBox="0 0 24 24">
        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
        <path fill="none" d="M0 0h24v24H0V0z" />
      </symbol>
      <symbol id="delete" viewBox="0 0 24 24">
        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
        <path fill="none" d="M0 0h24v24H0V0z" />
      </symbol>
      <symbol id="dots-vertical" viewBox="0 0 24 24">
        <path
          d="M12 16a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2 2 2 0 0 1-2 2 2 2 0 0 1-2-2 2 2 0 0 1 2-2z" />
      </symbol>
      <symbol id="download" viewBox="0 0 24 24">
        <path
          d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z" />
        <path fill="none" d="M0 0h24v24H0z" />
      </symbol>
      <symbol id="error" viewBox="0 0 24 24">
        <path
          d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-18C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2m2.59 6L12 10.59 9.41 8 8 9.41 10.59 12 8 14.59 9.41 16 12 13.41 14.59 16 16 14.59 13.41 12 16 9.41 14.59 8z" />
      </symbol>
      <symbol id="email" viewBox="0 0 24 24">
        <path
          d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z" />
      </symbol>
      <symbol id="feedback" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path
          d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17l-.59.59-.58.58V4h16v12zm-9-4h2v2h-2zm0-6h2v4h-2z" />
      </symbol>
      <symbol id="file-document-box" viewBox="0 0 24 24">
        <path
          d="M5 3c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h14c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2H5m0 2h14v14H5V5m2 2v2h10V7H7m0 4v2h10v-2H7m0 4v2h7v-2H7z" />
      </symbol>
      <symbol id="file-pdf-outline" viewBox="0 0 24 24">
        <path
          d="M14,2L20,8V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2H14M18,20V9H13V4H6V20H18M10.92,12.31C10.68,11.54 10.15,9.08 11.55,9.04C12.95,9 12.03,12.16 12.03,12.16C12.42,13.65 14.05,14.72 14.05,14.72C14.55,14.57 17.4,14.24 17,15.72C16.57,17.2 13.5,15.81 13.5,15.81C11.55,15.95 10.09,16.47 10.09,16.47C8.96,18.58 7.64,19.5 7.1,18.61C6.43,17.5 9.23,16.07 9.23,16.07C10.68,13.72 10.9,12.35 10.92,12.31M11.57,13.15C11.17,14.45 10.37,15.84 10.37,15.84C11.22,15.5 13.08,15.11 13.08,15.11C11.94,14.11 11.59,13.16 11.57,13.15M14.71,15.32C14.71,15.32 16.46,15.97 16.5,15.71C16.57,15.44 15.17,15.2 14.71,15.32M9.05,16.81C8.28,17.11 7.54,18.39 7.72,18.39C7.9,18.4 8.63,17.79 9.05,16.81M11.57,11.26C11.57,11.21 12,9.58 11.57,9.53C11.27,9.5 11.56,11.22 11.57,11.26Z">
        </path>
      </symbol>
      <symbol id="file" viewBox="0 0 24 24">
        <path fill="none" d="M0 0h24v24H0V0z" />
        <g>
          <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z" />
        </g>
      </symbol>
      <symbol id="folder-multiple" viewBox="0 0 24 24">
        <path
          d="M22 4a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h6l2 2h8M2 6v14h18v2H2a2 2 0 0 1-2-2V6h2m4 0v10h16V6H6z" />
      </symbol>
      <symbol id="help-circle" viewBox="0 0 24 24">
        <path
          d="M11 18h2v-2h-2v2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-14a4 4 0 0 0-4 4h2a2 2 0 0 1 2-2 2 2 0 0 1 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5a4 4 0 0 0-4-4z" />
      </symbol>
      <symbol id="info" viewBox="0 0 24 24">
        <path fill="none" d="M0 0h24v24H0V0z" />
        <path d="M11 7h2v2h-2zM11 11h2v6h-2z" />
        <path
          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
      </symbol>
      <symbol id="language" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0z" fill="none" />
        <path
          d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 0 0-1.38-3.56A8.03 8.03 0 0 1 18.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 0 1 5.08 16zm2.95-8H5.08a7.987 7.987 0 0 1 4.33-3.56A15.65 15.65 0 0 0 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z" />
      </symbol>
      <symbol id="magnify" viewBox="0 0 24 24">
        <path
          d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 0 1 9.5 16 6.5 6.5 0 0 1 3 9.5 6.5 6.5 0 0 1 9.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14 14 12 14 9.5 12 5 9.5 5z" />
      </symbol>
      <symbol id="menu-down" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5H7z" />
      </symbol>
      <symbol id="menu-left" viewBox="0 0 24 24">
        <path d="M14 7l-5 5 5 5V7z" />
      </symbol>
      <symbol id="menu-right" viewBox="0 0 24 24">
        <path d="M10 17l5-5-5-5v10z" />
      </symbol>
      <symbol id="menu-up" viewBox="0 0 24 24">
        <path d="M7 15l5-5 5 5H7z" />
      </symbol>
      <symbol id="message" viewBox="0 0 24 24">
        <path
          d="M20 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h16M4 4v13.17L5.17 16H20V4H4m2 3h12v2H6V7m0 4h9v2H6v-2z" />
      </symbol>
      <symbol id="minus" viewBox="0 0 24 24">
        <path d="M19 13H5v-2h14v2z" />
      </symbol>
      <symbol id="open-in-new" viewBox="0 0 24 24">
        <path
          d="M14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3m-2 16H5V5h7V3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7h-2v7z" />
      </symbol>
      <symbol id="palette" viewBox="0 0 24 24">
        <path fill="none" d="M0 0h24v24H0V0z" />
        <path
          d="M12 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.04 10 9c0 3.31-2.69 6-6 6h-1.77c-.28 0-.5.22-.5.5 0 .12.05.23.13.33.41.47.64 1.06.64 1.67 0 1.38-1.12 2.5-2.5 2.5zm0-18c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7z" />
        <circle cx="6.5" cy="11.5" r="1.5" />
        <circle cx="9.5" cy="7.5" r="1.5" />
        <circle cx="14.5" cy="7.5" r="1.5" />
        <circle cx="17.5" cy="11.5" r="1.5" />
      </symbol>
      <symbol id="pencil" viewBox="0 0 24 24">
        <path xmlns="http://www.w3.org/2000/svg"
          d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z" />
      </symbol>
      <symbol id="plus" viewBox="0 0 24 24">
        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
      </symbol>
      <symbol id="printer" viewBox="0 0 24 24">
        <path xmlns="http://www.w3.org/2000/svg"
          d="M19 8h-1V3H6v5H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zM8 5h8v3H8V5zm8 12v2H8v-4h8v2zm2-2v-2H6v2H4v-4c0-.55.45-1 1-1h14c.55 0 1 .45 1 1v4h-2z" />
      </symbol>
      <symbol id="radio-disabled" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <circle cx="12" cy="12" r="8" fill="#F5F5F5" stroke="#BFBFBF" stroke-width="2" />
        </g>
      </symbol>
      <symbol id="refresh" viewBox="0 0 24 24">
        <path
          d="M17.65 6.35A7.958 7.958 0 0 0 12 4a8 8 0 0 0-8 8 8 8 0 0 0 8 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18a6 6 0 0 1-6-6 6 6 0 0 1 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" />
      </symbol>
      <symbol id="save" viewBox="0 0 24 24">
        <path xmlns="http://www.w3.org/2000/svg"
          d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z" />
      </symbol>
      <symbol id="settings" viewBox="0 0 24 24">
        <path
          d="M19.43 12.97l2.11 1.66c.19.15.24.42.12.64l-2 3.46c-.12.22-.39.3-.61.22l-2.49-1.01c-.52.4-1.06.73-1.69.99l-.37 2.65c-.04.24-.25.42-.5.42h-4c-.25 0-.46-.18-.5-.42l-.37-2.65c-.63-.25-1.17-.59-1.69-.99l-2.49 1.01c-.22.08-.49 0-.61-.22l-2-3.46a.493.493 0 0 1 .12-.64l2.11-1.66L4.5 12l.07-1-2.11-1.63a.493.493 0 0 1-.12-.64l2-3.46c.12-.22.39-.31.61-.22l2.49 1c.52-.39 1.06-.73 1.69-.98l.37-2.65c.04-.24.25-.42.5-.42h4c.25 0 .46.18.5.42l.37 2.65c.63.25 1.17.59 1.69.98l2.49-1c.22-.09.49 0 .61.22l2 3.46c.12.22.07.49-.12.64L19.43 11l.07 1-.07.97M6.5 12c0 .58.09 1.13.25 1.66l-2.07 1.7.75 1.3 2.52-.94c.74.81 1.73 1.4 2.85 1.65l.44 2.63h1.5l.44-2.63c1.12-.24 2.12-.83 2.87-1.64l2.51.94.75-1.3-2.07-1.7c.17-.53.26-1.09.26-1.67 0-.57-.09-1.13-.25-1.65l2.06-1.69-.75-1.3-2.5.93a5.526 5.526 0 0 0-2.87-1.66L12.75 4h-1.5l-.44 2.63c-1.12.25-2.12.84-2.87 1.66l-2.5-.94-.75 1.3 2.06 1.7c-.16.52-.25 1.08-.25 1.65M12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5m0 2a1.5 1.5 0 0 0-1.5 1.5 1.5 1.5 0 0 0 1.5 1.5 1.5 1.5 0 0 0 1.5-1.5 1.5 1.5 0 0 0-1.5-1.5z" />
      </symbol>
      <symbol id="sort-ascending" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <path fill="#1A1A1A" d="M6 13l6 6 6-6z" />
          <path stroke="#1A1A1A" d="M16.793 10.5L12 5.707 7.207 10.5h9.586z" />
        </g>
      </symbol>
      <symbol id="sort-descending" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <path stroke="#1A1A1A" d="M7.207 13.5L12 18.293l4.793-4.793H7.207z" />
          <path fill="#1A1A1A" d="M18 11l-6-6-6 6z" />
        </g>
      </symbol>
      <symbol id="sort-none" viewBox="0 0 24 24">
        <g fill="none" fill-rule="evenodd">
          <path d="M0 0h24v24H0z" />
          <path d="M7.207 13.5L12 18.293l4.793-4.793H7.207zm9.586-3L12 5.707 7.207 10.5h9.586z" stroke="#1A1A1A" />
        </g>
      </symbol>
      <symbol id="success" viewBox="0 0 24 24">
        <path
          d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10A10 10 0 0 1 2 12 10 10 0 0 1 12 2m0 2a8 8 0 0 0-8 8 8 8 0 0 0 8 8 8 8 0 0 0 8-8 8 8 0 0 0-8-8m-1 12.5L6.5 12l1.41-1.41L11 13.67l5.59-5.58L18 9.5l-7 7z" />
      </symbol>
      <symbol id="warning" viewBox="0 0 24 24">
        <path d="M12 2L1 21h22M12 6l7.53 13H4.47M11 10v4h2v-4m-2 6v2h2v-2" />
      </symbol>
      <symbol id="people-alt" viewBox="0 0 24 24">
        <g>
          <rect fill="none" height="24" width="24" />
        </g>
        <g>
          <g/>
          <g>
            <path d="M16.67,13.13C18.04,14.06,19,15.32,19,17v3h4v-3C23,14.82,19.43,13.53,16.67,13.13z" />
            <path
              d="M15,12c2.21,0,4-1.79,4-4c0-2.21-1.79-4-4-4c-0.47,0-0.91,0.1-1.33,0.24C14.5,5.27,15,6.58,15,8s-0.5,2.73-1.33,3.76 C14.09,11.9,14.53,12,15,12z" />
            <path
              d="M9,12c2.21,0,4-1.79,4-4c0-2.21-1.79-4-4-4S5,5.79,5,8C5,10.21,6.79,12,9,12z M9,6c1.1,0,2,0.9,2,2c0,1.1-0.9,2-2,2 S7,9.1,7,8C7,6.9,7.9,6,9,6z" />
            <path
              d="M9,13c-2.67,0-8,1.34-8,4v3h16v-3C17,14.34,11.67,13,9,13z M15,18H3l0-0.99C3.2,16.29,6.3,15,9,15s5.8,1.29,6,2V18z" />
          </g>
        </g>
      </symbol>
      <symbol id="clock" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path
          d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
      </symbol>
      <symbol id="location-on" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/><circle cx="12" cy="9" r="2.5"/></symbol>
    </svg>
  </div>

  <div id="desktop-only">
    <main class="container page-container" style="padding-left: 0; padding-right: 0; max-width: none">
      <div class="event-fader col-lg-12 col-md-12 col-sm-12 mb-2" style="max-width: none; background: rgb(255,255,255); background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,241,241,1) 100%); padding:none;">
        <div class="event-header col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-12">
          <img src="/assets/rave-example-photo.jpg" class="mx-auto header-img" style="" alt="Dit event foto">
          <div class="mx-5 py-5 header-details">
            <div class="header-column-1">
              <h1 class="h1" style="margin: 0; text-align: start;margin-bottom:5px"><?php echo $eventName ?></h1>
              <div style="display: flex; flex-direction:row; ">
                <div style="height: 3rem; width: 3rem;">
                  <svg style="width:100%; height:100%;" class="icon-svg" focusable="false" aria-hidden="true">
                    <use xlink:href="#calendar"></use>
                  </svg>
                </div>
                <div style="display: flex; flex-direction:column; text-align:left; align-self: center;">
                  <h5 class="h5" style="margin:0;"> <span style="font-weight: 600;" id="startDate"> - </span> <span style="font-weight: 600;" id="endDate"> </span> </h5>
                </div>
              </div>
            </div>
            <div class="header-column-2">
              <a class="button button-primary alert-leave d-print-none my-2" id="checkout-button" style="width: 100%;" href="#">
                Køb billet
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="event-body container page-container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card mb-5" style="border-radius: 10px">
              <div class="card-header">
                <p class="h3">Detaljer</p>
              </div>
              <div class="content" style="background-color: #e8e9f3; border-color: black; border-width: 1px; border-top: 1px solid #d8d8d8;">
                <div class="row justify-content-center">
                  <div class="col-12">
                    <!-- Alt i denne div er blot et eksempel. Visse klasser er ikke en del af FDS. -->
                    <div class="row bg-violet p-5">
                        <div class="col-12 align-text-left">
                            <div class="mt-2" style="display: flex; flex-direction:row; align-items:center;">
                                <div style="height: 3rem; width:3rem;">
                                    <svg class="icon-svg" focusable="false" aria-hidden="true">
                                        <use xlink:href="#cash-multiple"></use>
                                    </svg>
                                </div>
                                <div style="display: flex; flex-direction:row;">
                                    <h5 class="mt-2 ml-2 row"> Pris pr. billet: <span style="font-weight: 400; padding-left: 4px;"> <?php echo $price." kr." ?> </span></h5>
                                </div>
                                </div>
                                <div class="mt-4" style="display: flex; flex-direction:row; align-items:center;">
                                <div style="height: 3rem; width:3rem;">
                                    <svg style="width:100%; height:100%;" class="icon-svg" focusable="false" aria-hidden="true">
                                    <use xlink:href="#people-alt"></use>
                                    </svg>
                                </div>
                                <div style="display: flex; flex-direction:column;">
                                    <h5 class="mt-2 ml-2"> Antal billetter: <span
                                        style="font-weight: 400;"><?php echo $tickets ?> </span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-5" style="border-radius: 10px">
              <div class="card-header">
                <p class="h3">Placering</p>
              </div>
              <div class="content" style="background-color: #e8e9f3; border-color: black; border-width: 1px; border-top: 1px solid #d8d8d8; height: 60vh;">
                <div id="map" style="height: 60vh;"></div>
              </div>
            </div> 
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 mt-6 mt-md-0">
            <div class="card mb-5" style="border-radius: 10px">
              <div class="card-header">
                <p class="h3">Administrer</p>
              </div>
              <div class="content" style="background-color: #e8e9f3; border-color: black; border-width: 1px; border-top: 1px solid #d8d8d8; height: 240px;">
              <div class="row justify-content-center">
                  <div class="col-12">
                    <!-- Alt i denne div er blot et eksempel. Visse klasser er ikke en del af FDS. -->
                    <div class="row bg-violet p-5">
                      <div class="col-12 align-text-left">
                        <a class="button button-primary alert-leave d-print-none my-2" style="width: 100%;" href="/scanner/?t=<?php echo $scanToken ?>&e=<?php echo $eventID?>">
                          Scan billetter
                        </a>
                        <a class="button button-primary alert-leave d-print-none my-2" style="width: 100%; margin-left:0" href="edit/?id=<?php echo $eventID?>">
                          Rediger detajer
                        </a>
                        <a class="button button-primary alert-leave d-print-none my-2" style="width: 100%; margin-left:0"
                          href="#">
                          Billetoversigt
                        </a>
                        <a class="button button-danger alert-leave d-print-none my-2" style="width: 100%; margin-left:0"
                          href="#">
                          Aflys event
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
            <div class="card mb-5" style="border-radius: 10px">
              <div class="card-header">
                <p class="h3">Beskrivelse</p>
              </div>
              <div class="content" style="background-color: #e8e9f3; border-color: black; border-width: 1px; border-top: 1px solid #d8d8d8;">
                <div class="row justify-content-center">
                  <div class="col-12">
                    <!-- Alt i denne div er blot et eksempel. Visse klasser er ikke en del af FDS. -->
                    <div class="row bg-violet px-5 pb-5 pt-3">
                        <div class="col-12 align-text-left">
                            <div id="editor-container" class="ql-editor" style="min-height: 250px; max-height: 1000px; white-space: normal; padding: 0;">
                                <p><?php echo htmlspecialchars_decode($description) ?></p>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </main>
  </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/da.min.js" integrity="sha512-rybyYvSnwg3zAZ/vjTTMoh8tOK0Z6tC2XCzr9e27M0xr8WU40IGo6SOP7FXXCyWgMyd3wZ8ln2nY4ce1ysYUfw==" crossorigin="anonymous"></script>
<script src="../moment-timezone-with-data.js"></script>
<script>
  var day = moment.tz(moment.unix(<?php echo $startDate ?>), "Europe/Copenhagen").format('LLL');
  $("#startDate").text(day+ " - ");
  var end = moment.tz(moment.unix(<?php echo $endDate ?>), "Europe/Copenhagen").format('LLL');
  $("#endDate").text(end);
</script>
<script src='/vendor/dkfds/js/dkfds.js'></script>
<script>
  var address;
  var nameEvent = "<?php echo $eventName?>";
  var xhr = new XMLHttpRequest();
  xhr.withCredentials = false;

  xhr.addEventListener("readystatechange", function() {
    if(this.readyState === 4) {
      console.log(this.responseText);
      output = JSON.parse(this.responseText);
      address = output['betegnelse'];
    }
  });

  xhr.open("GET", "https://api.dataforsyningen.dk/adgangsadresser/reverse?x=<?php echo $lng ?>&y=<?php echo $lat ?>&struktur=mini&valider");

  xhr.send();

  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>),
      zoom: 12,
    });
    var infoWindow = new google.maps.InfoWindow;

    var infowincontent = document.createElement('div');
    var strong = document.createElement('strong');
    strong.textContent = nameEvent
    infowincontent.appendChild(strong);
    infowincontent.appendChild(document.createElement('br'));

    var text = document.createElement('text');
    text.textContent = address;
    infowincontent.appendChild(text);

    
    var marker = new google.maps.Marker({
      map: map,
      position: new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>),
      
    });
    infoWindow.setContent(infowincontent);
    infoWindow.open(map, marker);
    marker.addListener('click', function() {
      infoWindow.setContent(infowincontent);
      infoWindow.open(map, marker);
    });
  }
  
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Handler when the DOM is fully loaded
    DKFDS.init();
  });
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXYCbnfIMcYFMU70o6W7iVvQchKkHKRoI&callback=initMap">
</script>
</body>