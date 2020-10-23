let formData;
    
let nextAvailableDate = function() {
    let date = new Date();
    date.setDate(date.getDate() + 2);
    while(date.getDay() === 0 || date.getDay() === 6) {
        date.setDate(date.getDate() + 1);
    }
    date.setHours(8);
    date.setMinutes(0);
    return date;
}

flatpickr('#input-datetime', {
    locale : 'fr',
    altInput: true,
    inline : true,
    disable : [
        function(date) {
            return (date.getDay() === 0 || date.getDay() === 6);
        }
    ],
    monthSelectorType : "static",

    enableTime: true,
    time_24hr: true,
    minTime: "8:00",
    maxTime: "16:00",
    minuteIncrement : 30,

    altFormat : "j F Y à H\\hi",
    minDate : new Date().fp_incr(2),
    defaultDate : nextAvailableDate(),
});

document.getElementsByClassName('flatpickr-time-separator')[0].textContent = 'h';

function displayStep(step) {
    if (step === 'first') {
        document.getElementsByTagName('form')[1].style.display = 'none';
        document.getElementsByTagName('form')[0].style.display = 'block';
        document.getElementById('return-button').style.display = 'none';
    } else if (step === 'second') {
        document.getElementsByTagName('form')[0].style.display = 'none';
        document.getElementsByTagName('form')[1].style.display = 'block';
        document.getElementById('return-button').style.display = 'block';
    }
}

window.onsubmit = async (event) => {
    event.preventDefault();
    if (event.target.classList.contains('first-step')) {
        displayStep('second');
        formData= new FormData(event.target);
    } else if (event.target.classList.contains('second-step')) {
        formData.append('input-datetime', document.getElementById('input-datetime').value);
        let response = await fetch('php/tasks/encombrant-task.php', {method: 'POST', body: formData});
        response = await response.text();
        switch (response) {
            case "success":
                document.location.replace('index.php?success');
                break;
            case "error":
                displayError(document.getElementById('encombrant-submit'), "Une erreur est survenue.");
                break;
            case "file":
                displayError(document.getElementById('encombrant-submit'), "Erreur lors de l'upload de l'image.");
                break;
            case "missing":
                displayError(document.getElementById('encombrant-submit'), "Un champ est manquant.");
                break;
        }
    }
}

document.getElementById('return-button').onclick = () => {
    displayStep('first');
}