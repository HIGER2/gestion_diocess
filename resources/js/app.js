import './bootstrap';
import { createApp } from 'vue'; // Import Vue
import HomePage from "../vue/HomePage.vue"
import LoginPage from '../vue/LoginPage.vue';
import PreteManager from '../vue/PreteManager.vue';
import DiocesseDetailPage from '../vue/DiocesseDetailPage.vue';
import PreteDetailPage from '../vue/PreteDetailPage.vue';
import UtilisateurPage from '../vue/UtilisateurPage.vue';
import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import 'vue-toast-notification/dist/theme-sugar.css';
import DashboardPage from '../vue/DashboardPage.vue';
import InscriptionPage from '../vue/InscriptionPage.vue';
import LinkPage from '../vue/LinkPage.vue';
import AppLayout from '../vue/layouts/AppLayout.vue';
import LinkLoginPage from '../vue/LinkLoginPage.vue';
import UserPage from '../vue/UserPage.vue';
import AddPretePage from '../vue/AddPretePage.vue';
// Créez et montez l'application Vue
createApp({})
    .component('HomePage', HomePage)
    .component('LoginPage', LoginPage)
    .component('PreteAdd', AddPretePage)
    .component('PreteManager', PreteManager)
    .component('DiocesseDetailPage', DiocesseDetailPage)
    .component('PreteDetailPage', PreteDetailPage)
    .component('UtilisateurPage', UtilisateurPage)
    .component('DashboardPage', DashboardPage)
    .component('InscriptionPage', InscriptionPage)
    .component('LinkPage', LinkPage)
    .component('AppLayout', AppLayout)
    .component('LinkLoginPage', LinkLoginPage)
    .component('UserPage', UserPage)
    .use(ToastPlugin)
    .mount('#app');
