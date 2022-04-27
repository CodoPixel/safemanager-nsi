<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
  "FILES" => json_encode($_FILES),
  "POST" => json_encode($_POST),
);

try {
  if (empty($_POST)) {
    throw new ClientException("Aucune donnée à traiter.");
  }
  $auth = new Auth();
  $auth->saveProfil($_POST, $_FILES);
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = $e->getMessage();
}

echo json_encode($response);