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

// Créez et montez l'application Vue
createApp({})
    .component('HomePage', HomePage)
    .component('LoginPage', LoginPage)
    .component('PreteManager', PreteManager)
    .component('DiocesseDetailPage', DiocesseDetailPage)
    .component('PreteDetailPage', PreteDetailPage)
    .component('UtilisateurPage', UtilisateurPage)
    .component('DashboardPage', DashboardPage)
    .use(ToastPlugin)
    .mount('#app');
