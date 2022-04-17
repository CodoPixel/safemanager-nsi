<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="styles/homepage.css" />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Le logiciel en ligne pour gérer vos mots de passe</title>
  </head>

  <body>
    <div class="page">
      <header>
        <i class="fa-solid fa-lock"></i>
        <nav>
          <a href="/">Accueil</a>
          <a href="infos/strength-intro.php">Informations</a>
          <a href="index.html">Générateur</a>
          <a href="index.html">Compte</a>
        </nav>
      </header>
      <div id="safemanager">
        <h2><span>SafeManager</span></h2>
        Bienvenue sur le site SafeManager ! Ce dernier vous offre diverses fonctionnalités
        concernant vos mots de passes. Evaluez la force de votre mot de passe, créez-en un
        aléatoirement, triez, classez etc. Venez surfer sur notre site web, mais attention 🤪
        n'oubliez pas votre planche !
        <button id="test">Tester votre mot de passe</button>
        <button id="savoir">En savoir plus</button>
      </div>
      <img id="guy" src="assets/private/security.svg" />
      <img id="circle" src="assets/private/circle.svg" alt="" />
      <div id="bloc1">
        <section>
          <img id="secure_login" src="assets/private/login.svg" />
          <div id="mdp">
            <h2><span>Protégez vos mots de passe</span></h2>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos illum, tenetur
              rerum repellendus architecto voluptas harum quia fugit maxime praesentium accusantium
              laboriosam. Odio temporibus qui, fugiat at illo ullam repellendus.
            </p>
            <button id="begin">Commencer</button>
          </div>
        </section>
        <section>
          <img id="secure_files" src="assets/private/secure-files.svg" />
          <div>
            <h2><span>Protégez vos images</span></h2>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos illum, tenetur
              rerum repellendus architecto voluptas harum quia fugit maxime praesentium accusantium
              laboriosam. Odio temporibus qui, fugiat at illo ullam repellendus.
            </p>
            <button id="begin">Commencer</button>
          </div>
        </section>
        <section>
          <img id="education" src="assets/private/education.svg" />
          <div>
            <h2><span>Nos cours de sécurité</span></h2>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos illum, tenetur
              rerum repellendus architecto voluptas harum quia fugit maxime praesentium accusantium
              laboriosam. Odio temporibus qui, fugiat at illo ullam repellendus.
            </p>
            <button id="begin">Consulter</button>
          </div>
        </section>
        <footer>
          <p id="passwordsecure">Un vrai&nbsp;<span id="blue">mot de passe sécurisé</span></p>
          <button id="generate">Générer</button>
          <button id="testyour">Tester le vôtre</button>
        </footer>
      </div>
    </div>
    <div id="footer">
      <div class="footer-container" id="footer-title">
        <h2>SafeManager</h2>
      </div>
      <div class="footer-container" id="about">
        <h3>À propos</h3>
        <p>
          Un projet étudiant pour souligner l’importance de protéger ses données sur Internet. Ps :
          N'oubliez pas votre planche de surf hein ;)
        </p>
      </div>
      <div class="footer-container" id="plan">
        <h3>Plan du site</h3>
        <ul>
          <li><a id="lien" href="/">Accueil</a></li>
          <li><a id="lien" href="infos/strength-intro.php">Informations</a></li>
          <li><a id="lien" href="login.php">Se Connecter</a></li>
        </ul>
      </div>
      <div class="footer-container">
        <h3 id="creators">Créateurs</h3>
        <ul id="names">
          <li>Wadi B.</li>
          <li>Paul D.</li>
          <li>Thomas G.</li>
          <li>Lucas V.</li>
        </ul>
      </div>
    </div>
  </body>
</html>
