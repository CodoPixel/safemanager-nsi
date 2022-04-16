<?php

require_once "../class/Auth.php";

// var_dump($_POST);

$email = $_POST["email"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];

$auth = new Auth();
$auth->register($email, $password, $firstname, $lastname);

header("Location: ../index.php");