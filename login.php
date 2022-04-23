<?php
require_once 'class/Auth.php';
require_once 'class/HtmlBuilder.php';
AuthHelper::mustBeNotConnected("index.php");

$errorMessage = null;
try {
  if (!empty($_POST)) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $auth = new Auth();
    $auth->loginWithCredentials($email, $password);

    header("Location: app/index.php");
  }
} catch (PDOException $e) {
  die("Une erreur fatale est survenue.");
} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Se connecter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  </head>
  <body>
    <div class="box">
      <form method="POST">
        <h1>Se connecter</h1>
        <p>
          Vous n'avez pas de compte ?
          <a href="register.php" title="Se créer compte">S'inscrire</a>
        </p>

        <div class="email">
          <input type="email" id="mail" name="email" placeholder="Adresse email" value="<?= htmlentities($_POST['email'] ?? '') ?>" required />
        </div>

        <div class="password">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Mot de passe"
            required
          />
          <i id="eye" class="fa-solid fa-eye" onclick="togglePasswordType()"></i>
        </div>

        <div class="access">
          <button type="submit">
            Accéder à mon compte
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </form>
    </div>
    <script src="js/logging.js"></script>
    <?= HtmlBuilder::handleErrorMessage($errorMessage, null) ?>
  </body>
</html>
