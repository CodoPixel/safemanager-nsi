<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/register.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - S'inscrire</title>
  </head>
  <body>
    <div class="box">
      <form method="POST" action="sql/register.php">
        <h1>S'inscrire</h1>
        <p>
          Vous avez déjà un compte ? <a href="connexion.php" title="Se connecter">Se connecter</a>
        </p>

        <div class="email">
          <input name="email" type="email" id="mail" placeholder="Adresse email" required />
        </div>

        <div class="container-names">
          <div class="first-name">
            <input name="firstname" type="text" id="name" placeholder="Prénom" required />
          </div>
          <div class="family-name">
            <input name="lastname" type="text" id="family-name" placeholder="Nom" required />
          </div>
        </div>

        <div class="password">
          <input
            name="password"
            type="password"
            id="password"
            placeholder="Mot de passe"
            required
          />
          <i id="eye" class="fa-solid fa-eye" onclick="togglePasswordType()"></i>
        </div>

        <div class="access">
          <button type="submit">
            Créer mon compte
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </form>
    </div>
    <script src="js/logging.js"></script>
  </body>
</html>
