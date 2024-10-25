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
            const atoken = data.atoken;
            const rtoken = data.rtoken;

            localStorage.setItem('atoken', atoken);
            localStorage.setItem('rtoken', rtoken);

            window.location.href = "index.html";
        })
        .catch(error => {
            document.querySelector("#auth-error").innerHTML = "Email ou mot de passe invalide";
            console.error('There was a problem with the fetch operation:', error);
        });
}

const isTokenExpired = (token) => {
    const payload = JSON.parse(atob(token.split('.')[1]));
    const expiry = payload.exp * 1000;
    return Date.now() > expiry;
};

const isLoggedIn = () => {
    const atoken = localStorage.getItem('atoken');
    if (atoken && !isTokenExpired(atoken)) {
        return true;
    } else {
        return false;
    }
};

const getPayLoad = () => {
    const atoken = localStorage.getItem('atoken'); // Assuming the access token is stored in LocalStorage

    if (!atoken) {
        console.error("No access token found");
        return null;
    }

    const tokenParts = atoken.split('.');

    if (tokenParts.length !== 3) {
        console.error("Invalid token format");
        return null;
    }

    const base64Url = tokenParts[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const payload = JSON.parse(atob(base64));

    return payload;
};

const getEmailFromToken = () => {
    return getPayLoad().data.email;
}

const getNameFromToken = () => {
    return getPayLoad().data.name;
}

const getUserId = () => {
    return getPayLoad().sub;
}

const getAccessToken = () => {
    return localStorage.getItem("atoken");
}

const signOut = () => {
    localStorage.removeItem("atoken");
    localStorage.removeItem("rtoken");

    window.location.href = "signin.html";
}

window.addEventListener('load', function() {
    if(isLoggedIn()) {
        try {
            document.querySelector("#auth-email").innerHTML = getEmailFromToken();
            document.querySelector("#auth-signout").style.display = "inline-block";
        } catch {}
        return;
    }
});
