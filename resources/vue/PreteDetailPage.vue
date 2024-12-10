
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
const { prete_id } = defineProps([ 'prete_id' ]);

const pretres = ref()

 function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
  }
class Pretre {
  constructor({nom, prenoms,diocese, matricule, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_etude_ecclesiastique, diplome_etude_profane, numero_telephone, adresse_electronique}) {
    this.nom = nom;
    this.prenoms = prenoms;
    this.matricule = matricule;
    this.diocese = diocese?.diocese; // Exemple: { diocese: 'Diocèse 1' }
    this.date_naissance = date_naissance;
    this.lieu_naissance = lieu_naissance;
    this.date_ordination_sacerdotale = date_ordination_sacerdotale;
    this.lieu_ordination_sacerdotale = lieu_ordination_sacerdotale;
    this.diplome_etude_ecclesiastique = diplome_etude_ecclesiastique;
    this.diplome_etude_profane = diplome_etude_profane;
    this.numero_telephone = numero_telephone;
    this.adresse_electronique = adresse_electronique;
  }
}

const hanldeliste = async (prete_id) => {
    axios.get(`/pretres/${prete_id}`)
    .then(response => {
        pretres.value = new Pretre(response?.data)
            // console.log('====================================');
            // console.log('====================================');
        })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
onMounted(() => {
    hanldeliste(prete_id)
});
</script>


<template>
    <div>
            <div class="w-full">
                <div class="flex items-center justify-center flex-col ">
                    <div class="w-[460px] min-h-[100px] bg-white rounded-md mb-3 p-2 flex flex-col items-center justify-center gap-3">
                        <div class="w-[120px] h-[120px]  bg-gray-100 rounded-[50%] flex items-center justify-center">
                            <i class="uil uil-user text-[50px]"></i>
                        </div>

                        <div class="flex flex-col items-center">
                            <h1 class="text-[20px] font-[600]">{{ pretres?.nom+ " "+ pretres?.prenoms }}</h1>
                            <h2 class="text-zinc-600 font-[600] text-[15px]">{{ pretres?.matricule }}</h2>
                        </div>
                    </div>
                    <div class="w-[460px] min-h-[100px] bg-white rounded-md mb-3">
                        <ul class="w-full">
                            <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Diocesse</span>
                                <span class="text-zinc-600">{{ pretres?.diocese }}</span>
                            </li>
                             <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Télephone</span>
                                <span class="text-zinc-600">{{ pretres?.numero_telephone }}</span>
                            </li>
                             <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Email</span>
                                <span class="text-zinc-600">{{ pretres?.adresse_electronique }}</span>
                            </li>
                             <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Date naissance</span>
                                <span class="text-zinc-600">{{formatDate(pretres?.date_naissance) }}</span>
                            </li>
                             <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Lieu naissance</span>
                                <span class="text-zinc-600">{{ pretres?.lieu_naissance }}</span>
                            </li>
                            <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Lieu ordination sacerdotale</span>
                                <span class="text-zinc-600">{{ pretres?.lieu_ordination_sacerdotale }}</span>
                            </li>
                            <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Diplome étude ecclesiastique</span>
                                <span class="text-zinc-600">{{ pretres?.diplome_etude_ecclesiastique }}</span>
                            </li>
                             <li class="flex justify-between items-center p-4 text-[14px] font-[500]">
                                <span>Diplome étude profane</span>
                                <span class="text-zinc-600">{{ pretres?.diplome_etude_profane }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
    </div>
</template>

<style lang="scss" scoped>

</style>
