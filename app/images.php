<?php
require_once "../class/HtmlBuilder.php";
require_once "../class/Auth.php";
AuthHelper::mustBeConnected("../index.php");

$errorMessage = null;
$criticalError = false;
try {
  $auth = new Auth();
  $client = $auth->getClient();
  $allImages = $auth->getAllImages($client);
} catch (ClientException $e) {
  $errorMessage = $e->getMessage();
} catch (Exception $e) {
  $errorMessage = "Une erreur serveur est survenue.";
  $criticalError = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../styles/root.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/sidebar.css">
  <link rel="stylesheet" href="../styles/images.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless@5/borderless.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <title>SafeManager - Mes images</title>
</head>
<body class="<?= $client->hasDarkMode() ? 'dark' : '' ?>">
  <?= HtmlBuilder::sidebar("images"); ?>
  <main>
    <?= HtmlBuilder::header(true, "Rechercher une image"); ?>
    <div>
    <div class="content">
      <div class="content-topbar">
        <p>Vous avez <strong id="number-of-images"><?= count($allImages) ?></strong> image<span id="s"><?= count($allImages) > 1 ? 's' : '' ?></span> <?= $client->hasStreamerMode() ? 'cachée' . (count($allImages) > 1 ? 's' : '') : '' ?><?= $client->hasStreamerMode() ? '.' : ' :' ?></p>
        <div class="container-file-input">
          <button <?= $client->hasStreamerMode() ? 'disabled' : '' ?> class="button-primary" type="button" onclick="uploadImage()">Ajouter une image</button>
          <input type="file" name="image" id="file-input">
        </div>
      </div>
      <div class="grid">
        <?php if (!$client->hasStreamerMode()): ?>
          <?php foreach ($allImages as $image): ?>
            <div class="container-image">
              <button class="button-image" type="button">
                <div class="image-overlay"></div>
                <img src="../assets/public/images/<?= $image->getClientID() ?>/<?= $image->getName() ?>" alt="aucune description" />
              </button>
              <button class="delete-button" data-image="<?= $image->getID() ?>"><i class="fa-solid fa-trash"></i></button>
            </div>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
  </main>

  <div class="presentation" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Présentation plus large de votre image">
    <button type="button" id="cross" title="Fermer la présentation"><i class="fa-solid fa-times"></i></button>  
    <button type="button" id="left" title="Image précédente"><i class="fa-solid fa-angle-left"></i></button>
    <div class="presentation-container-image">
      <img src="../assets/private/test-image.jpeg" alt="aucune description" id="preview-image" />
    </div>
    <button type="button" id="right" title="Image suivate"><i class="fa-solid fa-angle-right"></i></button>
  </div>

  <script src="../js/sidebar.js"></script>
  <script src="../js/image-presentation.js"></script>
  <script src="../js/handleAjaxRequests.js"></script>
  <script>
    const grid = document.querySelector(".grid");
    const allDeleteButtons = document.querySelectorAll(".delete-button");
    const fileInput = document.querySelector("#file-input");

    for (let deleteButton of allDeleteButtons) {
      deleteButton.addEventListener("click", deleteOnClick);
    }
    
    function uploadImage() {
      fileInput.click();
    }

    function deleteOnClick(e) {
      e.stopPropagation();
      deleteImage(e.target);
    }

    function deleteImage(image) {
      Swal.fire({
        title: "Suppression de l'image",
        text: "Ceci est une action irréversible.",
        icon: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          const id = parseInt(image.dataset.image, 10);
          const request = new AjaxRequest();
          request.onSuccess = (response) => {
            if (response.confirmed) {
              Swal.fire("Suppression réussie", "", "success").then(()=>{
                removeImageFromDOM(id);
                changeImagesCounter(-1);
              });
            } else {
              Swal.fire("Erreur", response.error ?? "Erreur inconnue", "error");
            }
          };
          request.onError = (status) => {
            Swal.fire("Erreur", "Erreur ("+status+")", "error");
          };
          request.open("GET", "../sql/delete_image.php?id=" + id);
          request.send();
        },
      });
    }

    function removeImageFromDOM(id) {
      const element = document.querySelector(".delete-button[data-image='" + id + "']");
      const parentElement = element.parentElement;
      while (parentElement.firstChild) {
        parentElement.removeChild(parentElement.firstChild);
      }
      parentElement.parentElement.removeChild(parentElement);
    }

    function changeImagesCounter(delta) {
      const s = document.querySelector("#s");
      const element = document.querySelector("#number-of-images");
      const numberOfImages = parseInt(element.textContent, 10);
      const newNumber = numberOfImages + delta;
      if (newNumber > 1) {
        s.textContent = 's';
      } else {
        s.textContent = '';
      }
      element.textContent = newNumber.toString();
    }

    function buildNewImage(data) {
      const container = document.createElement("div");
      container.classList.add("container-image");
      const button = document.createElement("button");
      button.classList.add("button-image");
      button.setAttribute("type", "button");
      const overlay = document.createElement("div");
      overlay.classList.add("image-overlay");
      const img = document.createElement("img");
      img.setAttribute("src", "../assets/public/images/" + data.clientID + "/" + data.name);
      img.setAttribute("alt", "aucune description");
      button.appendChild(overlay);
      button.appendChild(img);
      container.appendChild(button);
      const deleteButton = document.createElement("button");
      deleteButton.classList.add("delete-button");
      deleteButton.setAttribute("data-image", data.ID);
      const trashIcon = document.createElement("i");
      trashIcon.classList.add("fa-solid", "fa-trash");
      deleteButton.appendChild(trashIcon);
      deleteButton.addEventListener("click", deleteOnClick);
      container.appendChild(deleteButton);
      grid.appendChild(container);
    }

    function selectFile() {
      if (fileInput.files && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const data = new FormData();
        data.append("image", file);
        Swal.fire({
          title: "Publier l'image ?",
          text: "Fichier sélectionné : " + file.name,
          icon: "question",
          cancelButtonText: "Annuler",
          confirmButtonText: "Publier",
          showLoaderOnConfirm: true,
          preConfirm: () => {
            const request = new AjaxRequest();
            request.onSuccess = (response) => {
              if (response.confirmed) {
                Swal.fire("Publication réussie", "", "success").then(()=>{
                  buildNewImage(response.data);
                  changeImagesCounter(1);
                  resetImages();
                });
              } else {
                Swal.fire("Erreur", response.error ?? "Erreur inconnue", "error");
              }
            };
            request.onError = (status) => {
              Swal.fire("Erreur", "Erreur ("+status+")", "error");
            };
            request.open("POST", "../sql/publish_image.php");
            request.send(data);
          },
        });
      }
    }

    fileInput.addEventListener("change", selectFile);
  </script>
  <?= HtmlBuilder::handleErrorMessage($errorMessage, $criticalError ? '../index.php' : null) ?>
</body>
</html>