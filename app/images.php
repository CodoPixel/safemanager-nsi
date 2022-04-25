<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");

$errorMessage = null;
$criticalError = false;
try {
  $auth = new Auth();
  $client = $auth->getClient();
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Une erreur serveur est survenue.";
  $criticalError = true;
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
  <link rel="stylesheet" href="../styles/images.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Mes images</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("images"); ?>
  <main>
    <?= HtmlBuilder::header(true, "Rechercher une image"); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong>3</strong> images :</p>
        <button class="button-primary" type="button">Ajouter une image</button>
      </div>
      <div class="grid">
        <button class="container-image" type="button">
          <div class="image-overlay"></div>
          <img src="../assets/private/test-image.jpeg" alt="aucune description" />
        </button>
        <button class="container-image" type="button">
          <div class="image-overlay"></div>
          <img src="../assets/private/test-image-2.jpeg" alt="aucune description" />
        </button>
        <button class="container-image" type="button">
          <div class="image-overlay"></div>
          <img src="../assets/private/test-image.jpeg" alt="aucune description" />
        </button>
        <button class="container-image" type="button">
          <div class="image-overlay"></div>
          <img src="../assets/private/test-image-2.jpeg" alt="aucune description" />
        </button>
        <button class="container-image" type="button">
          <div class="image-overlay"></div>
          <img src="../assets/private/test-image.jpeg" alt="aucune description" />
        </button>
      </div>
    </div>
  </main>

  <div class="presentation" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Présentation plus large de votre image">
    <button type="button" id="cross" title="Fermer la présentation"><i class="fa-solid fa-times"></i></button>  
    <button type="button" id="left" title="Image précédente"><i class="fa-solid fa-angle-left"></i></button>
    <div class="presentation-container-image">
      <img src="../assets/private/test-image.jpeg" alt="aucune description" id="preview-image" />
    </div>
    <button type="button" id="right" title="Image suivate"><i class="fa-solid fa-angle-right"></i></button>
  </div>

  <script src="../js/sidebar.js"></script>
  <script src="../js/image-presentation.js"></script>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, $criticalError ? '../index.php' : null) ?>
</body>
</html>