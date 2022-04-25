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
    <title>SafeManager - Infos - Qu'est-ce qu'un mot de passe "fort" ?</title>
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
          <a href="strength-what-is-it.php" class="active">
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
        <i class="fa-solid fa-lock"></i><a href="../">Accueil</a> &gt;
        <a href="strength-intro.php">Informations</a> &gt; La "Force" d'un mot de passe
      </h3>
      <article>
        <h1>La "Force" d'un mot de passe</h1>
        <div>
          <ul id="links">
            <li><a href="#def">Qu'est-ce que c'est ?</a></li>
            <li><a href="#renforcer">Renforcer son mot de passe</a></li>
          </ul>
        </div>
        <h2 id="def">Qu'est-ce que la "force" d'un mot de passe ?</h2>
        <p>
          La force est le nom communément donné à la capacité qu’a un mot de passe à résister à une
          énumération de tous les mots de passe possibles, c’est-à-dire que, si l’on commençait à
          composer des mots de passe aléatoires pour essayer de trouver le vôtre, après combien de
          temps le trouverions-nous ? <br />
          Cette « force » dépend de la longueur L du mot de passe (le nombre de caractères qui le
          composent), et du nombre N de caractères possibles (si vous utilisez des minuscules
          uniquement, des minuscules ET des majuscules, etc). <br />
          Pour la calculer facilement, il faut imaginer que le mot de passe est choisi de façon
          aléatoire. Dans ce cas, la « force » se calcule par la formule N<sup>L</sup>. <br />
          Mais la valeur obtenue est-elle vraiment suffisante ? Choisissez-vous réellement un mot de
          passe de façon aléatoire ?
        </p>
        <h2 id="renforcer">Renforcer son mot de passe</h2>
        <div>
          <p>
            Vous pouvez alors vous poser ces questions :
            <i>Comment renforcer mon mot de passe ? Quels critères respecter ?</i> <br />L’une des
            choses importantes à savoir est qu’il vaut mieux agrandir la longueur (L) d’un mot de
            passe plutôt que de chercher à le rendre plus complexe. <br />Voici un tableau donnant
            grossièrement la force de votre mot de passe, en fonction de L et N définis
            précedemment. (Il ne s’agit pas ici du calcul avec la formule énoncée plus tôt.)
          </p>
          <table id="t1">
            <tr>
              <th class="th1">Valeur de N et de L</th>
              <th class="th1">Qualification de la force du mot de passe</th>
            </tr>
            <tr>
              <td class="td1">L = 8 ; N = 70</td>
              <td class="td1">Très faible</td>
            </tr>
            <tr>
              <td class="td1">L = 10 ; N = 90</td>
              <td class="td1">Faible</td>
            </tr>
            <tr>
              <td class="td1">L = 12 ; N = 90</td>
              <td class="td1">Faible</td>
            </tr>
            <tr>
              <td class="td1">L = 16 ; N = 36</td>
              <td class="td1">Moyen</td>
            </tr>
            <tr>
              <td class="td1">L = 16 ; N = 90</td>
              <td class="td1">Fort</td>
            </tr>
            <tr>
              <td class="td1">L = 20 ; N = 90</td>
              <td class="td1">Fort</td>
            </tr>
          </table>
          <!-- Aide tableau : 
                    https://openclassrooms.com/fr/courses/1603881-apprenez-a-creer-votre-site-web-avec-html5-et-css3/1606851-ajoutez-des-tableaux#:~:text=En%20r%C3%A9sum%C3%A9%201%20Un%20tableau%20s%27ins%C3%A8re%20avec%20la,tableau%20avec%20border%20.%20...%20Plus%20d%27articles...%20
                    -->
        </div>
      </article>
    </main>
    <script src="../js/infos-sidebar.js"></script>
  </body>
</html>
