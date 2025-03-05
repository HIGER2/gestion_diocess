
<script setup>
import Modal from '../Modal.vue';
import AddPreteComponent from '../AddPreteComponent.vue';
import { ref } from 'vue';
const { item ,dioceses} = defineProps([ 'item','dioceses' ]);

const isModalOpen = ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

</script>


<template>
    <div>
        <span  class="bg-custom px-2 hover:bg-zinc-200 rounded-md py-2"  @click="openModal(true)">
            <!-- {{ item }} -->
            <i class="uil uil-pen"></i>
        </span>

        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <add-prete-component :callback="hanldeliste" :detail="item" :dioceses="dioceses"/>
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
