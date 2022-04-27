<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");

$client = null;
$errorMessage = null;
$isCriticalError = false;
$numberOfNotes = 0;
$numberOfPasswords = 0;
try {
  $auth = new Auth();
  $client = $auth->getClient();
  $numberOfNotes = $client->hasStreamerMode() ? '**' : $auth->getNumberOfNotes($client);
  $numberOfPasswords = $client->hasStreamerMode() ? '**' : $auth->getNumberOfPasswords($client);
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Erreur serveur inconnue.";
  $isCriticalError = true;
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
  <link rel="stylesheet" href="../styles/settings.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Paramètres</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("settings"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <div></div>
        <?php if ($client->hasStreamerMode()): ?>
          <button class="button-primary" type="submit" style="width:260px;" onclick="removeStreamerMode()">Retirer le mode streamer</button>
        <?php else: ?>
          <button class="button-primary" type="submit" style="width:200px;" onclick="save()">Sauvegarder le profil</button>
        <?php endif ?>
      </div>
      <div class="container">
        <h2>Informations personnelles</h2>
        <div class="container-personal-info">
          <button class="button-container-image" type="button" onclick="askForImage()">
            <div class="overlay-modify-image">
              <i class="fa-solid fa-camera-retro"></i>
            </div>
            <img src="<?= $client->getAvatar() !== null ? '../assets/public/avatars/' . $client->getClientID() . '/' . $client->getAvatar() : '../assets/private/default-avatar.png' ?>" id="preview-avatar" alt="avatar" />
            <input type="file" name="avatar" id="avatar">
          </button>
          <div class="personal-container-inputs">
            <input class="input" type="<?= $client->hasStreamerMode() ? 'text' : 'email' ?>" name="email" maxlength="255" value="<?= $client->hasStreamerMode() ? '***' : htmlentities($client->getEmail() ?? '') ?>" spellcheck="false" autocomplete="off" placeholder="Adresse email" required />
            <input class="input" type="password" name="password" value="***" minlength="6" maxlength="255" spellcheck="false" placeholder="Mot de passe" required />
            <input class="input" type="text" name="firstname" maxlength="255" value="<?= $client->hasStreamerMode() ? '***' : htmlentities($client->getFirstname() ?? '') ?>" spellcheck="false" autocomplete="off" placeholder="Prénom" required />
            <input class="input" type="text" name="lastname" maxlength="255" value="<?= $client->hasStreamerMode() ? '***' : htmlentities($client->getLastname() ?? '') ?>" spellcheck="false" autocomplete="off" placeholder="Nom" required />
          </div>
        </div>
      </div>
      <div class="grid">
        <div class="container">
          <h2>Personnalisations</h2>
          <div class="container-customizations">
            <div class="container-switch">
              <span>Mode streamer</span>
              <button class="switch <?= $client->hasStreamerMode() ? 'on' : '' ?>" type="button" data-name="streamer-mode">
                <div class="switch-state"></div>
                <div class="switch-background"></div>
              </button>
            </div>
            <div class="container-switch">
              <span>Mode sombre</span>
              <button class="switch <?= $client->hasDarkMode() ? 'on' : '' ?>" type="button" data-name="dark-mode">
                <div class="switch-state"></div>
                <div class="switch-background"></div>
              </button>
            </div>
            <?php if (!$client->hasStreamerMode()): ?>
              <button class="button-primary button-red" onclick="deleteAccount()">Supprimer le compte</button>
            <?php endif ?>
          </div>
        </div>
        <div class="container">
          <h2>Statistiques</h2>
          <div class="container-stats">
            <div class="stat">
              <span>Nombre de mots de passe :</span>
              <b><?= $numberOfPasswords ?></b>
            </div>
            <div class="stat">
              <span>Nombre de notes :</span>
              <b><?= $numberOfNotes ?></b>
            </div>
            <div class="stat">
              <span>Nombre d'images :</span>
              <b>24</b>
            </div>
            <div class="stat">
              <span>Date d'inscription :</span>
              <b><?= $client->getRegistrationDate()->format('d/m/Y') ?></b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <input type="hidden" name="streamer-mode" value="<?= $client->hasStreamerMode() ? 'true' : 'false' ?>">
  <input type="hidden" name="dark-mode" value="<?= $client->hasDarkMode() ? 'true' : 'false' ?>">

  <script src="../js/sidebar.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/handleAjaxRequests.js"></script>
  <?php if (!$client->hasStreamerMode()): ?>
    <script>
      const inputDarkMode = document.querySelector("input[name='dark-mode']");
      const inputStreamMode = document.querySelector("input[name='streamer-mode']");
      const originalTheme = getTheme();
      const originalStreamMode = getStreamMode();
      const avatarInput = document.querySelector("#avatar");
      const avatarPreview = document.querySelector("#preview-avatar");
      let fileToUpload = null;

      function getTheme() {
        return inputDarkMode.value === "true" ? "dark" : "light";
      }

      function getStreamMode() {
        return inputStreamMode.value === "true" ? "enabled" : "disabled";
      }

      function askForImage() {
        avatarInput.click();
      }

      function updateAvatarPreview() {
        if (avatarInput.files && avatarInput.files.length > 0) {
          const file = avatarInput.files[0];
          fileToUpload = file;
          const url = URL.createObjectURL(file);
          avatarPreview.setAttribute("src", url);
        }
      }

      avatarInput.addEventListener("change", updateAvatarPreview);
      
      function getData() {
        const data = new FormData();
        data.append("email", document.querySelector("input[name='email']").value.trim());
        data.append("firstname", document.querySelector("input[name='firstname']").value.trim());
        data.append("lastname", document.querySelector("input[name='lastname']").value.trim());
        data.append("streamerMode", document.querySelector("input[name='streamer-mode']").value);
        data.append("darkMode", inputDarkMode.value);
        const passwordInput = document.querySelector("input[name='password']");
        if (passwordInput.value !== "***") {
          // If it's been modified
          data.append("password", passwordInput.value);
        }
        if (fileToUpload) {
          data.append("avatar", fileToUpload);
        }
        return data;
      }
      
      function save() {
        const data = getData();
        const request = new AjaxRequest();
        request.onSuccess = (response) => {
          console.log("response =", response);
          if (response.confirmed) {
            Swal.fire("Sauvegarde réussie", "", "success").then(()=>{
              if (originalTheme !== getTheme() || originalStreamMode !== getStreamMode()) {
                window.location.reload();
              }
            });
          } else {
            Swal.fire("Erreur", response.error ?? "Erreur inconnue", "error");
          }
        };
        request.onError = (status) => {
          Swal.fire("Erreur", "Erreur ("+status+")", "error");
        };
        request.open("POST", "../sql/save_profil.php");
        request.send(data);
      }

      function deleteAccount() {
        Swal.fire({
          title: "Suppression du compte",
          text: "Souhaitez-vous supprimer définitivement votre compte ? Cette action est irréversible.",
          icon: "warning",
          confirmButtonText: "Supprimer",
          cancelButtonText: "Annuler",
          showLoaderOnConfirm: true,
          preConfirm: () => {
            const request = new AjaxRequest();
            request.onSuccess = (response) => {
              if (response.confirmed) {
                Swal.fire("Suppression réussie", "", "success").then(()=>window.location.href='../index.php');
              } else {
                Swal.fire("Erreur !", response.error ?? "Une erreur inconnue s'est produite.", "error");
              }
            };
            request.onError = (status) => Swal.fire("Erreur !", "Erreur ("+status+")", "error");
            request.open("GET", "../sql/delete_account.php");
            request.send();
          },
        });
      }
    </script>
  <?php else: ?>
    <script>
      function removeStreamerMode() {
        const request = new AjaxRequest();
        request.onSuccess = (response) => {
          if (response.confirmed) {
            Swal.fire("Streamer Mode retiré", "", "success").then(()=>window.location.reload());
          } else {
            Swal.fire("Erreur !", response.error ?? "Une erreur inconnue s'est produite.", "error");
          }
        };
        request.onError = (status) => Swal.fire("Erreur !", "Erreur ("+status+")", "error");
        request.open("GET", "../sql/remove_streamer_mode.php");
        request.send();
      }
    </script>
  <?php endif ?>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, $isCriticalError ? '../index.php' : null) ?>
</body>
</html>