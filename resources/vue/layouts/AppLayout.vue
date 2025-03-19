
<script setup>
import { onMounted, provide, ref } from 'vue';

const {user,diocese}=defineProps(['user','diocese'])
const isOpen = ref(false)
const route = ref()
const setOpen = (state) => {
    isOpen.value = !state
};
    provide('user',user)
    provide('diocese',diocese)

const routeActive = (path = "") => {

    let pathName  = location?.pathname
    let routes = ["", "diocese-manager", "prete-manager"];
  // Supprimer tous les slashes à la fin du chemin
    pathName = pathName.replace(/\/+$/, "");

    let basePath = pathName.split("/")[ 1 ] || " ";

  if (path === basePath) {
    return 'text-primary font-semibold';
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
                icon:'uil-create-dashboard'
        },
        {
            name: "Gestion des Diocèses",
            path: "/diocese-manager",
            pathActive: "diocese-manager",
            icon:"uil-home"
        },
        {
            name: "Gestion des Prêtres",
            path: "/prete-manager",
            pathActive: "prete-manager",
            icon: "uil-users-alt",
        },
        {
            name: "Gestion des liens",
            path: "/link-manager",
            pathActive: "link-manager",
            icon:'uil-link-alt'
        },
        {
            name: "Adminitrateurs Diocésain",
            path: "/utilisateur-manager",
            icon: "uil-users-alt",
            pathActive: "utilisateur-manager",
        }
    ],
    "admin": [
       {
                name: "Tableau de bord",
                path: "/",
                pathActive: " ",
                icon:'uil-create-dashboard'
        },
        // {
        //     name: "Gestion des Diocèses",
        //     path: "/diocese-manager",
        //     pathActive: "diocese-manager",
        //     icon:"uil-home"
        // },
        {
            name: "Gestion des Prêtres",
            path: "/prete-manager",
            pathActive: "prete-manager",
            icon: "uil-users-alt",
        },
        {
            name: "Gestion des liens",
            path: "/link-manager",
            pathActive: "link-manager",
            icon:'uil-link-alt'
        },
        {
            name: "Adminitrateurs Diocésain",
            path: "/utilisateur-manager",
            icon: "uil-users-alt",
            pathActive: "utilisateur-manager",
        }
    ]
}

const  goBack =()=> {
      window.history.back(); // Accède directement à l'objet "window.history"
}

onMounted(() => {

    console.log('====================================');
    console.log(user);
    console.log('====================================');
});
</script>

<template>
    <div class=" min-h-screen  bg-gray-50">
        <div class="w-[250px] h-screen bg-white fixed top-0  ">

            <a href="/user" class="flex w-full items-center gap-2 h-[60px] px-4 border-b border-b-gray-100 cursor-pointer relative " @click="setOpen(isOpen)">
                <div class=" flex items-center rounded-md w-[60px] overflow-hidden justify-center  ">
                    <img src="@/image/logo.jpg" alt="" class="w-[50px] rounded-full">
                </div>
                <div class="capitalize text-primary font-[600] flex flex-col  overflow-hidden">
                    <span>{{ user?.nom }}</span>
                    <span v-if="diocese" class="text-[13px] lowercase text-gray-600  font-mono text-nowrap  overflow-hidden text-ellipsis">
                        {{ diocese?.diocese}}
                    </span>
                </div>
            </a>
            <ul class="w-full px-4">
            <li v-for="(item, index) in routes[user?.role]" :key="index" class="mb-0  ">
                <!-- Your HTML file -->
                <a
                    :href="item?.path"
                    :class="routeActive(item?.pathActive)"
                    class="max-w-max capitalize text-[14px] p-4 leading-normal  gap-2 items-center  text-gray-600  flex px-2 rounded-md">
                    <i class="uil" :class="item?.icon"></i>
                    <span> {{ item?.name }}</span>

                </a>
            </li>
            </ul>
        </div>
        <!-- <div class="w-full h-[70px] bg-primary p-1 px-4 flex items-center justify-between sticky top-0 shadow-sm">
        <div class="flex items-center gap-3 bg-zinc-200 p-2 rounded-md">

                <a v-for="(item, index) in routes[user?.role]" :key="index"
                    :href="item?.path"
                    :class="routeActive(item?.pathActive)" class="max-w-max capitalize text-[13px] leading-normal  text-gray-600 p-1 px-2 rounded-md">
                    {{ item?.name }}
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
        </div> -->
        <section class="w-[calc(100%-250px)] relative left-[250px]">
            <div class="w-full  h-[60px]  bg-primary p-1 px-6 flex items-center justify-between sticky top-0 shadow-sm">
                <button type="button" class="w-[45px] text-[25px] h-[45px] bg-gray-50 rounded-[50%]" @click="goBack()">
                    <i class="uil uil-arrow-left"></i>
                </button>
                <!-- <div class="flex items-center gap-3 bg-zinc-200 p-2 rounded-md">

                    <a v-for="(item, index) in routes[user?.role]" :key="index"
                        :href="item?.path"
                        :class="routeActive(item?.pathActive)" class="max-w-max capitalize text-[13px] leading-normal  text-gray-600 p-1 px-2 rounded-md">
                        {{ item?.name }}
                    </a>
                </div> -->
                <!-- <div class="flex items-center gap-1 cursor-pointer relative " @click="setOpen(isOpen)">
                <div  class="w-[50px] h-[50px] cursor-pointer rounded-[50%] bg-white flex align-middleflex items-center justify-center">
                    <i class="uil uil-user text-[20px] text-primary"></i>
                </div>
                <div class="capitalize text-white text-[14px] font-[600]">{{ user?.role }}</div>
                    <i class="uil uil-angle-down text-white font-[600]"></i>
                    <div :class="[ isOpen ? 'opacity-100' : 'opacity-0 hidden']" class=" transition-all duration-75 absolute top-[130%] right-0 min-h-[10px] bg-white rounded-md shadow-lg min-w-[200px] p-2">
                        <ul class="w-full">
                            <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 " ><span class="w-full block" @click="logout">Déconnexion</span></li>
                        </ul>
                    </div>
                </div> -->
                <button @click="logout" class="border  border-gray-50 hover:bg-primary hover:text-gray-50 text-gray-50 transition-all duration-300 rounded-[999px] px-[20px] py-1">Déconnexion</button>
<!--
                <div class="w-full p-2 sticky top-0  bg-white px-4 flex justify-end items-center ">
                    <button class="border-2  border-primary hover:bg-primary hover:text-white transition-all duration-300 rounded-[999px] px-[20px] py-1">Déconnexion</button>
                </div> -->
            </div>
            <div class="mt-6 py-4 px-6">
                <slot/>
            </div>
        </section>
    </div>
</template>
