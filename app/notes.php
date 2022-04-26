<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
require_once "../class/Helpers/TextHelper.php";
AuthHelper::mustBeConnected("../index.php");

$notes = [];
$errorMessage = null;
try {
  $auth = new Auth();
  $client = $auth->getClient();
  $notes = $auth->getAllNotes($client);
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Une erreur d'origine inconnue s'est produite.";
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
  <link rel="stylesheet" href="../styles/notes.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Mes notes</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("notes"); ?>
  <main>
    <?= HtmlBuilder::header(true, "Rechercher un mot de passe"); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong><?= count($notes) ?></strong> note<?= count($notes) > 1 ? 's' : '' ?> :</p>
        <a class="button-primary" href="note.php">Ajouter une note</a>
      </div>
      <div class="container-notes">
        <?php if ($errorMessage === null && count($notes) > 0): ?>
          <?php foreach ($notes as $note): ?>
            <a href="<?= $client->hasStreamerMode() ? '' : 'note.php?note=' . $note->getID() ?>" style="<?= $client->hasStreamerMode() ? 'cursor:not-allowed' : '' ?>" class="note" title="Consulter : <?= htmlentities($note->getTitle()) ?>">
              <h2><?= $client->hasStreamerMode() ? TextHelper::extractOf(htmlentities($note->getTitle()), 2) : htmlentities($note->getTitle()) ?></h2>
              <p><?= $client->hasStreamerMode() ? TextHelper::extractOf(htmlentities($note->getContent()), 3) : htmlentities($note->getContent()) ?></p>
              <div class="label" data-color="<?= $note->getLabel() === null ? "black" : $note->getLabel()->getHexColor() ?>"></div>
            </a>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
  </main>

  <script src="../js/labels.js"></script>
  <script src="../js/sidebar.js"></script>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, null) ?>
</body>
</html>