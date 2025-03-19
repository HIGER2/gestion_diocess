import axios from 'axios';
window.axios = axios;
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

window.axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response && error.response.status === 419) {
            alert("Votre session a expiré. Vous allez être redirigé vers la page de connexion.");
            window.location.href = "/auth/login";
            window.location.reload();
        } else {
            console.error("Une erreur est survenue :", error);
        }
        return Promise.reject(error);
    }
);
