<?php

require_once '../class/Auth.php';
AuthHelper::needsAjax();
AuthHelper::mustBeConnected("../login.php");

$response = array(
  "confirmed" => false,
  "error" => ""
);

$selectedNoteID = isset($_GET["note"]) ? (int)$_GET["note"] : null;

try {
  if (empty($_POST)) {
    throw new ClientException("Aucune donnée à enregistrer.");
  } else if (strlen(trim($_POST["title"])) === 0 || strlen(trim($_POST["title"])) > 255 || strlen(trim($_POST["content"])) === 0) {
    throw new ClientException("Données invalides.");
  }
  $auth = new Auth();
  if ($selectedNoteID < 0) {
    $auth->createNewNote($_POST);
  } else {
    $auth->editNote($selectedNoteID, $_POST);
  }
  $response["confirmed"] = true;
} catch (ClientException $e) {
  $response["error"] = $e->getMessage();
} catch (Exception $e) {
  $response["error"] = "Une erreur serveur est survenue.";
}

echo json_encode($response);