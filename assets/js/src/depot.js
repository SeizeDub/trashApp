let autocompleteEl = document.getElementById('input-address');
let autocomplete, metropolygon;
let userAddress = {};

let formData;

async function initGoogleMaps() {
    dataAddress = await getUserAddress();
    userAddress.name = dataAddress.address;
    userAddress.lat = parseFloat(dataAddress.address_lat);
    userAddress.lng = parseFloat(dataAddress.address_lng);
    valid = true;
    userAddress.coordinates = new google.maps.LatLng({lat: userAddress.lat, lng: userAddress.lng});
    geocoder = new google.maps.Geocoder;
    map = new google.maps.Map(document.getElementById('map'), {
        center: userAddress.coordinates,
        zoom: 14,
        disableDefaultUI: true,
        fullscreenControl: true
    });

    marker = new google.maps.Marker({
        position: userAddress.coordinates,
        map: map,
        draggable:true,
        icon : {
            path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
            fillColor: '#CC1761',
            fillOpacity: 1,
            strokeColor: '#CC1761',
            strokeWeight: 3,
            scale: 1.5,
       }
    });

    metropolygon = await getMetropolygon();

	autocomplete = new google.maps.places.Autocomplete(autocompleteEl, {
		bounds : getPolygonBounds(metropolygon),
		strictBounds : true, 
		componentRestrictions : {country : "fr"},
		fields : ["address_components", "formatted_address", "geometry"],
		types : ["address"]
    });

    if (navigator.geolocation) {
        let geolocationEl = document.createElement('div');
        geolocationEl.id = 'geolocation';
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(geolocationEl);

        geolocationEl.onclick = () => {
            navigator.geolocation.getCurrentPosition(pos => {
                let position = {lat: pos.coords.latitude, lng: pos.coords.longitude};
                marker.setPosition(position);
                removeError(autocompleteEl);
                geocoder.geocode({'location': position}, results => {
                    let position = results[0];
                    autocompleteEl.value = position.formatted_address;
                    if (!google.maps.geometry.poly.containsLocation(marker.getPosition(), metropolygon)) {
                        displayError(autocompleteEl, "Veuillez sélectionner une adresse dépendante de Bordeaux Métropole.");
                        valid = false;
                        return;
                    }
                    userAddress.name = position.formatted_address;
                    userAddress.lat = position.geometry.location.lat();
                    userAddress.lng = position.geometry.location.lng();
                    valid = true;
                });
            });
        }
    }

    metropolygon.setMap(map);
    autocompleteEl.value = userAddress.name;

    autocompleteEl.onchange = () => {
		let pacContainerEl = document.getElementsByClassName('pac-container')[0];
		if (!pacContainerEl.matches(':hover')) {
			autocompleteEl.focus();
			autocompleteEl.dispatchEvent(new KeyboardEvent('keydown', {keyCode: 13}));
		}
	};

    marker.addListener('dragend', () => {
        removeError(autocompleteEl);
        position = {lat : marker.getPosition().lat(), lng : marker.getPosition().lng()};
        geocoder.geocode({'location': position}, results => {
            let position = results[0];
            autocompleteEl.value = position.formatted_address;
            if (!google.maps.geometry.poly.containsLocation(marker.getPosition(), metropolygon)) {
                displayError(autocompleteEl, "Veuillez sélectionner une adresse dépendante de Bordeaux Métropole.");
                valid = false;
                return;
            }
            userAddress.name = position.formatted_address;
            userAddress.lat = position.geometry.location.lat();
            userAddress.lng = position.geometry.location.lng();
            valid = true;
        });
    });

    autocomplete.addListener('place_changed', () => {
		if (!validatePlace()) {
            valid = false;
            return;
        }
        let place = autocomplete.getPlace();
        marker.setPosition(place.geometry.location);
        userAddress.name = place.formatted_address;
        userAddress.lat = place.geometry.location.lat();
        userAddress.lng = place.geometry.location.lng();
        valid = true;
	});
}

async function getMetropolygon() {
	let response = await fetch('assets/json/metropolygon.json');
	let data = await response.json();
	return new google.maps.Polygon({
        paths: data,
        strokeColor: '#86A332',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#86A332',
        fillOpacity: 0
    });
}

function getPolygonBounds(polygon) {
	let bounds = new google.maps.LatLngBounds();
	polygon.getPath().forEach(point => bounds.extend(point));
	return bounds;
}

async function getUserAddress() {
    let response = await fetch('php/tasks/address-task.php');
    let data = await response.json();
    return data;
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
        formData = new FormData(event.target);
    } else if (event.target.classList.contains('second-step')) {
        if (!valid) return;
        formData.append('input-address', userAddress.name);
        formData.append('input-lat', userAddress.lat);
        formData.append('input-lng', userAddress.lng);
        let response = await fetch('php/tasks/depot-task.php', {method: 'POST', body: formData});
        response = await response.text();
	    switch (response) {
            case "success":
                document.location.replace('index.php?success');
                break;
            case "error":
                displayError(document.getElementById('depot-submit'), "Une erreur est survenue.");
                break;
            case "file":
                displayError(document.getElementById('depot-submit'), "Erreur lors de l'upload de l'image.");
                break;
            case "missing":
                displayError(document.getElementById('depot-submit'), "Un champ est manquant.");
                break;
        }
    }
}

document.getElementById('return-button').onclick = () => {
    displayStep('first');
}