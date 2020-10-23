let loginFormEl = document.getElementById('login-form');

async function loginRequest() {
    let data = new FormData(loginFormEl);
    let response = await fetch('php/tasks/login-task.php', {method : 'POST', body : data});
    response = await response.text();
    switch (response) {
        case 'success':
            document.location.replace('index.php');
            break;
        case 'error':
            displayError(document.getElementById('submit-login'), "Une erreur est survenue.");
            break;
        case 'email':
            displayError(document.getElementById('input-email'), "Adresse email inconnue.");
            break;
        case 'password':
            displayError(document.getElementById('input-password'), "Mot de passe incorrect.");
            break;
        case 'missing':
            displayError(document.getElementById('submit-login'), "Un champ est manquant.");
            break;
    }
}

loginFormEl.onsubmit = (event) => {
    event.preventDefault();
	loginRequest();
};