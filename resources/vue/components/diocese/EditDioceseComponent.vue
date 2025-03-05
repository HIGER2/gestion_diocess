
<script setup>
import Modal from '../Modal.vue';
import AddPreteComponent from '../AddPreteComponent.vue';
import { ref } from 'vue';
import AddDioceseComponent from '../AddDioceseComponent.vue';
const { item ,dioceses} = defineProps([ 'item','dioceses' ]);

const isModalOpen = ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

</script>


<template>
    <div>

        <span @click="openModal(true)" class="cursor-pointer bg-gray-300 text-zinc-800 px-3 rounded-md py-2 hover:bg-gray-400 " >
            <i class="uil uil-pen"></i>
        </span>

        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <AddDioceseComponent :detail="item"/>
                <!-- <add-prete-component :callback="hanldeliste" :detail="item" :dioceses="dioceses"/> -->
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
