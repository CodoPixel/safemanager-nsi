<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
);

try {
  if (empty($_POST)) {
    throw new ClientException("Aucune donnée à traiter.");
  }
  $auth = new Auth();
  $auth->saveProfil($_POST);
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = "Une erreur est survenue.";
}

echo json_encode($response);