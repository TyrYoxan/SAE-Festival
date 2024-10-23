window.onload = () => {
    const params = new URLSearchParams(window.location.search);
    const soireeId = params.get('soiree');
    loadSoiree(soireeId);
}

const soireeTemplate = `    
    <div class="container">
        <h1>{{name}}</h1>
        <p class="theme"><strong>Thématique :</strong> {{theme}}</p>
        <p class="date"><strong>Date :</strong> {{date}}</p>
        <p class="heure"><strong>Heure :</strong> {{hour}}</p>
        <p class="lieu"><strong>Lieu :</strong> {{lieu}}</p>
        <p class="tarifs">
            <strong>Tarifs :</strong>
            <ul>
                <li>Tarif Normal : {{tarif_normal}} €</li>
                <li>Tarif Réduit (étudiants, demandeurs d'emploi) : {{tarif_reduit}} €</li>
            </ul>
        </p>
        
        <h2>Spectacles Prévus</h2>
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
