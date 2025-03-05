
<script setup>
import { ref } from 'vue';
import Modal from './Modal.vue';
const { isOpen, onClose, callback } = defineProps([ 'isOpen', 'onClose', 'callback' ]);

const callToAction = async () => {

    if (callback) {
        await callback()
        onClose()
    }
};
</script>

<template>
    <div>
        <Modal :isActive="isOpen" :onClose="onClose">
            <div class="w-[400px] min-h-[100px] bg-white rounded-lg p-5 text-center">
                <div class="flex mx-auto items-center justify-center w-[80px] h-[80px] bg-red-100 rounded-[50%]">
                    <i class="uil uil-exclamation-triangle text-red-900 text-[19px]"></i>
                </div>
                <div class="my-5 text-[16px] font-[600] text-zinc-900">
                    Voulez vous éffectuer cette action ?
                </div>
                <div class="flex justify-between items-center text-sm">
                    <button @click="onClose" class="max-w bg-zinc-200 p-2 px-5 rounded-md">Annuler</button>
                    <button @click="callToAction" class="max-w p-2 px-5 rounded-md bg-red-600 text-white">Confirmer</button>
                </div>
            </div>
        </Modal>
    </div>
</template>


<style lang="scss" scoped>

</style>
