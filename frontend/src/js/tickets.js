import config from './config';

window.addEventListener('load', function() {
    if(isLoggedIn())
        loadTickets(getUserId());
});

const ticketTemplate = `
    <div class="container">
        <h1>Mes Billets</h1>

        {{#billets}}
        <div class="billet">
            <h2>{{soiree}} - {{date_soiree}}</h2>
            <p><strong>Lieu :</strong> {{lieu}} - {{heure_soiree}}</p>
            <p><strong>Nombre de billets :</strong> {{quantite}} - Tarif {{tarif}}</p>
            <p><strong>Nom de l'acheteur :</strong> {{utilisateur}}</p>
            <p><strong>Référence du billet :</strong> {{id}}</p>
            <button class="btn" onclick="window.print()">Imprimer</button>
        </div>
        {{/billets}}
        
        <div class="no-tickets" style="display:none;">
            <p>Vous n'avez acheté aucun billet pour le moment.</p>
        </div>
    </div>`;

const loadTickets = (userID) => {
    fetch(config.apiBaseUrl + ':' + config.apiPort + `/users/${userID}/billets`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${getAccessToken()}`,
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            let template = Handlebars.compile(ticketTemplate);
            let result = template(data);

            document.querySelector("#mes-billets").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}