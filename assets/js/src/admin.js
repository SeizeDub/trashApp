[...document.getElementsByClassName('datetime')].forEach(element => {
    let datetime = new Date(element.textContent);

    let day = datetime.getDate();
    let month = capitalize(datetime.toLocaleString('default', { month: 'long' }));
    let year = datetime.getFullYear();

    let hour = datetime.getHours();
    let minutes = datetime.getMinutes().toString().padEnd(2, '0');

    let result = `<span>${day} ${month}</span><span>${hour}h${minutes} <span>-</span> ${hour + 2}h${minutes}</span>`;
    element.innerHTML = result;
});

[...document.getElementsByClassName('timestamp')].forEach(element => {
    let datetime = new Date(element.textContent);

    let day = datetime.getDate();
    let month = capitalize(datetime.toLocaleString('default', { month: 'long' }));
    let year = datetime.getFullYear();

    let result = `${day} ${month}`;
    element.innerHTML = result;
});

function capitalize(s) {
    return s.charAt(0).toUpperCase() + s.slice(1);
}

let articleEls = document.getElementsByTagName('article');

[...articleEls].forEach(element => {
    element.onclick = () => {
        [...articleEls].forEach(element => {
            element.classList.remove('active');
        });
            element.classList.add('active');
            element.getElementsByClassName('article-content')[0].insertBefore(document.getElementById('map'), element.getElementsByClassName('main-button')[0]);
            marker.setPosition({lat : parseFloat(element.dataset.lat), lng : parseFloat(element.dataset.lng)});
    }
})

let taskButtonEls = document.getElementsByClassName('task-button');
let containersEls = document.getElementsByClassName('container');

[...taskButtonEls].forEach(element => {
    element.onclick = () => {
        if (element.dataset.task === 'encombrants') {
            taskButtonEls[0].classList.add('active');
            containersEls[0].classList.add('active');
            taskButtonEls[1].classList.remove('active');
            containersEls[1].classList.remove('active');
            
            containersEls[0].getElementsByTagName('article')[0].click();
            
        }
        if (element.dataset.task === 'depots') {
            taskButtonEls[1].classList.add('active');
            taskButtonEls[0].classList.remove('active');
            containersEls[1].classList.add('active');
            containersEls[0].classList.remove('active');

            containersEls[1].getElementsByTagName('article')[0].click();
        }
    }
});

function initGoogleMaps() {
    let mapEl = document.getElementById('map');
    let mapContainer = mapEl.parentNode.parentNode;
    let position = {lat : parseFloat(mapContainer.dataset.lat), lng : parseFloat(mapContainer.dataset.lng)};

    map = new google.maps.Map(mapEl, {
        center: position,
        zoom: 14,
        disableDefaultUI: true,
        fullscreenControl: true
    });

    marker = new google.maps.Marker({
        position: position,
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
}

document.onclick = async (event) => {
    if (event.target.classList.contains('main-button')) {
        let task = event.target.dataset.task;
        let id = event.target.dataset.id;
        let response = await fetch(`php/tasks/archiver-task?task=${task}&id=${id}`);
        response = await response.text();

        if (response === "success") {
            document.location.reload();
        }
    }
}