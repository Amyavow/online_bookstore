<?php


include '../include/db.php';
include '../include/functions.php';

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['client_name']);
unset($_SESSION['username']);
unset($_SESSION['email']);

header("location:login.php");



?>


