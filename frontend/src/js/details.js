window.onload = () => {
    const params = new URLSearchParams(window.location.search);
    const soireeId = params.get('soiree');
    loadSoiree(soireeId);

    if(isLoggedIn() && getPayLoad().data.role == 100) {
        showPlacesRemaining(soireeId);
    }
}

const soireeTemplate = `    
    <div class="container">
        <h1>{{name}}</h1>
        <p class="theme"><strong>Thématique :</strong> {{theme}}</p>
        <p class="date"><strong>Date :</strong> {{date}}</p>
        <p class="heure"><strong>Heure :</strong> {{hour}}</p>
        <p class="lieu"><strong>Lieu :</strong> {{lieu}}</p>
        <strong>Tarifs :</strong>
        <ul>
            <li>
                <input checked type="radio" id="tarif_normal" name="tarif" value="t_normal">
                <label for="tarif_normal">Tarif Normal : {{tarif_normal}} €</label>
            </li>
            <li>
                <input type="radio" id="tarif_reduit" name="tarif" value="t_reduit">
                <label for="tarif_reduit">Tarif Réduit (étudiants, demandeurs d'emploi) : {{tarif_reduit}} €</label>
            </li>
        </ul>
        <button onclick="addToCart({{id}})" class="btn">Ajouter au Panier</button>
        <input min="1" style="width: 40px" id="cart-qte" type="number" value="1" />
        <br /><br />
        <h2>Spectacles Prévus</h2>
        <br />
        {{#spectacles}}
        <div class="spectacle">
            <h3>{{title}}</h3>
            <p><strong>Artistes :</strong> {{artists}}</p>
            <p><strong>Description :</strong> {{description}}</p>
            <p><strong>Horaire :</strong> {{heure}}</p>
            <a href="{{videoUrl}}"><strong>Vidéo :</strong> Vidéo</a>
            <div class="images">
                {{#each images}}
                    <img src="./img/{{this}}" alt="{{../title}}">
                {{/each}}
            </div>

        </div>
        {{/spectacles}}
    </div>`;

const loadSoiree = (soireeId) => {
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/soirees/' + soireeId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const soireeData = data.soiree;

            console.log(data)

            soireeData.spectacles.forEach(spectacle => {
                spectacle.images = JSON.parse(spectacle.images);
            });

            soireeData.tarif_normal = soireeData.tarifs[0];
            soireeData.tarif_reduit = soireeData.tarifs[1];

            let template = Handlebars.compile(soireeTemplate);
            let result = template(soireeData);

            document.querySelector("#details-soiree").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const showPlacesRemaining = (soireeId) => {
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/soirees/nbPlacesVendues/' + soireeId, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${getAccessToken()}`,
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {

            console.log(data)

            let vendues = 30;
            let dispo = data.placesDisponibles;

            let percentage = (dispo / (dispo + vendues)) * 100;

            let progressBarElement = `
                <div class="progress-bg">
                    <div class="progress" style="width: ${percentage}%">
                        
                    </div>
                    <div class="progress-text">
                        ${Math.round(percentage)}% (${dispo})
                    </div>
                </div>`;

            document.querySelector("#details-soiree").innerHTML = progressBarElement + document.querySelector("#details-soiree").innerHTML;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}
