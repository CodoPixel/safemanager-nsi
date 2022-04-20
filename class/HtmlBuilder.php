<?php

class HtmlBuilder {
  /**
   * Creates the sidebar
   * @param string $activeItem The item to highlight in the sidebar
   * @return string
   */
  public static function sidebar(string $activeItem): string {
    $isIndex = $activeItem == "index" ? "active" : "";
    $isNotes = $activeItem == "notes" ? "active" : "";
    $isImages = $activeItem == "images" ? "active" : ""; 
    $isSettings = $activeItem == "settings" ? "active" : ""; 

    return <<<HTML
      <div id="shader"></div>
      <aside id="sidebar">
        <h1 class="appname">SafeManager</h1>
        <div class="sidebar-containerProfile">
          <img alt="avatar" src="../assets/private/default-avatar.png" />
          <span>Bienvenue,</span>
          <h1>Thomas Gysemans</h1>
        </div>
        <nav>
          <a class="sidebar-item ${isIndex}" href="index.php">
            <i class="fa-solid fa-lock"></i><span>Mots de passe</span>
          </a>
          <a class="sidebar-item ${isNotes}" href="notes.php">
            <i class="fa-regular fa-note-sticky"></i><span>Notes</span>
          </a>
          <a class="sidebar-item ${isImages}" href="images.php">
            <i class="fa-regular fa-image"></i><span>Images</span>
          </a>
          <a class="sidebar-item ${isSettings}" href="settings.php">
            <i class="fa-solid fa-gear"></i><span>Paramètres</span>
          </a>
          <a class="sidebar-item" href="../index.php">
            <i class="fa-solid fa-globe"></i><span>Sites web</span>
          </a>
        </nav>
      </aside>
    HTML;
  }

  /**
   * Creates the header
   * @param bool $key Should the key be displayed?
   * @param ?string $searchPlaceholder The placeholder for the search input. Null to not display a input
   * @return string
   */
  public static function header(bool $key, ?string $searchPlaceholder):string {
    $key = $key ? <<<HTML
      <a title="Créer un mot de passe" class="header-key" href="password.php"><i class="fa-solid fa-key"></i></a>
    HTML : "";

    $input = $searchPlaceholder ? <<<HTML
      <input id="search" type="search" class="input" placeholder="${searchPlaceholder}" maxlength="50" autocomplete="off" spellcheck="false" />
    HTML : "";

    return <<<HTML
      <header>
        <div class="header-left">
          <nav style="position:relative;z-index:30;" role="navigation" aria-label="Menu principal">
            <button class="hamburger" aria-expanded="false" aria-controls="sidebar" title="Ouvrir le menu">
              <div></div>
              <div></div>
              <div></div>
            </button>
          </nav>
          ${key}
        </div>
        ${input}
      </header>
    HTML;
  }

  public static function circularProgressBar(string $initialContent = '0%'):string {
    return <<<HTML
      <div class="container">
        <div class="circular-progress">
          <div class="value-container">
            ${initialContent}
          </div>
        </div>
      </div>
    HTML;
  }

  public static function modalGeneratePassword():string {
    $progressBar = self::circularProgressBar('0');

    return <<<HTML
      <div id="modal-generate-password" class="modal" role="dialog" aria-hidden="true" aria-modal="true" aria-labelledby="modal-generatepassword-title">
          <!-- The wrapper is not the "white thing" -->
          <div class="modal-wrapper">
              <!-- add .modal-close-right if this is a small box -->
              <button type="button" class="modal-close" aria-label="Fermer"><i class="fas fa-times"></i></button>

              <!-- The white thing -->
              <div class="modal-content">
                <!-- Put an ID here -->
                <h1 id="modal-generatepassword-title">Générer un mot de passe</h1>
                <div class="container-generatepassword">
                  <div class="container-generatepassword-modal-progressbar">
                    ${progressBar}
                  </div>
                  <div class="container-generatepassword-modal-config" id="generatepassword-config">
                    <div class="generatepassword-config" id="generatepassword-config-memorable">
                      <input type="checkbox" id="memorable">
                      <label for="memorable">Mémorable</label>
                    </div>
                    <div class="generatepassword-config" id="generatepassword-config-length">
                      <input type="checkbox" id="checkbox-custom-length">
                      <label for="checkbox-custom-length">Longueur personnalisée</label>
                      <div class="generatepassword-set-length disabled-input">
                        <label for="modal-password-length">Longueur du mot de passe :</label>
                        <input type="number" id="modal-password-length" value="20" min="6" max="255" readonly>
                      </div>
                    </div>
                    <div class="generatepassword-config" id="generatepassword-config-specialchars">
                      <input type="checkbox" id="special-characters" checked>
                      <label for="special-characters">Caractères spéciaux</label>
                    </div>
                    <div class="generatepassword-config" id="generatepassword-config-maj">
                      <input type="checkbox" id="maj" checked>
                      <label for="maj">Lettres majuscules</label>
                    </div>
                    <div class="generatepassword-config" id="generatepassword-config-numbers">
                      <input type="checkbox" id="numbers" checked>
                      <label for="numbers">Chiffres</label>
                    </div>
                  </div>
                </div>
                <span id="explanatory-password"></span>
                <div class="generatepassword-controls">
                  <input id="generated-password-input" placeholder="Mot de passe généré" type="text" maxlength="255" spellcheck="false" autocomplete="off">
                  <button class="button-material" id="generatepassword-button" type="button">Générer</button>
                  <button class="button-material" id="copy-button" type="button"><i class="fa-regular fa-copy"></i></button>
                </div>
              </div>
          </div>
      </div>
    HTML;
  }

  public static function modalTestPassword():string {
    $progressBar = self::circularProgressBar('0');

    return <<<HTML
      <div id="modal-test-password" class="modal" role="dialog" aria-hidden="true" aria-modal="true" aria-labelledby="modal-test-title">
          <!-- The wrapper is not the "white thing" -->
          <div class="modal-wrapper">
              <!-- add .modal-close-right if this is a small box -->
              <button type="button" class="modal-close" aria-label="Fermer"><i class="fas fa-times"></i></button>

              <!-- The white thing -->
              <div class="modal-content">
                <!-- Put an ID here -->
                <h1 id="modal-test-title">Tester un mot de passe</h1>
                <div class="testpassword-controls">
                  <input id="tested-password-input" placeholder="Le mot de passe" type="text" maxlength="255" spellcheck="false" autocomplete="off">
                  <button class="button-material" id="testpassword-button" type="button">Tester</button>
                </div>
                <div class="container-testpassword-modal-progressbar">
                  ${progressBar}
                </div>
              </div>
          </div>
      </div>
    HTML;
  }
}