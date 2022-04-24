"use strict";
class LabelModal {
    modal = document.querySelector("#modal-label");
    inputTitle = document.querySelector("#new-label-title");
    colorPickerButton = document.querySelector("#color-picker");
    inputColorPicker = document.querySelector("#new-label-color");
    previewLabelColor = document.querySelector("#modal-preview-label-color");
    useButton = document.querySelector("#label-create-button");
    errorElement = document.querySelector("#new-label-error");
    color = "#000000";
    onCreate;
    constructor(onCreate) {
        if (this.modal == undefined) {
            throw new Error("The modal for the creation of a label doesn't exist on the page.");
        }
        this.colorPickerButton.onclick = () => {
            this.inputColorPicker.click();
        };
        this.inputColorPicker.onchange = (e) => {
            const newColor = e.target.value;
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
    open() {
        if (window.ModalHandler == undefined) {
            throw new Error("There is no handler for the modal.");
        }
        window.ModalHandler.open("#modal-label");
    }
    close() {
        window.ModalHandler.close();
    }
    displayError(errorMessage) {
        this.errorElement.textContent = errorMessage;
    }
    resetError() {
        this.errorElement.textContent = "";
    }
    startLoading() {
        this.useButton.textContent = "Chargement...";
        this.useButton.setAttribute("disabled", "");
    }
    stopLoading() {
        this.useButton.textContent = "Utiliser";
        this.useButton.removeAttribute("disabled");
    }
    getTitle() {
        return this.inputTitle.value.trim();
    }
    saveNewLabel() {
        const title = this.getTitle();
        const color = this.color.replace("#", "");
        const ajaxRequest = new AjaxRequest();
        ajaxRequest.onSuccess = (response) => {
            if (response.confirmed) {
                this.close();
                this.onCreate(title, "#" + color, response.data.labelID);
            }
            else {
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
