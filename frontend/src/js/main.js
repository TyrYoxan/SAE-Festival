window.addEventListener('load', function() {
    loadSpectacles();
    loadStyles();
    loadSLieux();
});

const spectacleTemplate = `  
    {{#spectacles}}          
    <li class="show-item">
        <img src="img/{{firstImage}}" alt="{{titre}}">
        <div>
            <h3>{{titre}}</h3>
            <p>{{date}} {{horaire_previsionnel}}</p>
            <a href="details.html?soiree={{id_soiree}}">Détails de la soirée</a>
        </div>
    </li>
    {{/spectacles}}`;

const styleTemplate = `
    <option value="0">Tous les styles</option>
    {{#theme}}
    <option value="{{id}}">{{name}}</option>
    {{/theme}}`;

const lieuTemplate = `
    <option value="0">Tous les lieux</option>
    {{#lieux}}
    <option value="{{id}}">{{name}}</option>
    {{/lieux}}`;

const lieuDetailsTemplate = `
        {{#lieux}}
        <li>
            <h3>{{name}}</h3>
            <p>Adresse: {{address}}</p>
            <p>Capacité: {{nbrPlaceAssise}} places assises, {{nbrPlaceDebout}} debout</p>
            <img src="img/{{firstImage}}" />
        </li>
        {{/lieux}}`;

let type = 0;
let lieu = 0;
let date = 0;

const changeType = (v) => {
    type = v;
    loadSpectacles();
}

const changeLieu = (v) => {
    lieu = v;
    loadSpectacles();
}

const changeDate = (v) => {
    date = v;
    loadSpectacles();
}

const loadStyles = () => {
    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/soirees/themes`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {

            console.log(data);

            let template = Handlebars.compile(styleTemplate);
            let result = template(data);

            document.querySelector("#filter-style").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const loadSLieux = () => {
    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/lieux`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            data.lieux.forEach(lieu => {
                const imagesArray = JSON.parse(lieu.images);
                lieu.firstImage = imagesArray[0];
            });

            let template = Handlebars.compile(lieuTemplate);
            let result = template(data);

            let template2 = Handlebars.compile(lieuDetailsTemplate);
            let result2 = template2(data);



            document.querySelector("#filter-lieu").innerHTML = result;
            document.querySelector(".venue-list").innerHTML = result2;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const loadSpectacles = () => {
    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/spectacles?type=${type}&lieu=${lieu}&date=${date}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(`http://docketu.iutnc.univ-lorraine.fr:22000/spectacles?type=${type}&lieu=${lieu}&date=${date}`)
            data.spectacles.forEach(spectacle => {
                spectacle.firstImage = JSON.parse(spectacle.images)[0];
            });

            let template = Handlebars.compile(spectacleTemplate);
            let result = template(data);

            document.querySelector(".show-list").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}
