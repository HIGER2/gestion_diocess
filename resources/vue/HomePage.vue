
<script setup>

import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddDioceseComponent from './components/AddDioceseComponent.vue';
import { onMounted, ref } from 'vue';
const isModalOpen = ref(false)
const dioceses =ref()
const openModal = (state) => {
    isModalOpen.value = state
};

const hanldeliste = async () => {
    axios.get('/diocesse/all')
    .then(response => {
        if (response) {
            dioceses.value = response?.data?.data
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
onMounted(() => {
    hanldeliste()
});
</script>

<template>
    <div>
        <app-layout>
            <div class="w-full">
                    <div class="flex justify-between items-center">
                        <h1 class="uppercase text-[16px] font-[800]">Aperçus des diocesses</h1>
                        <button type="button" @click="openModal(true)" class="bg-blue-950 text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter une diocese</button>
                    </div>
                    <div class="w-full flex flex-wrap mt-5">
                        <div style="width: calc(100% / 4 - 10px);" class=" flex gap-3 p-2 cursor-pointer min-h-[100px] bg-white rounded-md m-[5px]"
                        v-for="(item, index) in dioceses" :key="index"
                        >
                        <div class="w-[100px] h-[100px]">
                            <img class="w-full h-full object-cover rounded-md" src="https://cdn.pixabay.com/photo/2016/11/18/22/37/cathedral-1837206_1280.jpg" alt="">
                        </div>
                        <div class="flex flex-col justify-between ">
                            <div class="text-blue-950 uppercase text-[13px] font-[600]">{{ item?.diocese }}</div>
                            <div class="text-zinc-500"><i class="uil uil-map-marker-alt"></i> {{ item?.emplacement }}</div>
                            <a :href="`/diocese/${item?.id}`" class="max-w-max bg-zinc-200 text-center text-blue-950 p-1 px-2 rounded-md fw-medium text-[16px]">voir plus <i class="uil uil-angle-right"></i></a>
                        </div>
                        </div>
                    </div>
                    <Modal :isActive="isModalOpen" :onClose="openModal">
                        <add-diocese-component/>
                    </Modal>
            </div>
        </app-layout>
    </div>
</template>

<!--
<style lang="scss" scoped>

</style> -->
