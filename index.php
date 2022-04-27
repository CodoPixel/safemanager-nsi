<?php
require_once 'class/HtmlBuilder.php';
require_once 'class/Auth.php';

$client = null;
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="styles/root.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/circularProgressBar.css">
    <link rel="stylesheet" href="styles/modal.css">
    <link rel="stylesheet" href="styles/generatePasswordModal.css">
    <link rel="stylesheet" href="styles/testPasswordModal.css">
    <link rel="stylesheet" href="styles/homepage.css" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>SafeManager - Le logiciel en ligne pour gérer vos mots de passe</title>
  </head>

  <body class="<?= $client !== null && $client->hasDarkMode() ? 'dark' :'' ?>">
    <div class="page">
      <header>
        <i class="fa-solid fa-lock"></i>
        <nav>
          <a href="/">Accueil</a>
          <a href="infos/strength-intro.php">Informations</a>
          <a onclick="openGeneratePasswordModal()">Générateur</a>
          <?php if (AuthHelper::isConnected()): ?>
            <a href="app/index.php">Application</a>
          <?php else: ?>
            <a href="login.php">Compte</a>
          <?php endif; ?>
        </nav>
      </header>
      <div id="safemanager">
        <h2><span>SafeManager</span></h2>
        Bienvenue sur le site SafeManager ! Ce dernier vous offre diverses fonctionnalités
        concernant vos mots de passes. Evaluez la force de votre mot de passe, créez-en un
        aléatoirement, triez, classez etc. Venez surfer sur notre site web, mais attention 🤪
        n'oubliez pas votre planche !
        <button id="test" onclick="openTestPasswordModal()">Tester votre mot de passe</button>
        <button id="savoir" onclick="window.location.href='#more'">En savoir plus</button>
      </div>
      <img id="guy" src="assets/private/security.svg" />
      <img id="circle" src="assets/private/circle.svg" alt="" />
      <div id="bloc1">
        <section id="more">
          <img id="secure_login" src="assets/private/login.svg" />
          <div id="mdp">
            <h2><span>Protégez vos mots de passe</span></h2>
            <p>
              Bénéficiez de notre algorithme révolutionnaire pour protéger vos mots de passe d'une manière très poussée et sûre.
            </p>
            <button class="begin" onclick="window.location.href='app/index.php'">Commencer</button>
          </div>
        </section>
        <section>
          <img id="secure_files" src="assets/private/secure-files.svg" />
          <div>
            <h2><span>Protégez vos images</span></h2>
            <p>
              Nous offrons également un service de protection de vos images de sorte à ce que nous n'ayez pas besoin de les conserver dans votre galerie photos (c'est risqué !).
            </p>
            <button class="begin" onclick="window.location.href='app/images.php'">Commencer</button>
          </div>
        </section>
        <section>
          <img id="education" src="assets/private/education.svg" />
          <div>
            <h2><span>Nos cours de sécurité</span></h2>
            <p>
              En plus de proposer des services concrets, nous vous offrons également la possibilité d'en savoir plus sur les méthodes et les bonnes habitudes à prendre quand il s'agit de protéger vos données personnelles (et surtout vos mots de passe).
            </p>
            <button class="begin" onclick="window.location.href='infos/strength-intro.php'">Consulter</button>
          </div>
        </section>
        <footer>
          <p id="passwordsecure">Un vrai&nbsp;<span id="blue">mot de passe sécurisé</span></p>
          <button id="generate" onclick="openGeneratePasswordModal()">Générer</button>
          <button id="testyour" onclick="openTestPasswordModal()">Tester le vôtre</button>
        </footer>
      </div>
    </div>
    <div id="footer">
      <div class="footer-container" id="footer-title">
        <h2>SafeManager</h2>
      </div>
      <div class="footer-container" id="about">
        <h3>À propos</h3>
        <p>
          Un projet étudiant pour souligner l’importance de protéger ses données sur Internet. Ps :
          N'oubliez pas votre planche de surf hein ;)
        </p>
      </div>
      <div class="footer-container" id="plan">
        <h3>Plan du site</h3>
        <ul>
          <li><a id="lien" href="/">Accueil</a></li>
          <li><a id="lien" href="infos/strength-intro.php">Informations</a></li>
          <li><a id="lien" href="login.php">Se Connecter</a></li>
        </ul>
      </div>
      <div class="footer-container">
        <h3 id="creators">Créateurs</h3>
        <ul id="names">
          <li>Wadi B.</li>
          <li>Paul D.</li>
          <li>Thomas G.</li>
          <li>Lucas V.</li>
        </ul>
      </div>
    </div>

    <?= HtmlBuilder::modalGeneratePassword() ?>

    <?= HtmlBuilder::modalTestPassword() ?>

    <script src="js/ModalHandler.js"></script>
    <script src="js/calcScoreOfPassword.js"></script>
    <script src="js/circularProgressBarHandler.js"></script>
    <script src="js/generatePasswordModal.js"></script>
    <script src="js/testPasswordModal.js"></script>
    <script>
      const modalForGeneration = new GeneratePasswordModal();
      function openGeneratePasswordModal() {
        modalForGeneration.open();
      }

      function openTestPasswordModal() {
        window.ModalHandler.open('#modal-test-password');
      }
    </script>
  </body>
</html>
