import { config } from './config.js';
import { getUserId, getAccessToken, isLoggedIn } from './auth.js';

window.addEventListener('load', function() {
    if(!isLoggedIn())
        return document.querySelector(".shopping-cart").style.display = "none";

    try {
        const cartIcon = document.querySelector('.shopping-cart');
        const cartContent = document.querySelector('.shopping-cart-content');

        cartIcon.addEventListener('mouseenter', () => {
            cartContent.style.display = 'flex';
        });

        cartIcon.addEventListener('mouseleave', () => {
            cartContent.style.display = 'none';
        });

        loadCart();
    } catch {}
});

const cartTemplate = `
    <p>Mon panier</p>
    <div id="shopping-cart-items">
        {{#soirees}}
        <div class="sep"></div>
        <h4>{{name}}</h4>
        <p>{{date}} {{hour}}</p>
        <small>{{lieu}} x{{quantite}} - {{tarif}}€</small>
        <i onclick="deleteItemFromCart({{id}})" class="fa-solid fa-trash"></i>
        {{/soirees}}
    </div>
    <button onclick="validateCart()">Valider le Panier ({{tarifSum}}€)</button>`;

const loadCart = () => {
    fetch(config.apiBaseUrl + ':' + config.apiPort + '/panier/' + getUserId(),{
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

            if(data.panier.length == 0)
                return document.querySelector(".shopping-cart").style.display = "none";

            let tarifSum = 0;

            data.panier.soirees.forEach(s => {
                tarifSum += parseInt(s.tarif) * s.quantite;
                s.tarif *= s.quantite;
            })

            data.panier.tarifSum = tarifSum;

            let template = Handlebars.compile(cartTemplate);
            let result = template(data.panier);

            let sCount = data.panier.soirees.length;

            console.log(sCount)

            if(sCount > 0)
                document.querySelector(".shopping-cart-count").innerHTML = sCount + "";

            else if(sCount == 0)
                document.querySelector(".shopping-cart").style.display = "none";

            document.querySelector(".shopping-cart-content").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const addToCart = (soireeID) => {
    if(!isLoggedIn()) {
        return alert("Vous n'êtes pas connecté. Connectez-vous pour ajouter une soirée dans votre panier.")
    }

    let qte = document.querySelector("#cart-qte").value;
    let reduit = false;

    if(document.querySelector("#tarif_normal").checked)
        reduit = false;
    else if(document.querySelector("#tarif_reduit").checked)
        reduit = true;

    const base64Credentials = btoa(`${soireeID}:${qte}:${reduit}`);

    fetch(config.apiBaseUrl + ':' + config.apiPort + `/panier/${getUserId()}/ajouter`, {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${getAccessToken()}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            soireeID: soireeID,
            qte: qte,
            reduit: reduit ? '1' : '0'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response;
    })
    .then(data => {
        window.location.href = "buy.html";
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}

const validateCart = () => {
    if(!isLoggedIn()) {
        return alert("Vous n'êtes pas connecté. Connectez-vous pour valider votre panier.")
    }

    fetch(config.apiBaseUrl + ':' + config.apiPort + `/panier/${getUserId()}/valider`, {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${getAccessToken()}`,
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response;
        })
        .then(data => {
            window.location.href = "buy.html";
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const deleteItemFromCart = (itemID, el) => {
    if(!isLoggedIn()) {
        return alert("Vous n'êtes pas connecté. Connectez-vous pour valider votre panier.")
    }

    fetch(config.apiBaseUrl + ':' + config.apiPort + `/panier/${getUserId()}/${itemID}`, {
        method: "DELETE",
        headers: {
            'Authorization': `Bearer ${getAccessToken()}`,
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response;
        })
        .then(data => {
            window.location.reload();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}