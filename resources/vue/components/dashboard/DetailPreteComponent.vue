
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

    console.log(formData);

        let response = confirm('Voulez effctuer cette opération ?')
        if (!response) return
        errrMessage.value = ""
        await axios.post('/pretres', {
            ...formData,
            dioceses_id:formData?.diocese?.id,
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

    console.log(item);

    details.value = [
        {
            children: [ { label: 'Diocèse', value: item?.diocese?.diocese }, { label: 'Téléphone', value: item?.numero_telephone }, ]
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
                { label: 'Spécialité', value: item?.specialite },
            ]
        },
        {
            children: [
                { label: "Lieu d'affectetion", value: item?.lieu_affectation?.nom },
                { label: "Date d'affectetion", value: item?.lieu_affectation?.date }
            ]
        },

        {children:[  { label: 'Qualité Diocésain ou communautaire', value: item?.communautaire },]}
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
                    <!-- {{ details }} -->
                    <div class="w-[40%] min-h-[100px]  bg-white rounded-md mb-3 p-2 flex flex-col items-center justify-start gap-3">
                        <div class="w-[100px] h-[100px] aspect-[1/1] overflow-hidden  bg-primary rounded-[50%] flex items-center justify-center">
                            <!-- {{ item?.profile_path }} -->
                            <img v-if="item?.profile_path" :src="'/storage/'+item?.profile_path" class="     w-full h-full" alt="">
                            <i v-else class="uil uil-user text-[50px] text-white"></i>
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
                                            {{ item?.date }}
                                            :
                                            {{ item?.intitule_diplome }}
                                        </span>
                                    </template>
                                </li>
                                <li class="flex flex-col  p-4 text-[14px] font-[500]">
                                    <span>Diplôme étude profane</span>
                                    <!-- {{ item }} -->
                                    <template v-if="item?.diplome_academique">
                                        <span v-for="(item, index) in item?.diplome_academique" :key="index" class="text-zinc-600 text-[12px] font-[500]">
                                            {{ item?.date }} :
                                            {{ item?.intitule_diplome }}
                                        </span>
                                    </template>
                            </li>
                            </div>
                        </ul>
                        <ul class="w-full">
                            <div class="flex justify-between">
                                <li class="flex flex-col  p-4 text-[14px] font-[500]">
                                    <span>Parcours pastoral</span>
                                    <!-- {{ item }} -->
                                    <template v-if="item?.diplome_ecclesiastique">
                                        <li  v-for="(item, index) in item?.parcours" :key="index"  class=" border-b  gap-3 items-center py-1 text-[14px] font-[400]">
                                        <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Nom de la paroise :</span>
                                            <span class="text-zinc-600"> {{ item?.nom }}</span>
                                        </div>
                                        <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Institut diocésaine :</span>
                                            <span class="text-zinc-600"> {{ item?.institut }}</span>
                                        </div>
                                         <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Fonction :</span>
                                            <span class="text-zinc-600"> {{ item?.fonction }}</span>
                                        </div>
                                         <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Diocèse :</span>
                                            <span class="text-zinc-600"> {{ item?.diocese?.diocese }}</span>
                                        </div>
                                         <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Date début :</span>
                                            <span class="text-zinc-600"> {{ item?.date }}</span>
                                        </div>
                                         <div class="flex mb-1 items-center gap-2 text-sm">
                                            <span class="text-zinc-600">Date fin :</span>
                                            <span class="text-zinc-600"> {{ item?.date_fin }}</span>
                                        </div>
                                    </li>
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
