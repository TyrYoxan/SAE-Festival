window.onload = () => {
    loadSpectacles();
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

const loadSpectacles = () => {
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/spectacles')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
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
