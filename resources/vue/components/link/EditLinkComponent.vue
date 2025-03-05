
<script setup>
import Modal from '../Modal.vue';
import { ref } from 'vue';
import AddLinkComponent from './AddLinkComponent.vue';
const { item ,dioceses} = defineProps([ 'item','dioceses' ]);

const isModalOpen = ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

</script>


<template>
    <div>
        <span  class="bg-gray-100 px-2 hover:bg-zinc-200 rounded-md py-2"  @click="openModal(true)">
            <!-- {{ item }} -->
            <i class="uil uil-pen"></i>
        </span>

        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <AddLinkComponent  :callback="hanldeliste" :detail="item" :dioceses="dioceses"/>
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
