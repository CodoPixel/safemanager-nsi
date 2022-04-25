<?php
require_once '../class/Auth.php';

$client = null;
try {
  $auth = new Auth();
  $client = $auth->getClient();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Infos sur les mots de passe</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../styles/infos.css" />
  </head>
  <body class="<?= $client !== null && $client->hasDarkMode() ? 'dark' : '' ?>">
    <div class="shader"></div>
    <aside id="sidebar">
      <nav>
        <h3>
          <label for="menu-cb" class="menu-label">
            <i id="bottomangle" class="fa-solid fa-angle-down"></i></label
          >Informations
        </h3>
        <div id="menu">
          <a href="strength-intro.php" class="active">
            Introduction
          </a>
          <a href="strength-what-is-it.php">
            Qu'est-ce que c'est, la "Force" d'un mot de passe ?
          </a>
          <a href="strength-attacks.php">
            Les principales attaques impliquant les mots de passe
          </a>
          <a href="strength-how-to-protect.php">
            Comment se protéger, en tant qu'utilisateur ?
          </a>
        </div>
      </nav>
    </aside>
    <main>
      <button class="hamburger" type="button">
        <div></div>
        <div></div>
        <div></div>
      </button>
      <h3 id="fil-arianne">
        <i class="fa-solid fa-lock"></i><a href="../">Accueil</a> >
        <a href="strength-intro.php">Informations</a> > Introduction
      </h3>
      <article>
        <h1>Bienvenue</h1>
        <p>
          SafeManager est un projet étudiant pour souligner l’importance de protéger ses données sur
          Internet. Nous vous proposons en parallèle une source d’information centralisée pour vous
          permettre d’en savoir plus sur la protection des données sur Internet.
        </p>
        <div>
          <ul id="links">
            <li>
              <a href="strength-what-is-it.php">Qu'est-ce que la "force" d'un mot de passe ?</a>
            </li>
            <li><a href="strength-attacks.php">Les différents types d'attaques</a></li>
            <li><a href="strength-how-to-protect.php">Se protéger en tant qu'utilisateur</a></li>
          </ul>
        </div>
      </article>
    </main>
    <script src="../js/infos-sidebar.js"></script>
  </body>
</html>
