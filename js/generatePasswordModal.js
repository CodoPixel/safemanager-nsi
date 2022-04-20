"use strict";
(function () {
    const configContainer = document.querySelector("#generatepassword-config");
    const generateButton = document.querySelector("#generatepassword-button");
    const copyButton = document.querySelector("#copy-button");
    const inputMemorable = document.querySelector("#memorable");
    const elementSpecialCharacters = document.querySelector("#generatepassword-config-specialchars");
    const elementMaj = document.querySelector("#generatepassword-config-maj");
    const elementNumbers = document.querySelector("#generatepassword-config-numbers");
    const elementCustomLength = document.querySelector("#generatepassword-config-length");
    const containerInputCustomLength = elementCustomLength.querySelector(".generatepassword-set-length");
    const checkboxCustomLength = document.querySelector("#checkbox-custom-length");
    const inputCustomLength = document.querySelector("#modal-password-length");
    const inputPassword = document.querySelector("#generated-password-input");
    const explanatorySentence = document.querySelector("#explanatory-password");
    const progressBar = document.querySelector(".container-generatepassword-modal-progressbar .circular-progress");
    if (configContainer == null) {
        throw new Error("The modal does not exist.");
    }
    function disableInputForCustomLength() {
        inputCustomLength.setAttribute("readonly", "");
        containerInputCustomLength.classList.add("disabled-input");
    }
    function enableInputForCustomLength() {
        inputCustomLength.removeAttribute("readonly");
        containerInputCustomLength.classList.remove("disabled-input");
    }
    function isCustomLengthEnabled() {
        return !inputCustomLength.hasAttribute("readonly");
    }
    function getCheckboxOf(element) {
        return element.querySelector('input[type="checkbox"]');
    }
    function setElement(element, status) {
        const input = getCheckboxOf(element);
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
    function setElements(elements, status) {
        for (let el of elements) {
            setElement(el, status);
        }
    }
    function checkElement(element) {
        let input = getCheckboxOf(element);
        input.checked = true;
    }
    function checkElements(elements) {
        for (let el of elements) {
            checkElement(el);
        }
    }
    function uncheckElement(element) {
        let input = getCheckboxOf(element);
        input.checked = false;
    }
    inputMemorable.onchange = () => {
        const elementsToCheck = [elementMaj, elementNumbers, elementSpecialCharacters];
        const elementsToToggle = elementsToCheck.concat(elementCustomLength);
        if (inputMemorable.checked) {
            setElements(elementsToToggle, "disabled");
            checkElements(elementsToCheck);
            uncheckElement(elementCustomLength);
            disableInputForCustomLength();
        }
        else {
            setElements(elementsToToggle, "enabled");
        }
        resetExplanatoryText();
    };
    checkboxCustomLength.onchange = () => {
        if (checkboxCustomLength.checked) {
            enableInputForCustomLength();
        }
        else {
            disableInputForCustomLength();
        }
    };
    function buildConfig() {
        const config = {
            memorable: inputMemorable.checked,
            specialCharacters: getCheckboxOf(elementSpecialCharacters).checked,
            maj: getCheckboxOf(elementMaj).checked,
            numbers: getCheckboxOf(elementNumbers).checked,
        };
        if (isCustomLengthEnabled()) {
            const customLength = parseInt(inputCustomLength.value, 10);
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
    function startLoading() {
        generateButton.textContent = "Chargement...";
        generateButton.setAttribute("disabled", "");
    }
    function stopLoading() {
        generateButton.textContent = "Générer";
        generateButton.removeAttribute("disabled");
    }
    function displayExplanatoryTextOfPasswordIfNeeded(result) {
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
            explanatorySentence.textContent = sentence;
        }
    }
    function displayError(error) {
        explanatorySentence.textContent = error;
    }
    function resetExplanatoryText() {
        explanatorySentence.textContent = "";
    }
    function displayPassword(result) {
        displayExplanatoryTextOfPasswordIfNeeded(result);
        inputPassword.value = result.plainPassword;
    }
    generateButton.onclick = async () => {
        startLoading();
        try {
            const config = buildConfig();
            const result = await generatePassword(config);
            const score = calcScoreOf(result);
            resetExplanatoryText();
            animateProgressBar(null, score * 10, 5, true, progressBar);
            displayPassword(result);
        }
        catch (e) {
            displayError(e.message);
        }
        finally {
            stopLoading();
        }
    };
    function copyText(text) {
        navigator.clipboard.writeText(text);
    }
    copyButton.onclick = () => {
        copyText(inputPassword.value);
        copyButton.setAttribute("disabled", "");
        const icon = copyButton.querySelector("i");
        copyButton.innerHTML = "Copié";
        setTimeout(() => {
            copyButton.textContent = "";
            copyButton.appendChild(icon);
            copyButton.removeAttribute("disabled");
        }, 1500);
    };
    /**
     * Generates a pseudo-random integer.
     * @param min The minimum value (included)
     * @param max The maximum value (excluded)
     * @returns A random integer in the interval [min;max[
     */
    function generateRandomInteger(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }
    async function generatePassword(config) {
        config.length ??= 20;
        let password = "";
        const possibilites = [
            !config.specialCharacters || specialCharactersAlpha,
            !config.maj || majAlpha,
            !config.numbers || numbersAlpha,
        ].filter((v) => v !== true);
        if (!config.memorable) {
            for (let i = 0; i < config.length; i++) {
                const randomAlphaIndex = generateRandomInteger(0, possibilites.length + 1);
                if (randomAlphaIndex === possibilites.length) {
                    const randomCharacterIndex = generateRandomInteger(0, minAlpha.length);
                    password += minAlpha[randomCharacterIndex];
                }
                else {
                    const randomCharacterIndex = generateRandomInteger(0, possibilites[randomAlphaIndex].length);
                    password += possibilites[randomAlphaIndex][randomCharacterIndex];
                }
            }
        }
        else {
            const words = [];
            for (let i = 0; i < 3; i++) {
                const chosenLetter = minAlpha[generateRandomInteger(0, minAlpha.length)];
                const query = await fetch("dict/" + chosenLetter + ".txt", { method: "GET" });
                const responseText = await query.text();
                const randomIndex = generateRandomInteger(0, responseText.length);
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
            return {
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
        }
        return { plainPassword: password, usedWithConfig: config };
    }
})();
