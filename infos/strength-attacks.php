<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Infos - Les différentes attaques possibles sur vos mots de passe.</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../styles/infos.css" />
  </head>
  <body>
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
          <a href="strength-attacks.php" class="active">
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
        <a href="strength-intro.php">Informations</a> &gt; Les
        différents types d'attaque
      </h3>
      <article>
        <h1>Les principales attaques impliquant les mots de passe</h1>
        <div>
          <ul id="links">
            <li><a href="#passwordguessing">Le "Password guessing"</a></li>
            <li>
              <a href="#credentialstuffing">Le "Credential stuffing" et le "Password spraying"</a>
            </li>
            <li><a href="#passwordcracking">Le "Password cracking"</a></li>
            <li><a href="#conculsion">Lien entre les différents attaques</a></li>
          </ul>
        </div>
        <h2 id="passwordguessing">Le "Password guessing"</h2>
        <p>
          Il s’agit d’<u>essayer différents de mots de passe pour un utilisateur ciblé.</u><br />
          On l’utilise souvent pour confirmer des listes d’identifiants et de mots de passe
          <u>préalablement obtenus</u> par d’autres moyens. <br />
          La personne qui vous attaque va essayer des mots très courants puis des combinaisons de
          mots en rapport avec les informations collectées sur vous (Date de naissance, noms
          d’animaux, conjoint.e, etc), obtenues réellement ou sur les réseaux sociaux.
        </p>
        <h2 id="credentialstuffing">Le "Credential stuffing" et le "Password spraying"</h2>
        <p>
          On utilise souvent cette attaque après une première intrusion dans un premier système
          d’information, pour gagner d’autres positions. <br />
          <i>Hé oui, après avoir trouvé votre mot de passe Facebook, pourquoi s’arrêter là ?</i>
          <br />
          L’attaquant va donc utiliser un petit nombre de mots de passe connus, et de noms
          d’utilisateurs connus, en faisant des essais sur un grand nombre de services, cette fois.
          <br />
          Il peut aussi vérifier ou améliorer la qualité des listes identifiants/mots de passe sur
          le marché noir. On appelle ça le “Credential stuffing”
        </p>
        <h2 id="passwordcracking">Le "Password cracking"</h2>
        <p>
          Ce type d’attaque dépend beaucoup de la capacité de calcul dont dispose l’attaquant.
          <br />
          La loi de Moore indique, grossièrement, que
          <u>la puissance de calcul des nouveaux matériels double tous les 18 mois</u>. <br />
          <b
            >Par conséquent, si votre mot de passe ne change pas, l’attaquant sera donc avantagé au
            fur et à mesure du temps qui passe.</b
          >
          <br />
          <i
            >Mais alors combien de temps faut-il à un attaquant pour parcourir tous les mots de
            passe possibles ?</i
          >
          <br />
          Si on se donne un ensemble de caractères, une longueur maximale, et une puissance de
          calcul, il est facile de l’estimer. <br />
          L’attaquant connaît une liste de mots de passe chiffrés (« hachés »), et, chez lui sur son
          propre ordinateur, essaie de retrouver les mots de passe en clair.
        </p>
        <p>
          <i>Qu’est-ce qu’un mot de passe chiffré ?</i> <br />
          C’est un mot de passe qui a été obtenu après une fuite de données, et qui, par sécurité,
          avait été chiffré par l’exploitant du système ayant eu la fuite. Cela permet d’empêcher,
          ou au moins ralentir, l’utilisation des mots de passe volés, sur d’autres services. <br />
          Pour essayer d’évaluer le temps que prendrait un pirate pour déchiffrer des mots de passe
          volés, intéressons-nous à cet appareil :
        </p>
        <div id="mineur">
          <img id="bitcoin" src="../assets/private/Bitcoin.jpg" alt="Mineur de Bitcoin" />
          <p id="descmineur">
            C’est un « mineur de bitcoin », conçu et programmé pour « générer » la célèbre
            crypto-monnaie.<br />
            Ces appareils sont représentatifs de la puissance de calcul qu’un pirate un peu outillé
            pourrait mettre en œuvre dans une opération de crackage de mots de passe.<br />
          </p>
        </div>
        <p id="beforetable">
          En croisant simplement la vitesse de calcul de l’appareil (en téra-hachés par seconde)
          avec le cardinal de l’ensemble des mots de passe possibles (soit la formule N<sup>L</sup>
          vue précédemment), on obtient ce résultat assez saisissant :
        </p>
        <div id="container-big-table">
          <table id="t2">
            <tr>
              <th class="th2" colspan="2" rowspan="2"></th>
              <th class="th2" colspan="4">Ensemble de caractères</th>
            </tr>
            <tr>
              <td class="td2">Chiffres de 0 à 9</td>
              <td class="td2">Lettres de même classe</td>
              <td class="td2">Majuscules, minuscules et chiffres</td>
              <td class="td2">Majuscules, minuscules, chiffres et symboles</td>
            </tr>
            <tr>
              <td class="td2" colspan="2">Nombre de caractères possibles</td>
              <td class="td2">10</td>
              <td class="td2">26</td>
              <td class="td2">62</td>
              <td class="td2">80</td>
            </tr>
            <tr>
              <td class="td2" rowspan="12">Longueur du mot de passe (en caractères)</td>
              <td class="td2">4</td>
              <td class="td2" colspan="4" rowspan="4">Moins d'une seconde</td>
            </tr>
            <tr>
              <td class="td2">5</td>
            </tr>
            <tr>
              <td class="td2">6</td>
            </tr>
            <tr>
              <td class="td2">7</td>
            </tr>
            <tr>
              <td class="td2">8</td>
              <td class="td2" colspan="2" rowspan="2">Moins d'une seconde</td>
              <td class="td2">2 Secondes</td>
              <td class="td2">15 Secondes</td>
            </tr>
            <tr>
              <td class="td2">9</td>
              <td class="td2">2 Minutes</td>
              <td class="td2">20 Minutes</td>
            </tr>
            <tr>
              <td class="td2">10</td>
              <td class="td2" rowspan="5">Moins d'une seconde</td>
              <td class="td2">1,3 Secondes</td>
              <td class="td2">2 Heures</td>
              <td class="td2">27 Heures</td>
            </tr>
            <tr>
              <td class="td2">11</td>
              <td class="td2">33 Secondes</td>
              <td class="td2">6 Jours</td>
              <td class="td2">90 Jours</td>
            </tr>
            <tr>
              <td class="td2">12</td>
              <td class="td2">15 Minutes</td>
              <td class="td2">340 Jours</td>
              <td class="td2">19 Ans</td>
            </tr>
            <tr>
              <td class="td2">13</td>
              <td class="td2">7 Heures</td>
              <td class="td2">58 Ans</td>
              <td class="td2">1580 Ans</td>
            </tr>
            <tr>
              <td class="td2">14</td>
              <td class="td2">7 Jours</td>
              <td class="td2">3575 Ans</td>
              <td class="td2">127 Millénaires</td>
            </tr>
            <tr>
              <td class="td2">15</td>
              <td class="td2">10 Secondes</td>
              <td class="td2">6 Mois</td>
              <td class="td2">221 Millénaires</td>
              <td class="td2"><u>10 Millions d'années</u></td>
            </tr>
          </table>
        </div>
        <p id="aftertable">
          Il y a quelques nuances à apporter :<br />
          -Il s’agirait du temps qu’il faut à l’attaquant pour trouver la dernière possibilité parmi
          tous ces mots de passe. Il est donc probable qu’il ait trouvé votre mot de passe avant le
          temps indiqué. <br />
          -Il s’agit d’une estimation du temps avec un seul appareil, or, à grand cout, il est
          possible d’en acheter plusieurs. Le crackage est “parallèlisable”, c’est-à-dire que
          plusieurs appareils pourraient se partager la tâche. <br />
          -On ne prend pas en compte le principe de la loi de Moore énoncé précedemment. Il faut
          comprendre ici que le temps diminuera avec le temps.
        </p>
        <h2 id="conculsion"><i>Quel est le lien entre ces différentes attaques ?</i></h2>
        <p>
          Imaginez qu’un attaquant ait pu parvenir à exfiltrer la base de données des utilisateurs
          d’un réseau social. <br />
          Dans ce cas, l’attaquant va disposer d’une liste de comptes et des informations secrètes
          d’authentification. <br />
          Si ces informations d’authentification sont des mots de passe « en clair » :<br />
          D’une part, c’est la catastrophe, car les attaques sur les comptes d’utilisateurs sont
          immédiatement possibles, d’autre part la conception du service attaqué est inexcusable.
        </p>
        <p>
          Si les mots de passe ont été protégés par des moyens cryptographique, alors une attaque
          par « Password cracking » peut commencer.
          <u>Chez le pirate, sur ses propres serveurs.</u><br />
          Certains mots de passe vont être trouvés en quelques minutes. Ici, la robustesse du mot de
          passe que vous aurez choisi est importante : s’il est faible, vous gagnerez certainement
          un peu de temps pour la défense, mais si votre mot de passe est fort, l’attaquant va y
          laisser plus d’argent en électricité, mais il y a de bonnes chances qu'il y parvienne au
          bout du compte. <i>Cela arrivera un jour mais cela peut durer plus de 1000 ans !</i><br />
          Le pirate sera ensuite tenté de contrôler la qualité des mots de passe par une attaque de
          « credential stuffing ». La qualité de la base conditionne son prix de vente sur le
          darkweb. <br />
          Une fois des comptes/mot de passe compromis, une attaque de « password spraying » pourra
          utilement être tentée pour compromettre d’autres comptes.
          <i
            >Par exemple les comptes professionnels, des mêmes personnes, dans l’espoir malsain que
            l’utilisateur ait réutilisé les mêmes mots de passe, ou une variante trop proche.</i
          >
        </p>
      </article>
    </main>
    <script src="../js/infos-sidebar.js"></script>
  </body>
</html>
