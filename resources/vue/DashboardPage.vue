
<script setup>

import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddDioceseComponent from './components/AddDioceseComponent.vue';
import TableComponent from './components/dashboard/TableComponent.vue';

import { computed, inject, onMounted, provide, ref } from 'vue';
import Empty from './components/Empty.vue';
import ContentLoading from './components/ContentLoading.vue';
const isModalOpen = ref(false)
const isLoading = ref(false)
const analytic_data = ref("")
const pretes = ref([])

const user = computed(()=>inject('user'))
class Pretre {
  constructor({id,nom, prenoms,status,diplome_ecclesiastique,diplome_academique, matricule, diocese, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_etude_ecclesiastique, diplome_etude_profane, numero_telephone, adresse_electronique}) {
    this.id = id;
    this.nom = nom;
    this.prenoms = prenoms;
    this.status = status;
    this.matricule = matricule;
    this.diocess = diocese; // Exemple: { diocese: 'Diocèse 1' }
    this.date_naissance = date_naissance;
    this.lieu_naissance = lieu_naissance;
    this.date_ordination_sacerdotale = date_ordination_sacerdotale;
    this.lieu_ordination_sacerdotale = lieu_ordination_sacerdotale;
    this.diplome_etude_ecclesiastique = diplome_etude_ecclesiastique;
    this.diplome_etude_profane = diplome_etude_profane;
    this.numero_telephone = numero_telephone;
    this.adresse_electronique = adresse_electronique;
    this.diplome_academique = diplome_academique;
    this.diplome_ecclesiastique = diplome_ecclesiastique;
  }
}
const analytic = async () => {
    isLoading.value = true;
   await  axios.get('/analytic')
    .then(response => {

        analytic_data.value = response?.data?.data
        pretes.value = analytic_data.value?.prete_inactive
        // .map(value =>new Pretre(value))
    })
    .catch(error => {
    });

    isLoading.value = false;
};

provide('analytic', analytic)

onMounted(() => {
    // user.value = inject('user')
    analytic()
});
</script>

<template>
    <div>
        <!-- <app-layout> -->
            <!-- {{ analytic_data?.prete_inactive }} -->
            <div class="w-full items-center justify-center flex">
                <div class="w-full">
                    <h1 v-if="user?.role  != 'admin'" class="uppercase text-[16px] font-[800]  mb-2 ">Tableau de bord</h1>
                    <div  class="p-4 flex-wrap  flex items-center justify-center bg-custom rounded-md my-auto ">
                        <div v-if="user?.role  != 'admin'" style="width: calc(100% / 5 - 10px);" href="/diocese-manager" class=" shadow-slate-900 h-auto flex flex-row items-center  gap-3 p-2 cursor-pointer min-h-[115px] justify-center rounded-md m-[5px]">
                            <!-- <div class=" w-[70px] h-[70px] bg-yellow-100 items-center justify-center flex rounded-[50%]">
                                <i class="fi fi-bs-church text-[20px] text-yellow-600"></i>
                            </div> -->
                            <div class="flex flex-col items-center justify-center">
                                <h2 class="text-[12px]  font-[600]">Total des diocèses</h2>
                                <h1 class="text-[20px] font-[600]">{{ analytic_data?.diocese_count }}</h1>
                            </div>
                        </div>
                        <div style="width: calc(100% / 5 - 10px);" href="/prete-manager" class=" h-auto flex flex-row items-center  gap-3 p-1 cursor-pointer min-h-[115px] justify-center rounded-md m-[5px]">
                            <!-- <div class="w-[70px] h-[70px] bg-green-100 rounded-[50%] items-center justify-center flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-green-600"></i>
                            </div> -->
                            <div class="flex flex-col items-center justify-center">
                                <h2 class="text-[12px]  font-[600]">Total prêtres</h2>
                                <h1 class="text-[20px] font-[600]">{{ analytic_data?.prete_count }}</h1>
                            </div>
                        </div>
                         <div style="width: calc(100% / 5 - 10px);" href="/prete-manager" class=" h-auto flex flex-row items-center  gap-3 p-1 cursor-pointer min-h-[115px] justify-center rounded-md m-[5px]">
                            <!-- <div class="w-[70px] h-[70px] bg-green-100 rounded-[50%] items-center justify-center flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-green-600"></i>
                            </div> -->
                            <div class="flex flex-col items-center justify-center">
                                <h2 class="text-[12px]  font-[600]">Retraite dans 5 ans</h2>
                                <h1 class="text-[20px] font-[600]">{{ analytic_data?.prete_count_retraite }}</h1>
                            </div>
                        </div>
                        <div style="width: calc(100% / 5 - 10px);" href="/utilisateur-manager" class=" h-auto flex flex-row items-center  gap-3 p-1 cursor-pointer min-h-[115px] justify-center rounded-md m-[5px]">
                            <!-- <div class="w-[70px] h-[70px] bg-blue-100 rounded-[50%] items-center justify-center  flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-blue-600"></i>
                            </div> -->
                            <div class="flex flex-col items-center justify-center">
                                <h2 class="text-[12px]  font-[600]">Total utilisateurs</h2>
                                <h1 class="text-[20px] font-[600]">{{ analytic_data?.user_count }}</h1>
                            </div>
                        </div>

                        <div style="width: calc(100% / 5 - 10px);" href="/utilisateur-manager" class=" h-auto flex flex-row items-center  gap-3 p-1 cursor-pointer min-h-[115px] justify-center rounded-md m-[5px]">
                            <!-- <div class="w-[70px] h-[70px] bg-blue-100 rounded-[50%] items-center justify-center  flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-blue-600"></i>
                            </div> -->
                            <div class="flex flex-col items-center justify-center">
                                <h2 class="text-[12px]  font-[600]">En attentes d'approbations</h2>
                                <h1 class="text-[20px] font-[600]">{{ analytic_data?.prete_count_inactive }}</h1>
                            </div>
                        </div>
                    </div>


                    <h1 class="uppercase text-[16px] font-[800] mb-3 mt-8">En attentes d'approbations</h1>

                    <ContentLoading v-if="isLoading"/>
                    <div v-else class="">
                        <div class="overflow-x-auto mt-4 border rounded-md w-full">
                            <template v-if="pretes?.length> 0">
                                <table-component :liste_Prete="pretes" :dioceses="dioceses"/>
                            </template>

                            <Empty v-else/>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </app-layout> -->
    </div>
</template>

<!--
<style lang="scss" scoped>

</style> -->
