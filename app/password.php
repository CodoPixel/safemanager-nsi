<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");

$selectedConnection = null;
$seletedID = null;
$errorMessage = null;
try {
  if (!empty($_GET)) {
    $auth = new Auth();
    $client = $auth->getClient();
    $selectedID = $_GET['id'];
    $selectedConnection = $auth->getSelectedConnection((int)$selectedID, $client);
  }
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Une erreur serveur survenue.";
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
  <link rel="stylesheet" href="../styles/password.css">
  <link rel="stylesheet" href="../styles/circularProgressBar.css">
  <link rel="stylesheet" href="../styles/generatePasswordModal.css">
  <link rel="stylesheet" href="../styles/modal.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Ajouter un mot de passe</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("index"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <div class="content-topbar-buttons">
          <a class="button-secondary" href="index.php" style="width:150px;">Retour</a>
          <button class="button-primary" type="submit" style="width:150px;" onclick="submit()">Confirmer</button>
        </div>
      </div>
      <?php if ($errorMessage === null): ?>
        <form id="form">
          <div class="container-maininfo">
            <img src="../assets/private/default-password.png" alt="logo" />
            <div class="container-maininputs">
              <input class="input" type="text" name="title" maxlength="255" spellcheck="false" autocomplete="off" required placeholder="Titre" value="<?= $selectedConnection ? htmlentities($selectedConnection->getTitle()) : '' ?>" />
              <input class="input" type="url" name="url" maxlength="255" spellcheck="false" autocomplete="off" placeholder="URL (facultatif)" value="<?= $selectedConnection ? htmlentities($selectedConnection->getURL() ?? '') : '' ?>" />
              <input class="input" type="text" id="password-for-connection" name="password" maxlength="255" spellcheck="false" autocomplete="off" required placeholder="Mot de passe" value="<?= $selectedConnection ? htmlentities($selectedConnection->getPassword()) : '' ?>" />
              <button type="button" class="button-primary" onclick="generatePasswordForNewConnection()">Générer un mot de passe</button>
            </div>
          </div>
          <div class="container-relatedinfo">
            <h2>Informations annexes</h2>
            <div class="container-relatedinfo-inputs">
              <input class="input" type="email" name="email" maxlength="255" placeholder="Adresse mail" value="<?= $selectedConnection ? htmlentities($selectedConnection->getEmail() ?? '') : '' ?>" />
              <input class="input" type="number" name="age" max="130" min="1" placeholder="Age" value="<?= $selectedConnection ? $selectedConnection->getAge() ?? '' : '' ?>" />
              <select name="sex" class="input" title="Sexe">
                <?php foreach (Sex::SEXES as $i => $str): ?>
                  <option value="<?= $i ?>" <?= $selectedConnection !== null && $i === $selectedConnection->getSex()->getNumber() ? 'selected' : '' ?>><?= $str ?></option>
                <?php endforeach ?>
              </select>
              <input class="input" type="text" name="pseudo" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Pseudonyme" value="<?= $selectedConnection ? htmlentities($selectedConnection->getPseudo() ?? '') : '' ?>" />
              <input class="input" type="text" name="lastname" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Nom" value="<?= $selectedConnection ? htmlentities($selectedConnection->getLastname() ?? '') : '' ?>" />
              <input class="input" type="text" name="firstname" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Prénom" value="<?= $selectedConnection ? htmlentities($selectedConnection->getFirstname() ?? '') : '' ?>" />
            </div>
          </div>
          <div class="container-moreinfo">
            <h2>Plus d'informations</h2>
            <textarea name="more" class="textarea" placeholder="Toute autre information"><?= $selectedConnection ? htmlentities($selectedConnection->getMore() ?? '') : '' ?></textarea>
          </div>
        </form>
        <?php if ($selectedConnection !== null): ?>
          <div class="container-delete-connection-button">
            <button id="delete-connection-button" type="button" class="button-primary button-red">Supprimer</button>
          </div>
        <?php endif ?>
      <?php endif; ?>
    </div>
  </main>

  <?= HtmlBuilder::modalGeneratePassword() ?>

  <script src="../js/sidebar.js"></script>
  <script src="../js/ModalHandler.js"></script>
  <script src="../js/calcScoreOfPassword.js"></script>
  <script src="../js/circularProgressBarHandler.js"></script>
  <script src="../js/generatePasswordModal.js"></script>
  <script src="../js/app/generatePassword.js"></script>
  <script src="../js/handleAjaxRequests.js"></script>
  <script>
    const form = document.getElementById("form");
    form.onsubmit = (e) => {
      e.preventDefault();
      const request = new AjaxRequest();
      request.onSuccess = (response) => {
        console.log("response =", response);
        if (response.confirmed) {
          Swal.fire('Opération réussie', "Données enregistrées.", "success").then(() => {
            window.location.href='index.php';
          });
        } else {
          Swal.fire('Erreur !', response.error ?? 'Erreur inconnue', 'error');
        }
      };
      request.onError = (status) => {
        Swal.fire('Erreur !', 'Erreur ('+status+')', 'error');
      };
      request.open("POST", "../sql/add_new_connection.php?selectedID=" + <?= $selectedID ?? '-1' ?>); 
      request.send(new FormData(form));
    };
    function submit() {
      form.requestSubmit();
    }

    <?php if ($selectedConnection !== null && $errorMessage === null): ?>
      const deletebutton = document.querySelector("#delete-connection-button");
      deletebutton.onclick = () => {
        Swal.fire({
          title: "Supprimer cette connection ?",
          text: "Désirez-vous supprimer définitivement cette connection ? Il n'est pas possible d'annuler ça.",
          icon: "warning",
          confirmButtonText: "Supprimer",
          cancelButtonText: "Annuler",
          showLoaderOnConfirm:true,
          preConfirm: () => {
            const request = new AjaxRequest();
            request.onSuccess = (response) => {
              if (response.confirmed) {
                Swal.fire("Opération réussie", "Connexion supprimée", "success").then(()=>window.location.href='index.php');
              } else {
                Swal.fire("Erreur !", response.error ?? 'Erreur inconnue', 'error');
              }
            };
            request.onError = (status) => {
              Swal.fire("Erreur !", "Erreur ("+status+")", "error");
            };
            request.open("GET", "../sql/delete_connection.php?selectedID=" + <?= $selectedID ?? '-1' ?>);
            request.send();
          },
        });
      };
    <?php endif ?>
  </script>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, "index.php") ?>
</body>
</html>