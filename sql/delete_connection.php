<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
);

$selectedID = isset($_GET["selectedID"]) ? (int)$_GET["selectedID"] : null;

try {
  if ($selectedID === null) {
    throw new ClientException("Aucune connexion sélectionnée.");
  }
  if ($selectedID < 0) {
    throw new ClientException("Cette connexion n'existe pas.");
  }
  $auth = new Auth();
  $auth->deleteConnection($selectedID);
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = "Une erreur est survenue.";
}

echo json_encode($response);