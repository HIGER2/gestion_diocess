
<script setup>

import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddDioceseComponent from './components/AddDioceseComponent.vue';
import { onMounted, ref } from 'vue';
import Empty from './components/Empty.vue';
import ContentLoading from './components/ContentLoading.vue';
import TableComponent from './components/diocese/TableComponent.vue';

const isModalOpen = ref(false)
const dioceses = ref()
const isLoading=ref(true)
const openModal = (state) => {
    isModalOpen.value = state
};

const hanldeliste = async () => {

    isLoading.value = true;
    await axios.get('/diocesse/all')
    .then(response => {
        if (response) {
            dioceses.value = response?.data?.data
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
    isLoading.value = false;
};
onMounted(() => {
    hanldeliste()
});
</script>

<template>
    <div>
            <div class="w-full">
                    <div class="flex justify-between items-center mb-5">
                        <h1 class="uppercase text-[16px] font-[800]">Gestion des diocèses ({{ dioceses?.total }})</h1>
                        <button type="button" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter un diocèse</button>
                    </div>
                    <ContentLoading v-if="isLoading"/>
                    <div v-else class="w-full flex flex-wrap mt-5 ">
                        <!-- {{ dioceses }} -->
                        <template v-if="dioceses?.data?.length > 0">
                            <div class="overflow-x-auto mt-4 border rounded-md w-full">
                                <table-component :dioceses="dioceses"/>
                            </div>
                            <!-- <div  style="width: calc(100% / 4 - 10px);" class=" border flex gap-3 p-2 cursor-pointer min-h-[100px] bg-white rounded-md m-[5px]"
                                v-for="(item, index) in dioceses?.data" :key="index"
                                >
                                <div class="w-[100px] h-[100px]">
                                    <img class="w-full h-full object-cover rounded-md" :src="item?.url_image || 'https://cdn.pixabay.com/photo/2016/11/18/22/37/cathedral-1837206_1280.jpg'" alt="">
                                </div>
                                <div class="flex flex-col justify-between ">
                                    <div class="text-blue-950 uppercase text-[13px] font-[600]">{{ item?.diocese }}</div>
                                    <div class="text-zinc-500"><i class="uil uil-map-marker-alt"></i> {{ item?.emplacement }}</div>
                                    <a :href="`/diocese-manager/${item?.id}`" class="max-w-max bg-zinc-200 text-center text-blue-950 p-1 px-2 rounded-md fw-medium text-[16px]">voir plus <i class="uil uil-angle-right"></i></a>
                                </div>
                            </div> -->
                            </template>
                            <Empty v-else/>
                    </div>
                    <Modal :isActive="isModalOpen" :onClose="openModal">
                        <add-diocese-component :callback="hanldeliste"/>
                    </Modal>
            </div>
    </div>
</template>

<!--
<style lang="scss" scoped>

</style> -->
