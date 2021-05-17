<?php
    echo "logged out";
    unset($_SESSION['mstoken']);
    session_start();
    session_destroy();
?>