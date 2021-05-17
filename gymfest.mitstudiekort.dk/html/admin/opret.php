<?php
session_start();
include "../api/onsite/auth/msapi.php";

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
if ($user->role != "admin") {
  header_remove('Location');
  header('Location: /student/index.php');
}

?>
<!doctype html>

<!-- GYMFEST -> ADMIN -> OPRET -->

<html lang="da">

<head>
  <meta charset="utf-8">

  <title>GymFest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link type="text/css" rel="stylesheet" href="/vendor/dkfds/css/dkfds-virkdk.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/vendor/autocompleteAddress.module.css" />
  <link rel="apple-touch-icon" sizes="57x57" href="/assets/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/assets/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/assets/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/assets/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
  <link rel="manifest" href="/assets/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/assets/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <style type="text/css">
    #map {
      width: 100%;
      height: 400px;
    }
  </style>

</head>

<body>

  <header class="header">

    <!--1A: Portal header -->
    <div class="portal-header ">
      <div class="container portal-header-inner">
        <a href="index" title="Hjem" class="logo alert-leave">
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
          <a class="button button-primary alert-leave d-print-none" href="/student/">
            Gå til Student
          </a>
          <a class="button button-secondary alert-leave d-print-none"
            href="/api/onsite/auth/handleAuth?t=<?php echo $_SESSION['mstoken']?>&ac=logout">
            Log af
          </a>

        </div>
      </div>
    </div>

    <nav class="nav" style="">
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
            <li class="current">
              <a href="#" class="nav-link" title="Min profil">
                <span>Opret begivenhed</span>
              </a>
            </li>
            <li>
              <a href="/admin/events/" class="nav-link" title="Fester">
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
        <a href="/api/onsite/auth/handleAuth?t=<?php echo $_SESSION['mstoken']?>&ac=logout"
          class="button button-secondary button-signout alert-leave">
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
      <symbol id="location-on" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/><circle cx="12" cy="9" r="2.5"/></symbol>
    </svg>
  </div>

  <main class="container page-container">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <h2 style="margin-top: 0;">Opret ny begivenhed</h2>
        <div class="form-group" style="max-width: 25rem;">
          <label class="form-label " for="event-name">
            Begivenhedsnavn
          </label>
          <input class="form-input " id="event-name" value="" name="event-name" type="text" />
        </div>
        <div class="form-group" style="max-width: 25rem;">
          <label class="form-label" for="event-start-date">
            Starttidspunkt
          </label>
          <div onclick="showCal(date1);" class="date-1" style="display:flex">
            <input type="text" onclick="showCal(date1);" id="event-start-date"
              style="border: 1px solid #747474; border-radius: 4px; color: #1a1a1a; display: block; font-size: 1.6rem; line-height: 2.6rem; padding: calc(8px - 1px) calc(16px - 1px); width: 100%; max-width: 32rem; margin-top: 8px; text-align: left;">
            <button type="button" class="date-picker__button" aria-haspopup="true"
              aria-label="Åbn kalender">&nbsp;</button>
          </div>

          <label class="form-label" for="event-end-date">
            Sluttidspunkt
          </label>
          <div onclick="showCal(date2);" class="date-2" style="display:flex">
            <input type="text" onclick="showCal(date2);" id="event-end-date"
              style="border: 1px solid #747474; border-radius: 4px; color: #1a1a1a; display: block; font-size: 1.6rem; line-height: 2.6rem; padding: calc(8px - 1px) calc(16px - 1px); width: 100%; max-width: 32rem; margin-top: 8px; text-align: left;">
            <button type="button" class="date-picker__button" aria-haspopup="true"
              aria-label="Åbn kalender">&nbsp;</button>
          </div>
        </div>
        <div class="form-group" style="max-width: 25rem;">
          <input id="publish-later" type="checkbox" name="checkbox-large[]" value="1"
            class="form-checkbox  checkbox-large " />
          <label for="publish-later" class="form-label">Forskyd udgivelse</label>
          <div onclick="showCal(date3);" class="date-3" style="display:flex">
            <input type="text" onclick="showCal(date3);" id="event-publish-date"
              style="display:none;border: 1px solid #747474; border-radius: 4px; color: #1a1a1a; font-size: 1.6rem; line-height: 2.6rem; padding: calc(8px - 1px) calc(16px - 1px); width: 100%; max-width: 32rem; margin-top: 8px; text-align: left;">
            <button type="button" class="date-picker__button" id="event-publish-date-label" aria-haspopup="true"
              aria-label="Åbn kalender" style="display:none;">&nbsp;</button>
          </div>
        </div>
        <div class="form-group" style="max-width: 25rem;">
          <button class="button button-secondary mb-4" style="width:100%;" data-module="modal" data-target="location-modal">
          Vælg sted <svg class="icon-svg" focusable="false" aria-hidden="true"><use xlink:href="#location-on"></use></svg>
          </button>
          <label class="form-label " for="ticket-amount">
            Antal biletter
          </label>
          <input class="form-input " id="ticket-amount" value="" name="ticket-amount" type="number" />
          <label class="form-label " for="ticket-price">
            Pris pr. billet (kr.)
          </label>
          <input class="form-input " id="ticket-price" value="" name="ticket-price" type="number" />
        </div>
        <div class="form-group" style="max-width: 25rem;">
          <label class="form-label " for="search">
            Inviterede grupper
          </label>
          <div id="invitesClasses" style="margin-top: 5px;">
          </div>
          <input class="form-input " style="margin-bottom: 5px;" id="search" value="" name="search" type="text"
            placeholder="Søg efter grupper her" />
          <div id="match-list"
            style="padding-top: 5px; max-height: 200px; overflow: hidden; overflow-y: scroll; max-width: 35ch;">
          </div>
        </div>
        <div class="form-group" style="max-width: 25rem;">
          <input id="student-admin" type="checkbox" name="allow-student-admin" value="1"
            class="form-checkbox  checkbox-large " />
          <label for="student-admin" class="form-label">Tillad elevadministration</label>
          <div id="student-admin-div" style="display:none">
            <label class="form-label " for="search-student">
              Elevadministratorer
            </label>
            <div id="invitesStudents" style="margin-top: 5px;">
            </div>
            <input class="form-input " style="margin-bottom: 5px;" id="search-student" value="" name="search-students" type="text"
              placeholder="Søg efter grupper her" />
            <div id="match-list-student"
              style="padding-top: 5px; max-height: 200px; overflow: hidden; overflow-y: scroll; max-width: 35ch;">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8" style="display: inline-grid; flex-wrap: wrap; align-content: center;">
        <div class="form-group mr-5 my-3">
          <input name="about" type="hidden">
          <div id="editor-container" class="" style="height: 250px;">
            <p></p>
          </div>
        </div>
      </div>
      <div class="col-12" style="display: flex; justify-content: center;">
        <button class="button button-primary mb-5" onclick="makeEvent()" id="createButton"> <span class="px-5">Opret begivenhed</span>
        </button>
      </div>
    </div>

    <div class="fds-modal" id="location-modal" aria-hidden="true" role="dialog" aria-modal="true"
      aria-labelledby="modal-location-title">
      <div class="modal-content" style="width: 80%; height:90%">
        <div class="modal-header">
          <h2 class="modal-title" id="modal-location-title">
            Vælg placering
          </h2>
          <button class="modal-close button button-unstyled" aria-label="Luk" data-modal-close=""><svg class="icon-svg"
              focusable="false" aria-hidden="true">
              <use xlink:href="#close"></use>
            </svg></button>
        </div>
        <div class="modal-body">

        <div class="autocomplete-container">
          <label class="form-label " for="input-type-text">
            Adresse
          </label>
          <input type="search" class="form-input" id="dawa-autocomplete-input">
          <!-- Suggestions will appear here -->
        </div>
        <div id="map" style="margin-top: 20px;"></div>
        </div>
        <div class="modal-footer">
        <button class="button button-primary" id="confirmPosition" data-modal-close="">Gem placering</button>
         <button class="button button-secondary" data-modal-close="">Luk</button>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
  </script>
  <script src="https://cdn.aws.dk/assets/dawa-autocomplete2/1.0.2/dawa-autocomplete2.min.js"></script> 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXYCbnfIMcYFMU70o6W7iVvQchKkHKRoI"></script>
  <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>
  <script src='/vendor/dkfds/js/dkfds.js'></script>
  <script>
    var lngSave;
    var latSave;
    var date1;
    $('document').ready(function () {
      date1 = flatpickr("#event-start-date", {
        inline: false,
        enableTime: true,
        minDate: "today",
        time_24hr: true,
      });
      date2 = flatpickr("#event-end-date", {
        inline: false,
        enableTime: true,
        minDate: "today",
        time_24hr: true,
      });
      date3 = flatpickr("#event-publish-date", {
        inline: false,
        enableTime: true,
        minDate: "today",
        time_24hr: true,
      });
    });

    function showCal(cal) {
      console.log(cal.isOpen);
      if (cal.isOpen) {
        cal.close();
      } else {
        cal.open();
      }
    }

    const validateForm = () => {
      var eventName = $("#event-name").val();
      var startTime = $("#event-start-date").val();
      var endTime = $("#event-end-date").val();
      var publishAt = moment();
      var price = $("#ticket-price").val();
      var ticketAmount = $("#ticket-amount").val();
      var invitedClasses = listInvitedClasses();


      if (eventName.length > 0 && startTime.length > 0 && endTime.length > 0 && ticketAmount.length > 0 && invitedClasses.length > 0 && typeof(latSave) !==  undefined && typeof(lngSave) !== undefined) {
          startTime = moment(startTime).unix();
          endTime = moment(endTime).unix();
          if (endTime >= startTime) {
            return true;
          } else {
            alert("Slutdato skal befinde sig efter startdato!")
            return false;
          }
      } else {
        console.log("FALSE!!");
        return false;
      }
    }

    var quill = new Quill('#editor-container', {
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['link', 'blockquote'],

          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }],
          [{
            'indent': '-1'
          }, {
            'indent': '+1'
          }], // outdent/indent

          [{
            'header': [1, 2, 3, 4, 5, 6, false]
          }],

          [{
            'color': []
          }, {
            'background': []
          }], // dropdown with defaults from theme
          [{
            'align': []
          }],

          ['clean']
        ]
      },
      placeholder: 'Beskriv din begivenhed her ...',
      theme: 'snow'
    });

    dawaAutocomplete.dawaAutocomplete(document.getElementById('dawa-autocomplete-input'), {
      select: function(selected) {
        console.log('Valgt adresse: ' + selected.tekst + ' Valgt id: ' + selected.data.x);

        lp.setLocation({lat: selected.data.y, lng: selected.data.x});
        lp.map.setZoom(13);
      },
      params: {per_side: 10}
    });

    // Get element references
    var confirmBtn = document.getElementById('confirmPosition');
    var onClickPositionView = document.getElementById('onClickPositionView');
    var onIdlePositionView = document.getElementById('onIdlePositionView');
    
    var latStart = 55.6713442;
    var lngStart = 12.5237847;
    // Initialize locationPicker plugin
    var lp = new locationPicker('map', {
      setCurrentPosition: true, // You can omit this, defaults to true
    }, {
      zoom: 10, // You can set any google map options here, zoom defaults to 15
      center: { lat: latStart, lng: lngStart },
    });

    // Listen to button onclick event
    confirmBtn.onclick = function () {
      // Get current location and show it in HTML
      var location = lp.getMarkerPosition();
      console.log('The saved location is ' + location.lat + ',' + location.lng);
      latSave = location.lat;
      lngSave = location.lng;
      console.log(latSave);
      console.log(lngSave);
    };

    // Listen to map idle event, listening to idle event more accurate than listening to ondrag event
    google.maps.event.addListener(lp.map, 'idle', function (event) {
      // Get current location and show it in HTML
      var location = lp.getMarkerPosition();
      console.log('The idle location is ' + location.lat + ',' + location.lng);
    });


    function makeEvent() {
      var eventName = $("#event-name").val();
      var startTime = $("#event-start-date").val();
      var endTime = $("#event-end-date").val();
      var publishAt = moment();
      var price = $("#ticket-price").val();
      var ticketAmount = $("#ticket-amount").val();
      var invitedClasses = listInvitedClasses();
      var studentAdmins = [];

      startTime = moment(startTime).unix();
      endTime = moment(endTime).unix();

      var delta = quill.root.innerHTML;


      console.log(JSON.stringify(quill.getContents()));

      if ($('input#publish-later').prop('checked')) {
        publishAt = moment($("#event-publish-date").val()).unix();
      } else {
        publishAt = publishAt.unix();
      }

      if ($('input#student-admin').prop('checked')) {
        studentAdmins = listStudentAdmins();
      }

      if (validateForm()) {
        if (price.length == 0) {
          price = 0;
        }
        $("#createButton").html('<div style = "margin-inline-start: 67px; margin-inline-end: 67px; font-size:6px;" class="spinner-white"> </div>');
        delta = delta.replace("&", "§€§€");
        console.log(eventName, startTime, endTime, publishAt, price, ticketAmount, JSON.stringify(invitedClasses), delta, latSave, lngSave, JSON.stringify(studentAdmins));

        var xhttp = new XMLHttpRequest();
        var url = 'https://gymfest.mitstudiekort.dk/api/onsite/event/handleEvent.php';
        var xhttpError = "";

        xhttp.open("POST", url, true);
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);

            setTimeout(() => {
              window.location.replace("/admin/events/");
            }, 700);
          }
        }

        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("se=" + startTime + "&ee=" + endTime + "&en=" + eventName + "&pe=" + publishAt + "&p=" + price +
          "&t=" + ticketAmount + "&i=" + JSON.stringify(invitedClasses) + "&d=" + delta + "&lng=" + lngSave + "&lat=" + latSave + "&sa=" + JSON.stringify(studentAdmins));
      }
    }

    var classesRes;

    function getClasses() {
      var data = "{\"token\":\"<?php echo $_SESSION["mstoken"]; ?>\"}";

      console.log(data);

      var xhr = new XMLHttpRequest();
      xhr.withCredentials = true;

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          classesRes = JSON.parse(this.responseText);
        }
      });

      xhr.open("POST", "https://mitstudiekort.dk/api/offsite/auth/fetchClasses.php");
      xhr.setRequestHeader("Content-Type", "text/plain");

      xhr.send(data);
    }

    var studentsRes;
    
    function getStudents() {
      var data = "{\"token\":\"<?php echo $_SESSION["mstoken"]; ?>\"}";

      console.log(data);

      var xhr = new XMLHttpRequest();
      xhr.withCredentials = true;

      xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          var res = JSON.parse(this.responseText);
          console.log(res[0]);
          studentsRes = res;
        }
      });

      xhr.open("POST", "https://mitstudiekort.dk/api/offsite/auth/fetchStudents.php");
      xhr.setRequestHeader("Content-Type", "text/plain");

      xhr.send(data);
    }

    const search = document.getElementById('search');
    const results = document.getElementsByClassName("match-check");
    const matchList = document.getElementById('match-list');
    const tagDiv = document.getElementById('invitesClasses');

    search.addEventListener('input', () => searchClasses(search.value));

    const addTag = (checker) => {
      const tag = document.getElementById(checker.value);
      if (tag) {
        if (tag.style.display === "none") {
          tag.style.display = "inline";
        } else {
          tag.style.display = "none";
        }
      } else if (checker.checked) {
        tagDiv.innerHTML += `
                            <button class="tag classtag" id="${checker.value}" style="margin-bottom:2px">
                                ${checker.value}
                                <svg class="icon-svg" onclick="hideTag('${checker.value}')" focusable="false" aria-hidden="true" style="height: 20px; width: 20px; margin-top: 4px; margin-left: 2px;"><use xlink:href="#close"></use></svg>
                            </button>`;
      }
    }

    const hideTag = (value) => {
      const tag = document.getElementById(value);
      const classCheck = document.getElementById("check-" + value);
      if (tag) {
        tag.remove();
        classCheck.checked = false;
      }
    }

    const searchClasses = searchText => {
      const classList = classesRes;

      // Find matches til søgeteksten
      let matches = classList.filter(className => {
        const regex = new RegExp(`${searchText}`, 'gi');
        return className.match(regex);
      });

      console.log(matches);
      if (searchText.length == 0) {
        matchList.innerHTML = "";
      } else {
        outputHtml(matches);
      }
    };

    const outputHtml = matches => {
      if (matches.length > 0) {
        const html = matches
          .map(
            match => `
              <div class="match row" style="justify-content: space-between; background-color: #e9e9e9; border: 1px solid #747474; border-radius: 4px; max-width: 32rem; padding: 8px; margin: 4px;">
                <p style="margin:0px">${match}</p>
                <input id="check-${match}" onclick="addTag(this)" type="checkbox" name="checkbox-small[]" value="${match}" class="form-checkbox match-check" style="position: inherit; width: 20px; height: 20px; margin-top: 3px;"/>
              </div>
            `
          )
          .join('');

        matchList.innerHTML = html;
      }
    }

    const listInvitedClasses = () => {
      const tags = document.querySelectorAll('.classtag');
      let invitedClasses = [];

      tags.forEach(tag => {
        const className = tag.id;
        invitedClasses.push(className);
      });

      return invitedClasses;
    }

    const studentSearch = document.getElementById('search-student');
    const resultsStudents = document.getElementsByClassName("match-check-student");
    const matchListStudents = document.getElementById('match-list-student');
    const tagDivStudents = document.getElementById('invitesStudents');

    studentSearch.addEventListener('input', () => searchStudents(studentSearch.value));

    const addTagStudents = (checker) => {
      const tag = document.getElementById(checker.value);
      if (tag) {
        if (tag.style.display === "none") {
          tag.style.display = "inline";
        } else {
          tag.style.display = "none";
        }
      } else if (checker.checked) {
        tagDivStudents.innerHTML += `
                            <button class="tag tagstudent" id="${checker.value}" studentId="${checker.id}" style="margin-bottom:2px">
                                ${checker.value}
                                <svg class="icon-svg" onclick="hideTagStudent('${checker.value}')" focusable="false" aria-hidden="true" style="height: 20px; width: 20px; margin-top: 4px; margin-left: 2px;"><use xlink:href="#close"></use></svg>
                            </button>`;
      }
    }

    const hideTagStudent = (value) => {
      const tag = document.getElementById(value);
      const classCheck = document.getElementById("check-" + value);
      if (tag) {
        tag.remove();
        classCheck.checked = false;
      }
    }

    const searchStudents = searchText => {
      const studentList = studentsRes;

      // Find matches til søgeteksten
      let matches = studentList.filter(student => {
        const regex = new RegExp(`${searchText}`, 'gi');
        return student.name.match(regex);
      });

      console.log(matches);
      if (searchText.length == 0) {
        matchListStudents.innerHTML = "";
      } else {
        outputHtmlStudents(matches);
      }
    };

    const outputHtmlStudents = matches => {
      if (matches.length > 0) {
        const html = matches
          .map(
            match => `
              <div class="match row" style="justify-content: space-between; background-color: #e9e9e9; border: 1px solid #747474; border-radius: 4px; max-width: 32rem; padding: 8px; margin: 4px;">
                <p style="margin:0px">${match.name}</p>
                <input id="${match.id}" onclick="addTagStudents(this)" type="checkbox" name="checkbox-small[]" value="${match.name}" class="form-checkbox match-check" style="position: inherit; width: 20px; height: 20px; margin-top: 3px;"/>
              </div>
            `
          )
          .join('');

          matchListStudents.innerHTML = html;
      }
    }

    const listStudentAdmins = () => {
      const tagsStudents = document.querySelectorAll('.tagstudent');
      let invitedStudents = [];

      tagsStudents.forEach(tag => {
        const studentId = tag.getAttribute("studentid");
        invitedStudents.push(studentId);
      });

      return invitedStudents;
    }

    $('input#publish-later').click(function () {
      if ($('input#publish-later').prop('checked')) {
        $("#event-publish-date").show();
        $("#event-publish-date-label").show();
      } else {
        $("#event-publish-date").hide();
        $("#event-publish-date-label").hide();
      }
    });

    $('input#student-admin').click(function () {
      if ($('input#student-admin').prop('checked')) {
        $("#student-admin-div").show();
      } else {
        $("#student-admin-div").hide();
      }
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Handler when the DOM is fully loaded
      DKFDS.init();
      getClasses();
      getStudents();
    });
  </script>

</body>