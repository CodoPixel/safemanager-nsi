<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
  "data" => [
    "labelID" => null,
  ]
);

$title = isset($_GET["title"]) ? $_GET["title"] : null;
$color = isset($_GET["color"]) ? $_GET["color"] : null;

try {
  if ($title === null || $color === null) {
    throw new ClientException("Données corrompues.");
  }
  $auth = new Auth();
  $labelID = $auth->addNewLabel($title, $color);
  $response["data"]["labelID"] = $labelID;
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = "Une erreur est survenue.";
}

echo json_encode($response);