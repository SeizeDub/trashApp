/**
 * Adds handlers to each field
 */

[...document.querySelectorAll('input, textarea, select')].forEach(field => {
    initErrorElement(field);
    initChangeHandler(field);
    initInvalidHandler(field);
    initInputHandler(field);
});


/**
 * Creates the element where to output the error message
 */
function initErrorElement(field) {
    let errorElement = document.createElement('span');
    errorElement.classList.add('error-message');
    field.after(errorElement);
}


/**
 * Checks field validity on change
 */
function initChangeHandler(field) {
    field.onchange = () => {
        field.reportValidity();
    }
}


/**
 * Replaces default error message display on invalid event
 */
function initInvalidHandler(field) {
    field.oninvalid = (event) => {
        event.preventDefault();
        displayError(field, getErrorMessage(field));
    }
}


/**
 * Removes invalid class and error message on input
 */
function initInputHandler(field) {
    field.oninput = () => {
        removeError(field);
    }
}


/**
 * Returns custom error message if criteria are met
 * Returns default browser error message by default
 * @param {Node} field The field to retreive the error message from
 * @returns {string} Error message
 */
function getErrorMessage(field) {
    if (field.type === 'email' && field.validity.typeMismatch) {
        return 'Email invalide.'
    }
    return field.validationMessage;
}


/**
 * Adds invalid class to the input container
 * Displays message in the error element
 * @param {Node} field The field with error
 * @param {string} message The error message to display
 */
function displayError(field, message) {
    field.parentNode.classList.add('invalid');
    field.parentNode.getElementsByClassName('error-message')[0].textContent = message;
}

function removeError(field) {
    field.parentNode.classList.remove('invalid');
    field.parentNode.getElementsByClassName('error-message')[0].textContent = null;
}
