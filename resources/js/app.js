import './bootstrap';
import { createApp } from 'vue'; // Import Vue
import HomePage from "../vue/HomePage.vue"
import LoginPage from '../vue/LoginPage.vue';
import PreteManager from '../vue/PreteManager.vue';
import DiocesseDetailPage from '../vue/DiocesseDetailPage.vue';
// Créez et montez l'application Vue
createApp({})
    .component('HomePage', HomePage)
    .component('LoginPage', LoginPage)
    .component('PreteManager', PreteManager)
    .component('DiocesseDetailPage', DiocesseDetailPage)
    .mount('#app');
