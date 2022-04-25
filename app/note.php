<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");

$labels = [];
$errorMessage = null;
$selectedNoteID = null;
$selectedNote = null;
$criticalError = false;
try {
  $auth = new Auth();
  $client = $auth->getClient();
  $labels = $auth->getAllLabels($client);
  if (isset($_GET["note"])) {
    $selectedNoteID = $_GET["note"];
    try {
      $selectedNote = $auth->getNote($selectedNoteID, $client);
    } catch (ClientException $e) {
      $criticalError = true;
      throw $e;
    }
  }
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Erreur serveur inconnue.";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../styles/root.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/sidebar.css">
  <link rel="stylesheet" href="../styles/note.css">
  <link rel="stylesheet" href="../styles/modal.css">
  <link rel="stylesheet" href="../styles/createNewLabel.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Ajouter une note</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("notes"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <div class="content-topbar-buttons">
          <a class="button-secondary" href="notes.php" style="width:150px;">Retour</a>
          <button class="button-primary" type="button" style="width:150px;" onclick="createNote()">Confirmer</button>
        </div>
      </div>
      <form id="form">
        <div class="container-maininfo">
          <input class="input" type="text" name="title" maxlength="50" spellcheck="false" autocomplete="off" placeholder="Titre de la note" required value="<?= $selectedNote !== null ? htmlentities($selectedNote->getTitle()) : '' ?>" />
          <div class="container-label-and-select">
            <div class="label" id="preview-label-color"></div>
            <select id="select-label" class="input" title="Label" name="labelID">
              <option value="default" data-color="#000" <?= $selectedNote !== null ? $selectedNote->getLabelID() === "default" : 'selected' ?>>Neutre</option>
              <?php foreach ($labels as $label): ?>
                <option value="<?= $label->getLabelID() ?>" data-color="<?= $label->getHexColor() ?>" <?= $selectedNote !== null && $selectedNote->getLabelID() === $label->getLabelID() ? 'selected' : '' ?>><?= htmlentities($label->getTitle()) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="container-create-label">
            <button type="button" class="button-text-form" onclick="openModal()">Créer un nouveau label</button>
          </div>
        </div>
        <textarea class="textarea" name="content" placeholder="Contenu de votre note"><?= $selectedNote !== null ? htmlentities($selectedNote->getContent()) : '' ?></textarea>
      </form>
      <?php if ($selectedNote !== null): ?>
        <div class="container-delete-note-button">
          <button id="delete-note-button" type="button" class="button-primary button-red">Supprimer</button>
        </div>
      <?php endif ?>
    </div>
  </main>

  <?= HtmlBuilder::modalLabel() ?>

  <script src="../js/select-label.js"></script>
  <script src="../js/sidebar.js"></script>
  <script src="../js/ModalHandler.js"></script>
  <script src="../js/handleAjaxRequests.js"></script>
  <script src="../js/labelModal.js"></script>
  <script>
    const preview = document.querySelector("#preview-label-color");
    const selectElement = document.querySelector("#select-label");

    function onChosenColor(title, color, labelID) {
      preview.style.backgroundColor = color;
      const option = document.createElement("option");
      option.setAttribute("value", labelID);
      option.setAttribute("data-color", color);
      option.setAttribute("selected", "");
      option.textContent = title;
      const currentLabel = document.querySelector("#select-label option[selected]");
      currentLabel.removeAttribute("selected");
      selectElement.appendChild(option);
    }
    
    const labelModal = new LabelModal(onChosenColor);
    function openModal() {
      labelModal.open();
    }

    const form = document.querySelector("#form");
    function createNote() {
      form.requestSubmit();
    }
    form.onsubmit = (e) => {
      e.preventDefault();
      const request = new AjaxRequest();
      request.onSuccess = (response) => {
        if (response.confirmed) {
          Swal.fire('Opération réussie', '', 'success').then(()=>window.location.href='notes.php');
        } else {
          Swal.fire("Erreur !", response.error ?? 'Une erreur inconnue est survenue.', 'error');
        }
      };
      request.onError = (status) => {
        Swal.fire("Erreur !", "Erreur ("+status+")", "error");
      };
      request.open("POST", "../sql/create_new_note.php?note=" + <?= $selectedNoteID === null ? '-1' : $selectedNoteID ?>);
      request.send(new FormData(form));
    };

    <?php if ($selectedNote !== null && $errorMessage === null): ?>
      const deletebutton = document.querySelector("#delete-note-button");
      deletebutton.onclick = () => {
        Swal.fire({
          title: "Supprimer cette note ?",
          text: "Désirez-vous supprimer définitivement cette note ? Il n'est pas possible d'annuler ça.",
          icon: "warning",
          confirmButtonText: "Supprimer",
          cancelButtonText: "Annuler",
          showLoaderOnConfirm:true,
          preConfirm: () => {
            const request = new AjaxRequest();
            request.onSuccess = (response) => {
              if (response.confirmed) {
                Swal.fire("Opération réussie", "Note supprimée", "success").then(()=>window.location.href='notes.php');
              } else {
                Swal.fire("Erreur !", response.error ?? 'Erreur inconnue', 'error');
              }
            };
            request.onError = (status) => {
              Swal.fire("Erreur !", "Erreur ("+status+")", "error");
            };
            request.open("GET", "../sql/delete_note.php?selectedID=" + <?= $selectedNoteID ?? '-1' ?>);
            request.send();
          },
        });
      };
    <?php endif ?>
  </script>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, $criticalError ? 'notes.php' : null) ?>
</body>
</html>