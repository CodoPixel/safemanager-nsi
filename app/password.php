<?php
require_once "../class/HtmlBuilder.php";
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
  <title>SafeManager - Ajouter un mot de passe</title>
</head>
<body class="dark">
  <?= HtmlBuilder::sidebar("index"); ?>
  <main>
    <?= HtmlBuilder::header(true, null); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <div class="content-topbar-buttons">
          <a class="button-secondary" href="index.php" style="width:150px;">Retour</a>
          <button class="button-primary" type="button" style="width:150px;">Confirmer</button>
        </div>
      </div>
      <form>
        <div class="container-maininfo">
          <img src="../assets/private/default-password.png" alt="logo" />
          <div class="container-maininputs">
            <input class="input" type="text" name="title" maxlength="255" spellcheck="false" autocomplete="off" required placeholder="Titre" />
            <input class="input" type="url" name="url" maxlength="255" spellcheck="false" autocomplete="off" placeholder="URL (facultatif)" />
            <input class="input" type="text" name="password" maxlength="255" spellcheck="false" autocomplete="off" required placeholder="Mot de passe" />
            <button type="button" class="button-primary">Générer un mot de passe</button>
          </div>
        </div>
        <div class="container-relatedinfo">
          <h2>Informations annexes</h2>
          <div class="container-relatedinfo-inputs">
            <input class="input" type="email" name="email" maxlength="255" placeholder="Adresse mail" />
            <input class="input" type="number" name="age" max="130" min="1" placeholder="Age" />
            <select name="sexe" class="input" title="Sexe">
              <option value="0" selected>Non défini</option>
              <option value="1">Homme</option>
              <option value="2">Femme</option>
            </select>
            <input class="input" type="text" name="pseudo" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Pseudonyme" />
            <input class="input" type="text" name="lastname" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Nom" />
            <input class="input" type="text" name="firstname" maxlength="255" spellcheck="false" autocomplete="off" placeholder="Prénom" />
          </div>
        </div>
        <div class="container-moreinfo">
          <h2>Plus d'informations</h2>
          <textarea name="more" class="textarea" placeholder="Toute autre information"></textarea>
        </div>
      </form>
    </div>
  </main>

  <script src="js/sidebar.js"></script>
</body>
</html>