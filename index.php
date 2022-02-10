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
  <link rel="stylesheet" href="styles/index.css">
  <title>SafeManager - Application</title>
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
      <a class="sidebar-item active" href="index.php">
        <i class="fa-solid fa-lock"></i><span>Mots de passe</span>
      </a>
      <a class="sidebar-item" href="notes.php">
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
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong>3</strong> connexions :</p>
        <a class="button-primary" href="password.php">Ajouter une connexion</a>
      </div>
      <div class="container">
        <img src="assets/private/default-password.png" alt="logo" />
        <div class="container-info">
          <h2>Google</h2>
          <span>google.fr</span>
          <span>Ajouté le 30/08/2021</span>
        </div>
        <button id="star-button" title="Ajouter aux favoris">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
            <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
          </svg>
        </button>
        <button style="width:150px;" class="button-secondary" type="button">Consulter</button>
      </div>
      <div class="container">
        <img src="assets/private/default-password.png" alt="logo" />
        <div class="container-info">
          <h2>Google</h2>
          <span>google.fr</span>
          <span>Ajouté le 30/08/2021</span>
        </div>
        <button id="star-button" title="Ajouter aux favoris">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
            <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
          </svg>
        </button>
        <button style="width:150px;" class="button-secondary" type="button">Consulter</button>
      </div>
      <div class="container">
        <img src="assets/private/default-password.png" alt="logo" />
        <div class="container-info">
          <h2>Google</h2>
          <span>google.fr</span>
          <span>Ajouté le 30/08/2021</span>
        </div>
        <button id="star-button" title="Ajouter aux favoris">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
            <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
          </svg>
        </button>
        <button style="width:150px;" class="button-secondary" type="button">Consulter</button>
      </div>
      <div class="container">
        <img src="assets/private/default-password.png" alt="logo" />
        <div class="container-info">
          <h2>Google</h2>
          <span>google.fr</span>
          <span>Ajouté le 30/08/2021</span>
        </div>
        <button id="star-button" title="Ajouter aux favoris">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
            <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
          </svg>
        </button>
        <button style="width:150px;" class="button-secondary" type="button">Consulter</button>
      </div>
      <div class="container">
        <img src="assets/private/default-password.png" alt="logo" />
        <div class="container-info">
          <h2>Google</h2>
          <span>google.fr</span>
          <span>Ajouté le 30/08/2021</span>
        </div>
        <button id="star-button" title="Ajouter aux favoris">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
            <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
          </svg>
        </button>
        <button style="width:150px;" class="button-secondary" type="button">Consulter</button>
      </div>
    </div>
  </main>
</body>
</html>