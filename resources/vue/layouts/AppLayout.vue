
<script setup>
import { onMounted, ref } from 'vue';
const isOpen = ref(false)
const setOpen = (state) => {
    isOpen.value = !state
};
</script>

<template>
    <div class="bg-zinc-100 min-h-screen">
        <div class="w-full h-[70px] bg-white p-1 px-4 flex items-center justify-between sticky top-0 shadow-sm">
            <div class="flex items-center gap-3 bg-zinc-200 p-2 rounded-md">
                <a href="/" class="max-w-max bg-white text-gray-600 p-1 px-2 rounded-md text-[14px] leading-normal">Tableau de bord</a>
                <a href="/diocese-manager" class="max-w-max  text-gray-600 p-1 px-2 rounded-md text-[14px] leading-normal">Gestion des Diocèses</a>
                <a href="/prete-manager" class="max-w-max capitalize text-[13px] leading-normal bg-zinc-200 text-gray-600 p-1 px-2 rounded-md">Gestion des Prêtres</a>
            </div>
            <div class="flex items-center gap-1 cursor-pointer relative " @click="setOpen(isOpen)">
            <div  class="w-[50px] h-[50px] cursor-pointer rounded-[50%] bg-zinc-200 flex align-middleflex items-center justify-center"><i class="uil uil-user text-[20px]"></i></div>
                <div>Admin</div>
                <i class="uil uil-angle-down"></i>
                <div :class="[ isOpen ? 'opacity-100' : 'opacity-0 hidden']" class=" transition-all duration-75 absolute top-[130%] right-0 min-h-[100px] bg-white rounded-md shadow-lg min-w-[200px] p-2">
                    <ul class="w-full">
                        <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 "><a href="">Utilisateurs</a></li>
                        <li class="p-2 hover:bg-gray-100 rounded-md text-sm font-[600] text-gray-600 "><span>Déconnexion</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="w-full p-4 ">
            <slot/>
        </section>
    </div>
</template>
