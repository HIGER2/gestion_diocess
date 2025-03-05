
<script setup>
import { inject, onMounted, ref } from 'vue';
import AlertModal from '../AlertModal.vue';
import {useToast} from 'vue-toast-notification';

const { item } = defineProps([ 'item' ]);

const isOpen = ref(false)
const errrMessage = ref("")
const setOpen = (state) =>{
    isOpen.value = state
}
const liste_link = inject('liste_link');
const handleDelete = async (formData) => {
    // let response = confirm('Voulez effctuer cette opération ?')
    //     if (!response) return
    errrMessage.value = ""
    await axios.delete(`register-links/delete/${formData?.id}`)
        .then(async response => {
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
            if (liste_link) {
                await liste_link()
            }
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
    });
};

</script>

<template>
    <div>
        <span @click="setOpen(true)" class="bg-gray-100 px-2 rounded-md py-2 hover:bg-zinc-200"><i class="uil uil-trash-alt"></i></span>
        <AlertModal :isOpen="isOpen" :onClose="()=>setOpen(false)" :callback="()=>handleDelete(item)"/>
    </div>
</template>


<style lang="scss" scoped>

</style>
