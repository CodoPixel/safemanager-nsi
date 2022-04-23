<?php
require_once "class/Auth.php";
AuthHelper::mustBeNotConnected("index.php");

$errorMessage = null;
try {
  if (!empty($_POST)) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    $auth = new Auth();
    $auth->register($email, $password, $firstname, $lastname);

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
    <link rel="stylesheet" href="styles/register.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - S'inscrire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  </head>
  <body>
    <div class="box">
      <form method="POST">
        <h1>S'inscrire</h1>
        <p>
          Vous avez déjà un compte ? <a href="login.php" title="Se connecter">Se connecter</a>
        </p>

        <div class="email">
          <input name="email" type="email" id="mail" placeholder="Adresse email" required />
        </div>

        <div class="container-names">
          <div class="first-name">
            <input name="firstname" type="text" id="name" placeholder="Prénom" value="<?= htmlentities($_POST['firstname'] ?? '') ?>" required />
          </div>
          <div class="family-name">
            <input name="lastname" type="text" id="family-name" placeholder="Nom" value="<?= htmlentities($_POST['lastname'] ?? '') ?>" required />
          </div>
        </div>

        <div class="password">
          <input
            name="password"
            type="password"
            id="password"
            placeholder="Mot de passe"
            value="<?= htmlentities($_POST['email'] ?? '') ?>"
            required
          />
          <i id="eye" class="fa-solid fa-eye" onclick="togglePasswordType()"></i>
        </div>

        <div class="access">
          <button type="submit">
            Créer mon compte
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </form>
    </div>
    <script src="js/logging.js"></script>
  </body>
</html>
