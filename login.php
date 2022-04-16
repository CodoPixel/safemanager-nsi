<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <meta name="robots" content="noindex, nofollow" />
    <title>SafeManager - Se connecter</title>
  </head>
  <body>
    <div class="box">
      <form method="POST" action="sql/login.php">
        <h1>Se connecter</h1>
        <p>
          Vous n'avez pas de compte ?
          <a href="register.php" title="Se créer compte">S'inscrire</a>
        </p>

        <div class="email">
          <input type="email" id="mail" name="email" placeholder="Adresse email" required />
        </div>

        <div class="password">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Mot de passe"
            required
          />
          <i id="eye" class="fa-solid fa-eye" onclick="togglePasswordType()"></i>
        </div>

        <div class="access">
          <button type="submit">
            Accéder à mon compte
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </form>
    </div>
    <script src="js/logging.js"></script>
  </body>
</html>
