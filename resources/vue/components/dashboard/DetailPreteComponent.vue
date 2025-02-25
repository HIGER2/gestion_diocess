
<script setup>
import Modal from '../Modal.vue';
import { inject, onMounted, ref } from 'vue';
const { item ,dioceses} = defineProps([ 'item','dioceses' ]);
import {useToast} from 'vue-toast-notification';

const isModalOpen = ref(false)
const details = ref()
const errrMessage=ref('')
 function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
 }

const analytic=inject('analytic')
const vaidate = async (formData) => {

        let response = confirm('Voulez effctuer cette opération ?')
        if (!response) return
        errrMessage.value = ""
        await axios.post('/pretres', {
            ...formData,
            dioceses_id:formData?.diocess?.id,
            status: 'active'
        })
            .then(async response => {

            if (analytic) await analytic()

            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    })
        ;
};


const handleDelete = async (formData) => {
    let response = confirm('Voulez effctuer cette opération ?')
    if (!response) return;
    errrMessage.value = ""
    await axios.delete(`/pretres/${formData?.id}`)
        .then(async response => {
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
           if (analytic) {
            await analytic()
            }
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });

    openModal()
};


const openModal = (state) => {
    isModalOpen.value = state
};

const setData = () => {

};

onMounted(() => {
    details.value = [
        {
            children: [ { label: 'Diocèse', value: item?.diocess?.diocese }, { label: 'Téléphone', value: item?.numero_telephone }, ]
        },

        {
            children: [
                { label: 'Email', value: item?.adresse_electronique },
                { label: 'Date naissance', value: formatDate(item?.date_naissance) } ]
        },
        {
            children: [
                { label: 'Lieu naissance', value: item?.lieu_naissance },
                { label: 'Date ordination sacerdotale', value: formatDate(item?.date_ordination_sacerdotale) }
            ]
        },
        {
            children: [ { label: 'Lieu ordination sacerdotale', value: item?.lieu_ordination_sacerdotale },
                // { label: 'Diplôme étude ecclésiastique', value: item?.diplome_ecclesiastique },
            ]
        },

        // {children:[  { label: 'Diplôme étude profane', value: item?.diplome_academique },]}
];
});
</script>


<template>
    <div>
        <span  class="bg-gray-100 px-2 hover:bg-zinc-200 rounded-md py-2"  @click="openModal(true)">
            <i class="uil uil-ellipsis-h"></i>
        </span>

        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class="w-[700px] bg-white  rounded-md">
                <!-- {{ item }} -->
                <div class=" w-full flex  justify-center  p-4">
                    <div class="w-[40%] min-h-[100px]  bg-white rounded-md mb-3 p-2 flex flex-col items-center justify-start gap-3">
                        <div class="w-[90px] h-[90px]  bg-primary rounded-[50%] flex items-center justify-center">
                            <i class="uil uil-user text-[50px] text-white"></i>
                        </div>
                        <div class="flex flex-col items-center text-center">
                            <h1 class="text-[13px] font-[600]">{{ item?.nom+ " "+ item?.prenoms }}</h1>
                            <h2 class="text-zinc-600 font-[500] text-[13px]">{{ item?.matricule }}</h2>
                        </div>
                    </div>
                    <div class="w-full min-h-[100px] bg-white rounded-md mb-3">
                        <ul class="w-full">
                            <div v-for="(items, index) in details" :key="index" class="flex justify-between ">
                                <li v-for="(item, index) in items?.children" :key="index" class="flex flex-col w-[50%]  p-2 text-[12px] font-[500]">
                                    <span class="text-zinc-600">{{ item?.label }}</span>
                                    <span class="text-zinc-900">{{ item?.value }}</span>
                                </li>
                            </div>
                        </ul>
                         <ul class="w-full">
                            <div class="flex justify-between">
                                <li class="flex flex-col  p-4 text-[14px] font-[500]">
                                    <span>Diplôme étude ecclésiastique</span>
                                    <!-- {{ item }} -->
                                    <template v-if="item?.diplome_ecclesiastique">
                                        <span v-for="(item, index) in item?.diplome_ecclesiastique" :key="index" class="text-zinc-600 text-[12px] font-[500]">
                                            {{ item?.intitule_diplome }}
                                        </span>
                                    </template>
                                </li>
                                <li class="flex flex-col  p-4 text-[14px] font-[500]">
                                    <span>Diplôme étude profane</span>
                                    <!-- {{ item }} -->
                                    <template v-if="item?.diplome_academique">
                                        <span v-for="(item, index) in item?.diplome_academique" :key="index" class="text-zinc-600 text-[12px] font-[500]">
                                            {{ item?.intitule_diplome }}
                                        </span>
                                    </template>
                            </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-end items-center text-sm p-3 gap-2">
                    <button @click="handleDelete(item)"  class="max-w bg-zinc-200 p-2 px-5 rounded-md">Supprimer</button>
                    <button @click="vaidate(item)"  class="max-w p-2 px-5 rounded-md bg-primary text-white">Valider</button>
                </div>
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
