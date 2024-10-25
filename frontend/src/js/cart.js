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
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/panier/' + getUserId(),{
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

            console.log(data)

            let tarifSum = 0;

            data.panier.soirees.forEach(s => {
                tarifSum += parseInt(s.tarif) * s.quantite;
                s.tarif *= s.quantite;
            })

            data.panier.tarifSum = tarifSum;

            let template = Handlebars.compile(cartTemplate);
            let result = template(data.panier);

            let sCount = data.panier.soirees.length;

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

    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/panier/${getUserId()}/ajouter`, {
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

    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/panier/${getUserId()}/valider`, {
        method: "POST",
        headers: {
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

    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/panier/${getUserId()}/${itemID}`, {
        method: "DELETE",
        headers: {
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