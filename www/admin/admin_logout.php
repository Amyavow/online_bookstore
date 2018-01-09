<?php


include '../include/db.php';
include '../include/functions.php';

session_start();

unset($_SESSION['admin_id']);
unset($_SESSION['name']);

header("location:login.php");



?>


