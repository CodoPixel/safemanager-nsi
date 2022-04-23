<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => "",
  "post" => json_encode($_POST),
);

$selectedID = isset($_GET["selectedID"]) ? (int)$_GET["selectedID"] : null;

try {
  if (!empty($_POST)) {
    $auth = new Auth();
    if ($selectedID < 0) {
      $auth->createNewConnection($_POST);
    } else {
      $auth->modifyConnection($selectedID, $_POST);
    }
    $response["confirmed"] = true;
  }
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = $e->getMessage();
}

echo json_encode($response);