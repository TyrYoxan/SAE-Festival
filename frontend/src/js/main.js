window.addEventListener('load', function() {
    loadSpectacles();
    loadStyles();
    loadSLieux();

    document.querySelector("#prevBtn").addEventListener("click", prevPage);
    document.querySelector("#nextBtn").addEventListener("click", nextPage);
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
    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/themes`)
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

let currentPage = 1;
const spectaclesPerPage = 8;
let allSpectacles = [];

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

            allSpectacles = data.spectacles;
            displayPage(currentPage);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
};

const displayPage = (page) => {
    const startIndex = (page - 1) * spectaclesPerPage;
    const endIndex = startIndex + spectaclesPerPage;

    const pageSpectacles = { spectacles: allSpectacles.slice(startIndex, endIndex) };

    let template = Handlebars.compile(spectacleTemplate);
    let result = template(pageSpectacles);

    document.querySelector(".show-list").innerHTML = result;
    updatePaginationControls();
};

const updatePaginationControls = () => {
    const totalPages = Math.ceil(allSpectacles.length / spectaclesPerPage);

    document.querySelector("#prevBtn").disabled = currentPage === 1;

    document.querySelector("#nextBtn").disabled = currentPage === totalPages;
};

const nextPage = () => {
    currentPage++;
    displayPage(currentPage);
};

const prevPage = () => {
    currentPage--;
    displayPage(currentPage);
};