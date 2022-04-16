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
}