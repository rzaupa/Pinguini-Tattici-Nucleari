function caricamento() {
    let inputTitle = document.getElementById("titolo");
    inputTitle.onblur = function () { validateTitle(this) };

    let inputDuration = document.getElementById("durata");
    inputDuration.onblur = function () { validateDuration(this) };

    let inputDate = document.getElementById("dataRadio");
    inputDate.onblur = function () { validateDate(this) };

    let inputURL = document.getElementById("urlVideo");
    inputURL.onblur = function () { validateURL(this) };
}

function validateTitle(inputTitle) {
    //TO DO
}

function validateDuration(inputDuration) {
    if ((inputDuration.value.search(/^\d{2}:\d{2}$/) != 0) || (inputDuration > "10:00")) {
        showError(inputDate, "Inserire la durata nel formato corretto MM:SS o superiore a 10 minuti");
        inputDuration.focus();
        inputDuration.select();
        return false;
    }
    return true;
}

function validateDate(inputDate) {
    if (inputDate.value.search(/^\d{2}\/\d{2}\/\d{4}$/) != 0) {
        showError(inputDate, "Inserire la data nel formato corretto (gg/mm/AAAAAAA)");
        inputDate.focus();
        inputDate.select();
        return false;
    }
    return true;
}

function validateURL(inputURL) {
    removeChildInput(inputURL);
    try {
        if (inputURL.value.length > 0) {
            new URL(inputURL.value);
        }
        return true;
    } catch (err) {
        showError(inputURL, "URL non valido");
        inputURL.focus();
        inputURL.select();
        return false;
    }
}

function showError(tag, string) {
    const padre = tag.parentNode;
    const errore = document.createElement("strong");
    errore.className = "errorSuggestion";
    errore.appendChild(document.createTextNode(string));
    padre.appendChild(errore); //ultimo figlio del padre, lo span ha un secondo elemento (l'errore)
}

function removeChildInput(input) {
    padre = input.parentNode;
    if (padre.children.length = 2) {
        padre.removeChild(padre.children[1]);
    }
}

