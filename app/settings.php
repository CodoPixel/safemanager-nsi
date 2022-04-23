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
  <link rel="stylesheet" href="../styles/settings.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Paramètres</title>
</head>
<body class="dark">
  <?= HtmlBuilder::sidebar("settings"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="container">
        <h2>Informations personnelles</h2>
        <div class="container-personal-info">
          <button class="button-container-image" type="button">
            <div class="overlay-modify-image">
              <i class="fa-solid fa-camera-retro"></i>
            </div>
            <img src="../assets/private/default-avatar.png" alt="avatar" />
          </button>
          <div class="personal-container-inputs">
            <input class="input" type="email" name="email" value="gysemansthomas@gmail.com" spellcheck="false" autocomplete="off" placeholder="Adresse email" required />
            <input class="input" type="password" name="password" value="*****" spellcheck="false" placeholder="Mot de passe" required />
            <input class="input" type="text" name="firstname" value="Thomas" spellcheck="false" autocomplete="off" placeholder="Prénom" required />
            <input class="input" type="text" name="lastname" value="Gysemans" spellcheck="false" autocomplete="off" placeholder="Nom" required />
          </div>
        </div>
      </div>
      <div class="grid">
        <div class="container">
          <h2>Personnalisations</h2>
          <div class="container-customizations">
            <div class="container-switch">
              <span>Mode streamer</span>
              <button class="switch" type="button" data-name="streamer-mode">
                <div class="switch-state"></div>
                <div class="switch-background"></div>
              </button>
            </div>
            <div class="container-switch">
              <span>Mode sombre</span>
              <button class="switch on" type="button" data-name="dark-mode">
                <div class="switch-state"></div>
                <div class="switch-background"></div>
              </button>
            </div>
            <button class="button-primary button-red">Supprimer le compte</button>
          </div>
        </div>
        <div class="container">
          <h2>Statistiques</h2>
          <div class="container-stats">
            <div class="stat">
              <span>Nombre de mots de passe :</span>
              <b>13</b>
            </div>
            <div class="stat">
              <span>Nombre de notes :</span>
              <b>26</b>
            </div>
            <div class="stat">
              <span>Nombre d'images :</span>
              <b>24</b>
            </div>
            <div class="stat">
              <span>Date d'inscription :</span>
              <b>08/02/2022</b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <input type="hidden" name="streamer-mode" value="false">
  <input type="hidden" name="dark-mode" value="true">

  <script src="../js/sidebar.js"></script>
  <script src="../js/settings.js"></script>
</body>
</html>