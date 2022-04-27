"use strict";
class GeneratePasswordModal {
    configContainer = document.querySelector("#generatepassword-config");
    generateButton = document.querySelector("#generatepassword-button");
    copyButton = document.querySelector("#copy-button");
    inputMemorable = document.querySelector("#memorable");
    elementSpecialCharacters = document.querySelector("#generatepassword-config-specialchars");
    elementMaj = document.querySelector("#generatepassword-config-maj");
    elementNumbers = document.querySelector("#generatepassword-config-numbers");
    elementCustomLength = document.querySelector("#generatepassword-config-length");
    containerInputCustomLength = this.elementCustomLength.querySelector(".generatepassword-set-length");
    checkboxCustomLength = document.querySelector("#checkbox-custom-length");
    inputCustomLength = document.querySelector("#modal-password-length");
    inputPassword = document.querySelector("#generated-password-input");
    explanatorySentence = document.querySelector("#explanatory-password");
    progressBar = document.querySelector(".container-generatepassword-modal-progressbar .circular-progress");
    onGeneration;
    onCopy;
    constructor(options) {
        this.onGeneration = options?.onGeneration;
        this.onCopy = options?.onCopy;
        if (this.configContainer == null) {
            throw new Error("The modal does not exist.");
        }
        this.inputMemorable.onchange = () => {
            const elementsToCheck = [this.elementMaj, this.elementNumbers, this.elementSpecialCharacters];
            const elementsToToggle = elementsToCheck.concat(this.elementCustomLength);
            if (this.inputMemorable.checked) {
                this.setElements(elementsToToggle, "disabled");
                this.checkElements(elementsToCheck);
                this.uncheckElement(this.elementCustomLength);
                this.disableInputForCustomLength();
            }
            else {
                this.setElements(elementsToToggle, "enabled");
            }
            this.resetExplanatoryText();
        };
        this.checkboxCustomLength.onchange = () => {
            if (this.checkboxCustomLength.checked) {
                this.enableInputForCustomLength();
            }
            else {
                this.disableInputForCustomLength();
            }
        };
        this.generateButton.onclick = async () => {
            this.startLoading();
            try {
                const config = this.buildConfig();
                const result = await this.generatePassword(config);
                const score = calcScoreOf(result);
                this.resetExplanatoryText();
                animateProgressBar(null, score * 10, 5, true, this.progressBar);
                this.displayPassword(result);
                this.onGeneration?.(result);
            }
            catch (e) {
                this.displayError(e.message);
            }
            finally {
                this.stopLoading();
            }
        };
        this.copyButton.onclick = () => {
            this.copyText(this.inputPassword.value);
            this.onCopy?.(this.inputPassword.value);
            this.copyButton.setAttribute("disabled", "");
            const icon = this.copyButton.querySelector("i");
            this.copyButton.innerHTML = "Copié";
            setTimeout(() => {
                this.copyButton.textContent = "";
                this.copyButton.appendChild(icon);
                this.copyButton.removeAttribute("disabled");
            }, 1500);
        };
    }
    open() {
        if (window.ModalHandler == undefined) {
            throw new Error("There is no handler for the modal.");
        }
        window.ModalHandler.open("#modal-generate-password");
    }
    copyText(text) {
        navigator.clipboard.writeText(text);
    }
    disableInputForCustomLength() {
        this.inputCustomLength.setAttribute("readonly", "");
        this.containerInputCustomLength.classList.add("disabled-input");
    }
    enableInputForCustomLength() {
        this.inputCustomLength.removeAttribute("readonly");
        this.containerInputCustomLength.classList.remove("disabled-input");
    }
    isCustomLengthEnabled() {
        return !this.inputCustomLength.hasAttribute("readonly");
    }
    getCheckboxOf(element) {
        return element.querySelector('input[type="checkbox"]');
    }
    setElement(element, status) {
        const input = this.getCheckboxOf(element);
        switch (status) {
            case "disabled":
                input.setAttribute("disabled", "");
                element.classList.add("disabled-input");
                break;
            default:
                input.removeAttribute("disabled");
                element.classList.remove("disabled-input");
        }
    }
    setElements(elements, status) {
        for (let el of elements) {
            this.setElement(el, status);
        }
    }
    checkElement(element) {
        let input = this.getCheckboxOf(element);
        input.checked = true;
    }
    checkElements(elements) {
        for (let el of elements) {
            this.checkElement(el);
        }
    }
    uncheckElement(element) {
        let input = this.getCheckboxOf(element);
        input.checked = false;
    }
    buildConfig() {
        const config = {
            memorable: this.inputMemorable.checked,
            specialCharacters: this.getCheckboxOf(this.elementSpecialCharacters).checked,
            maj: this.getCheckboxOf(this.elementMaj).checked,
            numbers: this.getCheckboxOf(this.elementNumbers).checked,
        };
        if (this.isCustomLengthEnabled()) {
            const customLength = parseInt(this.inputCustomLength.value, 10);
            if (customLength > 255) {
                throw new Error("Wow, mot de passe trop long !");
            }
            else if (customLength <= 0) {
                throw new Error("Wow, mot de passe trop court !");
            }
            config.length = customLength;
        }
        return config;
    }
    startLoading() {
        this.generateButton.textContent = "Chargement...";
        this.generateButton.setAttribute("disabled", "");
    }
    stopLoading() {
        this.generateButton.textContent = "Générer";
        this.generateButton.removeAttribute("disabled");
    }
    displayExplanatoryTextOfPasswordIfNeeded(result) {
        if (result.words) {
            let sentence = "Composé des mots";
            for (let i = 0; i < result.words.length; i++) {
                const word = result.words[i];
                if (i === result.words.length - 1) {
                    sentence += ` et "${word}".`;
                }
                else {
                    sentence += ` "${word}", `;
                }
            }
            this.explanatorySentence.textContent = sentence;
        }
    }
    displayError(error) {
        this.explanatorySentence.textContent = error;
    }
    resetExplanatoryText() {
        this.explanatorySentence.textContent = "";
    }
    displayPassword(result) {
        this.displayExplanatoryTextOfPasswordIfNeeded(result);
        this.inputPassword.value = result.plainPassword;
    }
    /**
     * Generates a pseudo-random integer.
     * @param min The minimum value (included)
     * @param max The maximum value (excluded)
     * @returns A random integer in the interval [min;max[
     */
    generateRandomInteger(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }
    async generatePassword(config) {
        config.length ??= 20;
        let password = "";
        const possibilites = [
            !config.specialCharacters || specialCharactersAlpha,
            !config.maj || majAlpha,
            !config.numbers || numbersAlpha,
        ].filter((v) => v !== true);
        if (!config.memorable) {
            for (let i = 0; i < config.length; i++) {
                const randomAlphaIndex = this.generateRandomInteger(0, possibilites.length + 1);
                if (randomAlphaIndex === possibilites.length) {
                    const randomCharacterIndex = this.generateRandomInteger(0, minAlpha.length);
                    password += minAlpha[randomCharacterIndex];
                }
                else {
                    const randomCharacterIndex = this.generateRandomInteger(0, possibilites[randomAlphaIndex].length);
                    password += possibilites[randomAlphaIndex][randomCharacterIndex];
                }
            }
        }
        else {
            const words = [];
            for (let i = 0; i < 3; i++) {
                const chosenLetter = minAlpha[this.generateRandomInteger(0, minAlpha.length)];
                const dictFile = "/safemanager-nsi/dict/" + chosenLetter + ".txt";
                // todo: this won't work on another URL.
                const query = await fetch(dictFile, { method: "GET" });
                const responseText = await query.text();
                const randomIndex = this.generateRandomInteger(0, responseText.length);
                const beginningIndexOfNextWord = responseText.substring(randomIndex).indexOf("\n");
                let word;
                if (beginningIndexOfNextWord < 0) {
                    word = responseText.substring(0, responseText.indexOf("\n")).trim();
                    password += word;
                }
                else {
                    word = responseText
                        .substring(randomIndex + beginningIndexOfNextWord, randomIndex +
                        beginningIndexOfNextWord +
                        responseText.substring(randomIndex + beginningIndexOfNextWord + 1).indexOf("\n") +
                        1)
                        .trim();
                    password += word;
                }
                words.push(word);
            }
            const generationConfig = {
                plainPassword: password,
                words,
                usedWithConfig: {
                    memorable: true,
                    length: password.length,
                    maj: false,
                    numbers: false,
                    specialCharacters: false,
                },
            };
            return generationConfig;
        }
        return { plainPassword: password, usedWithConfig: config };
    }
}
