<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
require_once "../class/Helpers/TextHelper.php";
AuthHelper::mustBeConnected("../index.php");

$errorMessage = null;
$allConnections = [];
try {
  $auth = new Auth();
  $client = $auth->getClient();
  $allConnections = $auth->getConnectionsOfCurrentClient();
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Une erreur serveur est survenue.";
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
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Application</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("index"); ?>
  <main>
    <?= HtmlBuilder::header(true, "Rechercher un mot de passe"); ?>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong><?= count($allConnections) ?></strong> connexion<?= count($allConnections) > 1 ? 's' : '' ?> :</p>
        <a class="button-primary" href="password.php">Ajouter une connexion</a>
      </div>
      <?php if ($errorMessage == null && count($allConnections) > 0): ?>
        <?php foreach ($allConnections as $connection): ?>
          <div class="container">
            <img src="../assets/private/default-password.png" alt="logo" />
            <div class="container-info">
              <h2><?= $client->hasStreamerMode() ? TextHelper::extractOf(htmlentities($connection->getTitle()), 2) : htmlentities($connection->getTitle()) ?></h2>
              <span><?= $client->hasStreamerMode() ? TextHelper::extractOfURL(htmlentities($connection->getURL() ?? '')) : htmlentities($connection->getURL() ?? '') ?></span>
              <span>Ajout??e le <?= $client->hasStreamerMode() ? '***' : $connection->getDate()->format('d/m/Y') ?></span>
            </div>
            <button id="star-button" title="Ajouter aux favoris">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
                <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
              </svg>
            </button>
            <?php if (!$client->hasStreamerMode()): ?>
              <a style="width:150px;" href="password.php?id=<?= $connection->getID() ?>" class="button-secondary">Consulter</a>
            <?php endif ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <script src="../js/sidebar.js"></script>
</body>
</html>