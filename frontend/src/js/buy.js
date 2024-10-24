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
    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/panier/' + getUserId())
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
    window.location.href = "tickets.html";
}
