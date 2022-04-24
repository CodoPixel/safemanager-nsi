class LabelModal {
  public modal = document.querySelector("#modal-label") as HTMLDivElement;
  public inputTitle = document.querySelector("#new-label-title") as HTMLInputElement;
  public colorPickerButton = document.querySelector("#color-picker") as HTMLButtonElement;
  public inputColorPicker = document.querySelector("#new-label-color") as HTMLInputElement;
  public previewLabelColor = document.querySelector("#modal-preview-label-color") as HTMLDivElement;
  public useButton = document.querySelector("#label-create-button") as HTMLButtonElement;
  public errorElement = document.querySelector("#new-label-error") as HTMLSpanElement;
  public color: string = "#000000";
  public onCreate: (title: string, usedColor: string, labelID: string) => void;

  constructor(onCreate: (title: string, usedColor: string, labelID: string) => void) {
    if (this.modal == undefined) {
      throw new Error("The modal for the creation of a label doesn't exist on the page.");
    }

    this.colorPickerButton.onclick = () => {
      this.inputColorPicker.click();
    };

    this.inputColorPicker.onchange = (e) => {
      const newColor = (e.target as HTMLInputElement).value;
      this.color = newColor;
      this.previewLabelColor.style.backgroundColor = newColor;
    };

    this.useButton.onclick = () => {
      const title = this.getTitle();
      this.resetError();
      if (title.length === 0) {
        this.displayError("Erreur : vous devez spécifier un titre.");
        return;
      }
      this.startLoading();
      this.saveNewLabel();
      this.stopLoading();
    };

    this.onCreate = onCreate;
  }

  public open() {
    if ((window as any).ModalHandler == undefined) {
      throw new Error("There is no handler for the modal.");
    }

    (window as any).ModalHandler.open("#modal-label");
  }

  public close() {
    (window as any).ModalHandler.close();
  }

  public displayError(errorMessage: string) {
    this.errorElement.textContent = errorMessage;
  }

  public resetError() {
    this.errorElement.textContent = "";
  }

  public startLoading() {
    this.useButton.textContent = "Chargement...";
    this.useButton.setAttribute("disabled", "");
  }

  public stopLoading() {
    this.useButton.textContent = "Utiliser";
    this.useButton.removeAttribute("disabled");
  }

  public getTitle() {
    return this.inputTitle.value.trim();
  }

  public saveNewLabel() {
    const title = this.getTitle();
    const color = this.color.replace("#", "");
    const ajaxRequest = new AjaxRequest();
    ajaxRequest.onSuccess = (response) => {
      if (response.confirmed) {
        this.close();
        this.onCreate(title, "#" + color, response.data.labelID);
      } else {
        Swal.fire("Erreur !", response.error ?? "Erreur inconnue", "error");
      }
    };
    ajaxRequest.onError = (status) => {
      Swal.fire("Erreur !", "Erreur (" + status + ")", "error");
    };
    ajaxRequest.open("GET", "../sql/create_new_label.php?title=" + title + "&color=" + color);
    ajaxRequest.send();
  }
}
