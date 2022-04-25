<?php
require_once '../class/Auth.php';

$client = null;
try {
  $auth = new Auth();
  $client = $auth->getClient();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Infos - Les mots de passe, comment se protéger ?</title>
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
          <!-- Label associé à la case. -->
          <label for="menu-cb" class="menu-label">
            <!-- Image du menu -->
            <i id="bottomangle" class="fa-solid fa-angle-down"></i></label
          >Informations
        </h3>
        <div id="menu">
          <a href="strength-intro.php"> Introduction </a>
          <a href="strength-what-is-it.php">
            Qu'est-ce que c'est, la "Force" d'un mot de passe ?
          </a>
          <a href="strength-attacks.php">
            Les principales attaques impliquant les mots de passe
          </a>
          <a href="strength-how-to-protect.php" class="active">
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
        <i class="fa-solid fa-lock"></i><a href="../">Accueil</a> &gt;
        <a href="strength-intro.php">Informations</a> &gt; Comment se
        protéger ?
      </h3>
      <article>
        <h1><i>Comment se protéger, en tant qu'utilisateur ?</i></h1>
        <p>Il faut utiliser des méthodes dont vous avez surement déjà entendu parler :</p>
        <ul>
          <li>Ne jamais utiliser un mot, prénom, patronyme, nom commun, nom de lieu.</li>
          <li>Ne jamais utiliser une suite de chiffres qui peut correspondre à une date.</li>
          <li>
            Toujours mélanger des sources d’inspiration mnémotechnique diverses, sans rapport entre
            elles, pour le rendre imprévisible. Utiliser des bouts de phrases, morceaux de mots,
            mais façon « cadavre exquis ».
          </li>
          <li>
            Avoir une longueur et un ensemble de caractères suffisamment important, même si ce n’est
            pas imposé par le service.
          </li>
          <li>En utilisant un mot de passe différent pour chaque service.</li>
        </ul>
        <i>C’est compliqué ?</i>
        <p>
          Oui, c’est vrai. La vie moderne n’est plus adaptée à nos mémoires organiques (et
          réciproquement). C’est pour cela qu’il y a des moyens mnémotechniques pour les mots de
          passe les plus courant. En plus de toutes les méthodes citées ci-dessus, si vous pouvez
          activer l’authentification à deux facteurs, faites-le. Lorsque vous entrez votre mot de
          passe, demander au système de vous demander un code sur un autre de vos appareils.
        </p>
        <p>
          Vous pouvez aussi bien sûr utiliser notre service, qui s'occupe de tout à votre place !
        </p>
      </article>
    </main>
    <script src="../js/infos-sidebar.js"></script>
  </body>
</html>
