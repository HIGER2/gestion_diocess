
<script setup>
import { onMounted, ref } from 'vue';
import AlertModal from '../AlertModal.vue';
import {useToast} from 'vue-toast-notification';

const { item } = defineProps([ 'item' ]);

const isOpen = ref(false)
const errrMessage = ref("")
const setOpen = (state) =>{
    isOpen.value = state
}

const handleDelete =async (formData) => {
    errrMessage.value = ""
    await axios.delete(`/diocesse/${formData?.id}`)
        .then(async response => {
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
            window.location.href = "/diocese-manager"
            // if (callback) {
            // // await callback()
            // }
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });
};

</script>

<template>
    <div>
       <span @click="setOpen(true)"  class="cursor-pointer bg-red-500 text-white px-3 rounded-md py-2 hover:bg-red-600 ">
            <i class="uil uil-trash-alt"></i>
            </span>
        <AlertModal :isOpen="isOpen" :onClose="()=>setOpen(false)" :callback="()=>handleDelete(item)"/>
    </div>
</template>


<style lang="scss" scoped>

</style>
