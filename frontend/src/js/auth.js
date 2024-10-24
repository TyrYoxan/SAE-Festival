const signIn = () => {
    let email = document.querySelector("#email").value;
    let password = document.querySelector("#password").value;

    const base64Credentials = btoa(`${email}:${password}`);

    fetch('http://docketu.iutnc.univ-lorraine.fr:22000/users/signin', {
        method: 'POST',
        headers: {
            'Authorization': `Basic ${base64Credentials}`,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}
