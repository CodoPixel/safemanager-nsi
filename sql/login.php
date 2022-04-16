<?php

require_once "../class/Auth.php";

// var_dump($_POST);

$email = $_POST["email"];
$password = $_POST["password"];

$auth = new Auth();
$auth->loginWithCredentials($email, $password);

header("Location: ../index.php");