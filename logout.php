<?php

    session_start();
    unset($_SESSION["id"]);
    unset($_SESSION["email"]);
    unset($_SESSION["username"]);
    header("Location:login.php");

?>