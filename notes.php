<?php
require_once "class/HtmlBuilder.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="styles/root.css">
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/sidebar.css">
  <link rel="stylesheet" href="styles/notes.css">
  <title>SafeManager - Mes notes</title>
</head>
<body class="dark">
  <?= HtmlBuilder::sidebar("notes"); ?>
  <main>
    <?= HtmlBuilder::header(true, "Rechercher un mot de passe"); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong>3</strong> notes :</p>
        <a class="button-primary" href="note.php">Ajouter une note</a>
      </div>
      <div class="container-notes">
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <!-- todo: put a limit 200 characters -->
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.</p>
          <div class="label" data-color="pink"></div>
        </a>
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <p>Lorem ipsum dolor, siLorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.t amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.</p>
          <div class="label" data-color="pink"></div>
        </a>
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.
          </p>
          <div class="label" data-color="pink"></div>
        </a>
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.</p>
          <div class="label" data-color="pink"></div>
        </a>
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.</p>
          <div class="label" data-color="pink"></div>
        </a>
        <a href="note.php?note=yoyo" class="note" title="Consulter : Titre de la note">
          <h2>Une notre très secrète</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem repellendus qui suscipit minima excepturi obcaecati ipsam officiis iusto, nostrum, dignissimos minus quos quas velit? Earum, repudiandae. Quas fugiat modi numquam.</p>
          <div class="label" data-color="pink"></div>
        </a>
      </div>
    </div>
  </main>

  <script src="js/labels.js"></script>
  <script src="js/sidebar.js"></script>
</body>
</html>