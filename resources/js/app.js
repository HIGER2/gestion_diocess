import './bootstrap';
import { createApp } from 'vue'; // Import Vue
import HomePage from "../vue/HomePage.vue"
// Créez et montez l'application Vue
createApp({})
    .component('HomePage', HomePage)
    .mount('#app');
