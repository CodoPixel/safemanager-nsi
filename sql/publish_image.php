<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
  "data" => [
    "ID" => null,
    "clientID" => null,
    "imageName" => null
  ] 
);

try {
  if (empty($_FILES)) {
    throw new ClientException("Aucune image à publier.");
  }
  $auth = new Auth();
  $data = $auth->publishImage($_FILES);
  $response["data"] = $data;
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = $e->getMessage();
}

echo json_encode($response);