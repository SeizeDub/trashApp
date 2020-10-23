let registerFormEl = document.getElementById('register-form');
let autocompleteEl = document.getElementById('input-address');
let autocomplete, metropolygon;

/**
 * Main function, gets called by the Google Maps script callback
 * Initializes the autocomplete input with its settings and events
 */
async function initAutocomplete() {
	metropolygon = await getMetropolygon();
	autocomplete = new google.maps.places.Autocomplete(autocompleteEl, {
		bounds : getPolygonBounds(metropolygon),
		strictBounds : true, 
		componentRestrictions : {country : "fr"},
		fields : ["address_components", "formatted_address", "geometry"],
		types : ["address"]
	});
	autocomplete.addListener('place_changed', () => {
		validatePlace();
	});
	// Changes autocomplete associated data to current input value on change
	autocompleteEl.onchange = () => {
		let pacContainerEl = document.getElementsByClassName('pac-container')[0];
		if (!pacContainerEl.matches(':hover')) {
			autocompleteEl.focus();
			autocompleteEl.dispatchEvent(new KeyboardEvent('keydown', {keyCode: 13}));
		}
	};
}

function validatePlace() {
	let place = autocomplete.getPlace();
	if (place === undefined || !place.address_components || place.address_components[0].types[0] !== "street_number") {
		displayError(autocompleteEl, "Veuillez renseigner une adresse de domicile valide.");
		return false;
	}
	let placeLocation = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
    if (!google.maps.geometry.poly.containsLocation(placeLocation, metropolygon)) {
		displayError(autocompleteEl, "Veuillez sélectionner une adresse dépendante de Bordeaux Métropole.");
		return false;
	}
	return true;
}

async function registerRequest() {
	let submitButton = document.getElementById('register-submit');
	removeError(submitButton);
	let data = new FormData(registerFormEl);
	let place = autocomplete.getPlace();
	data.append('input-lat', place.geometry.location.lat());
	data.append('input-lng', place.geometry.location.lng());
	let response = await fetch('php/tasks/register-task.php', {method: 'POST', body: data})
	response = await response.text();
	switch (response) {
		case "success":
			document.location.replace('index.php');
			break;
		case "missing":
			displayError(submitButton, "Un champ est manquant.");
			break;
		case "email":
			displayError(document.getElementById('input-email'), "Cette adresse e-mail est déjà utilisée.");
			break;
		case "error":
			displayError(submitButton, "Une erreur est survenue.");
			break;
	}
}

/**
 * Gets metropolygon data
 * Returns a Polygon object
 */
async function getMetropolygon() {
	let response = await fetch('assets/json/metropolygon.json');
	let data = await response.json();
	return new google.maps.Polygon({paths : data});
}

/**
 * Get polygon bounds
 * Returns a LatLngBounds object
 */
function getPolygonBounds(polygon) {
	let bounds = new google.maps.LatLngBounds();
	polygon.getPath().forEach(point => bounds.extend(point));
	return bounds;
}

registerFormEl.onsubmit = (event) => {
	event.preventDefault();
	if (validatePlace()) {
		registerRequest();
	}
};