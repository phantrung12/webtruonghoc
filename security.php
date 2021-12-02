<?php
session_start();
require_once("config.php");
if($conn)
{
    // echo "Database Connected";
}
else
{
    header("Location: config.php");
}

if(!$_SESSION['username'])
{
    header('Location: login.php');
}
?>