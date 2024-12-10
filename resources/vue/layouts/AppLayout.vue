
<script setup>
import { onMounted, provide, ref } from 'vue';

const {user}=defineProps(['user'])
const isOpen = ref(false)
const route = ref()
const setOpen = (state) => {
    isOpen.value = !state
};
    provide('user',user)

const routeActive = (path = "") => {

    let pathName  = location?.pathname
    let routes = ["", "diocese-manager", "prete-manager"];
  // Supprimer tous les slashes à la fin du chemin
    pathName = pathName.replace(/\/+$/, "");

    let basePath = pathName.split("/")[ 1 ] || " ";
    console.log(path,basePath);

  if (path === basePath) {
    return 'bg-white text-primary';
  }
  return '';
};


const logout = async () => {
    axios.get('/auth/logout')
    .then(response => {
        if (response.data.redirect) {
            window.location.href = response.data.redirect;
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
const routes = {
    "super_admin": [
        {
                name: "Tableau de bord",
                path: "/",
                pathActive: " ",
        },
        {
            name: "Gestion des Diocèses",
            path: "/diocese-manager",
            pathActive: "diocese-manager",
        },
        {
            name: "Gestion des Prêtres",
            path: "/diocese-manager",
            path: "/prete-manager",
            pathActive: "prete-manager",
        }
    ],
    "admin": [
            {
                name: "Tableau de bord",
                path: "/",
                pathActive: " ",
        },
        {
            name: "Gestion des Diocèses",
            path: "/diocese-manager",
            pathActive: "diocese-manager",
        },
    ]
}
onMounted(() => {
});
</script>

<template>
    <div class="bg-white min-h-screen">
        <div class="w-full h-[70px] bg-primary p-1 px-4 flex items-center justify-between sticky top-0 shadow-sm">
            <div class="flex items-center gap-3 bg-zinc-200 p-2 rounded-md">
                <!-- <a href="/" :class="routeActive(' ')" class="max-w-max  text-gray-600 p-1 px-2 rounded-md text-[14px] leading-normal">Tableau de bord</a> -->
                <!-- <a href="/diocese-manager" :class="routeActive('diocese-manager')"  class="max-w-max  text-gray-600 p-1 px-2 rounded-md text-[14px] leading-normal">Gestion des Diocèses</a> -->
                <a v-for="(item, index) in routes[user?.role]" :key="index"
                    :href="item?.path"
                    :class="routeActive(item?.pathActive)" class="max-w-max capitalize text-[13px] leading-normal  text-gray-600 p-1 px-2 rounded-md">
                    {{ item?.name }}
                    <!-- {{  }} -->
                </a>
            </div>
            <div class="flex items-center gap-1 cursor-pointer relative " @click="setOpen(isOpen)">
            <div  class="w-[50px] h-[50px] cursor-pointer rounded-[50%] bg-white flex align-middleflex items-center justify-center">
                <i class="uil uil-user text-[20px] text-primary"></i>
            </div>
                <div class="capitalize text-white font-[600]">{{ user?.role }}</div>
                <i class="uil uil-angle-down text-white font-[600]"></i>
                <div :class="[ isOpen ? 'opacity-100' : 'opacity-0 hidden']" class=" transition-all duration-75 absolute top-[130%] right-0 min-h-[100px] bg-white rounded-md shadow-lg min-w-[200px] p-2">
                    <ul class="w-full">
                        <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 "><a class="w-full block" href="/utilisateur-manager">Utilisateurs</a></li>
                        <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 "><a class="w-full block" href="/link-manager">Gestion des liens</a></li>
                        <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 " ><span class="w-full block" @click="logout">Déconnexion</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="w-full p-4  ">
            <slot/>
        </section>
    </div>
</template>
