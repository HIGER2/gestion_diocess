
<script setup>
import Modal from '../Modal.vue';
import AddPreteComponent from '../AddPreteComponent.vue';
import { ref } from 'vue';
import AddDioceseComponent from '../AddDioceseComponent.vue';
import AddUtilisateurComponent from '../AddUtilisateurComponent.vue';
const { item ,dioceses,hanldeliste} = defineProps([ 'item','dioceses','hanldeliste' ]);

const isModalOpen = ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

</script>


<template>
    <div>

        <span @click="openModal(true)" class="bg-gray-100 px-2 rounded-md py-2 hover:bg-zinc-200 " >
            <i class="uil uil-pen"></i>
        </span>

        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <AddUtilisateurComponent :callback="hanldeliste" :detail="item" :dioceses="dioceses"/>
                <!-- <AddDioceseComponent :detail="item"/> -->
                <!-- <add-prete-component :callback="hanldeliste" :detail="item" :dioceses="dioceses"/> -->
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
