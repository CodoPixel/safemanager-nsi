<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
);

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
  if ($id === null) {
    throw new ClientException("Aucune image à supprimer.");
  }
  $auth = new Auth();
  $auth->deleteImage($id);
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = "Une erreur est survenue.";
}

echo json_encode($response);