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
  <aside>
    <h1 class="appname">SafeManager</h1>
    <div class="sidebar-containerProfile">
      <img alt="avatar" src="assets/private/default-avatar.png" />
      <span>Bienvenue,</span>
      <h1>Thomas Gysemans</h1>
    </div>
    <nav>
      <a class="sidebar-item" href="index.php">
        <i class="fa-solid fa-lock"></i><span>Mots de passe</span>
      </a>
      <a class="sidebar-item active" href="notes.php">
        <i class="fa-regular fa-note-sticky"></i><span>Notes</span>
      </a>
      <a class="sidebar-item" href="images.php">
        <i class="fa-regular fa-image"></i><span>Images</span>
      </a>
      <a class="sidebar-item" href="settings.php">
        <i class="fa-solid fa-gear"></i><span>Paramètres</span>
      </a>
      <a class="sidebar-item" href="../index.php">
        <i class="fa-solid fa-globe"></i><span>Sites web</span>
      </a>
    </nav>
  </aside>
  <main>
    <header>
      <a title="Créer un mot de passe" class="header-key" href="password.php"><i class="fa-solid fa-key"></i></a>
      <input type="text" class="input" placeholder="Rechercher un mot de passe" id="search" maxlength="50" autocomplete="off" spellcheck="false" />
    </header>
    <div>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong>3</strong> notes :</p>
        <button class="button-primary" type="button">Ajouter une note</button>
      </div>
      
    </div>
  </main>
</body>
</html>