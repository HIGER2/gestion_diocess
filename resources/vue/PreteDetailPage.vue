
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddParcourtComponent from './components/prete/AddParcourtComponent.vue';

const { prete } = defineProps([ 'prete' ]);

const isModalOpen = ref(false)
const isModal = ref(false)

const openModal = (state) => {
    isModalOpen.value = state
};

const openIsModal = (state) => {
    isModal.value = state
};


 function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
  }

onMounted(() => {
});
</script>


<template>
    <div>
        <div class="w-full">
            <div class="w-[500px] m-auto">
                <div class="flex  w-full m-auto items-center mb-5 justify-between">
                <h1 class="uppercase text-[16px] font-[800]">Information prête</h1>
                <button type="button" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer">
                    Ajouter un Parcours
                </button>
                </div>
                <di class="flex gap-3 w-full m-auto ">
                    <div class="flex w-full items-center justify-center m-auto flex-col">
                        <div class="bg-secondary w-full min-h-[100px]  rounded-md mb-3 p-2 flex flex-col items-center justify-center gap-3">
                            <div class="w-[100px] h-[100px] aspect-[1/1] overflow-hidden  bg-primary rounded-[50%] flex items-center justify-center">
                                <img v-if="prete?.profile_path" :src="'/storage/'+prete?.profile_path" class="     w-full h-full" alt="">
                                <i v-else class="uil uil-user text-[50px] text-white"></i>
                            </div>
                            <div class="flex flex-col items-center">
                                <h1 class="text-[20px] font-[600]">{{ prete?.nom+ " "+ prete?.prenoms }}</h1>
                                <h2 class="text-zinc-600 font-[600] text-[15px]">{{ prete?.matricule }}</h2>
                            </div>
                            <button type="button" @click="openIsModal(true)" class="shadow-sm flex mb-2 px-6 p-1 rounded-md border mx-auto">
                                Parcours pastoral
                            </button>
                        </div>
                        <div class="w-full min-h-[100px] bg-secondary rounded-md mb-3">
                            <ul class="w-full">
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Diocesse</span>
                                    <span class="text-zinc-600">{{ prete?.diocese?.diocese }}</span>
                                </li>
                                    <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Télephone</span>
                                    <span class="text-zinc-600">{{ prete?.numero_telephone }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Email</span>
                                    <span class="text-zinc-600">{{ prete?.adresse_electronique }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Spécialité</span>
                                    <span class="text-zinc-600">{{ prete?.specialite }}</span>
                                </li>
                                 <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Qualité Diocésain</span>
                                    <span class="text-zinc-600">{{ prete?.communautaire }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Date naissance</span>
                                    <span class="text-zinc-600">{{formatDate(prete?.date_naissance) }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Lieu naissance</span>
                                    <span class="text-zinc-600">{{ prete?.lieu_naissance }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Lieu ordination sacerdotale</span>
                                    <span class="text-zinc-600">{{ prete?.lieu_ordination_sacerdotale }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Lieu d'affectation</span>
                                    <span class="text-zinc-600">{{ prete?.lieu_affectation?.nom }}</span>
                                </li>
                                 <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Fonction</span>
                                    <span class="text-zinc-600">{{ prete?.lieu_affectation?.fonction }}</span>
                                </li>
                                <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                    <span>Date d'affectation</span>
                                    <span class="text-zinc-600">{{ prete?.lieu_affectation?.date +' - '+ prete?.lieu_affectation?.date_fin }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="w-full min-h-[100px] bg-secondary rounded-md mb-3 p-4">
                            <div class="w-full mb-3">
                                <h4 class="font-[500]">Diplome étude ecclesiastique</h4>
                                <ul class="w-full">
                                    <template v-if="prete?.diplome_ecclesiastique">
                                    <li  v-for="(item, index) in prete?.diplome_ecclesiastique" :key="index"  class="flex  gap-3 items-center py-1 text-[14px] font-[400]">
                                        <span class="text-zinc-600">{{ item?.date}}</span>
                                        <span class="text-zinc-600"> {{ item?.intitule_diplome }}</span>
                                    </li>
                                    </template>
                                </ul>
                            </div>
                            <div class="w-full">
                                <h4 class="font-[500]">Diplome étude academique</h4>
                                <ul class="w-full mt-2">
                                    <template v-if="prete?.diplome_academique">
                                    <li  v-for="(item, index) in prete?.diplome_academique" :key="index"  class="flex  gap-3 items-center py-1 text-[14px] font-[500]">
                                        <span class="text-zinc-600">{{ item?.date }}</span>
                                        <span class="text-zinc-600"> {{ item?.intitule_diplome }}</span>
                                    </li>
                                    </template>

                                </ul>
                            </div>
                        </div>
                    </div>
                </di>
            </div>
        </div>
        <Modal :isActive="isModal" :onClose="openIsModal">
            <div class="w-[400px] bg-white  rounded-md p-5 relative">
                <div class="flex w-full justify-between items-center">
                    <h1>Parcourt</h1>
                    <button type="button"  @click="openIsModal(false)" class=" top-[5px]  bg-gray-200 text-black w-[25px] rounded-[50%] h-[25px] right-3"><i class="uil uil-times"></i></button>
                </div>

                <div class=" w-full  my max-h-[400px] overflow-auto mt-6">
                    <ul class="w-full">
                        <li class="w-full py-4 border-b text-[14px] font-[500]" v-for="(item, index) in prete?.parcourt" :key="index">
                            <div class="flex items-center gap-2 text-sm">
                                <span>{{formatDate(item?.date_debut ) }}</span>
                                <span>-</span>
                                <span>{{ formatDate(item?.date_fin) }}</span>
                            </div>
                            <p class="w-full text-sm text-zinc-600 mt-2 px-2">{{ item?.description }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </Modal>
         <Modal :isActive="isModalOpen" :onClose="openModal">
            <AddParcourtComponent :onClose="openModal" :id="prete?.id" :callback="hanldeliste"/>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
