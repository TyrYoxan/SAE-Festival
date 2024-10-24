window.onload = () => {
    loadSpectacles();
    loadStyles();
}

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
