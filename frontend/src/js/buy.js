window.addEventListener('load', function() {
    loadBuyCart();
});

const buyCartTemplate = `
    <p>Mon panier</p>
    <div id="shopping-cart-items">
        {{#soirees}}
        <div class="sep"></div>
        <h4>{{name}}</h4>
        <p>{{date}} {{hour}}</p>
        <small>{{lieu}} x{{quantite}} - {{tarif}}€</small>
        <i class="fa-solid fa-trash"></i>
        {{/soirees}}
    </div>
    <h4>Total: {{tarifSum}}€</h4>`;

const loadBuyCart = () => {
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/panier/' + getUserId(), {
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

            let tarifSum = 0;

            data.panier.soirees.forEach(s => {
                tarifSum += parseInt(s.tarif) * s.quantite;
                s.tarif *= s.quantite;
            })

            data.panier.tarifSum = tarifSum;

            let template = Handlebars.compile(buyCartTemplate);
            let result = template(data.panier);


            document.querySelector(".cart").innerHTML = result;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

const payCart = () => {

    const expiryDate = document.querySelector("#expiry-date");
    const cardNumber = document.querySelector("#card-number");
    const cvv = document.querySelector("#cvv");

    fetch(`http://docketu.iutnc.univ-lorraine.fr:22000/panier/${getUserId()}/payer`, {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${getAccessToken()}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            expiryDate: expiryDate,
            cardNumber: cardNumber,
            cvv: cvv
        })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response;
        })
        .then(data => {
            window.location.href = "tickets.html";
        })
        .catch(error => {
            alert('There was a problem with the fetch operation:', error);
        });
}
