<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Ajouter une note</title>
</head>
<body class="dark">
  <?= HtmlBuilder::sidebar("notes"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <div class="content-topbar-buttons">
          <a class="button-secondary" href="notes.php" style="width:150px;">Retour</a>
          <button class="button-primary" type="button" style="width:150px;">Confirmer</button>
        </div>
      </div>
      <form>
        <div class="container-maininfo">
          <input class="input" type="text" name="title" maxlength="50" spellcheck="false" autocomplete="off" placeholder="Titre de la note" required />
          <div class="container-label-and-select">
            <div class="label" id="preview-label-color"></div>
            <select id="select-label" class="input" tite="Label" name="label">
              <option value="0" selected>Neutre</option>
              <option value="yoyo" data-color="green">Bancaire</option>
            </select>
          </div>
          <div class="container-create-label">
            <button type="button" class="button-text-form">Créer un nouveau label</button>
          </div>
        </div>
        <textarea class="textarea" name="content" placeholder="Contenu de votre note"></textarea>
      </form>
    </div>
  </main>

  <script src="../js/select-label.js"></script>
  <script src="../js/sidebar.js"></script>
</body>
</html>