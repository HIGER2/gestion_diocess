
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddPreteComponent from './components/AddPreteComponent.vue';
const pretes = ref()
const isModalOpen = ref(false)
const dioceses =ref()

const openModal = (state) => {
    isModalOpen.value = state
};

class Pretre {
  constructor({nom, prenoms, matricule, diocese, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_etude_ecclesiastique, diplome_etude_profane, numero_telephone, adresse_electronique}) {
    this.nom = nom;
    this.prenoms = prenoms;
    this.matricule = matricule;
    this.diocess = diocese?.diocese; // Exemple: { diocese: 'Diocèse 1' }
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

 function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
  }

const hanldeliste = async () => {
    axios.get('/pretres/all')
    .then(response => {
        if (response) {
            pretes.value = response?.data?.pretres.map(value =>new Pretre(value) )

            console.log('====================================');
            console.log(pretes.value );
            console.log('====================================');
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};



const hanldelisteDiocese = async () => {
    axios.get('/diocesse/all')
    .then(response => {
        if (response) {
            dioceses.value = response?.data?.data
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
onMounted(async() => {
  await  Promise.all([
     hanldeliste(),
    hanldelisteDiocese()])
});
</script>


<template>
    <div>
        <AppLayout>
            <div class="w-full">
                <div class="flex justify-between items-center">
                    <h1 class="uppercase text-[16px] font-[800]">Aperçus des pretes</h1>
                    <button type="button" @click="openModal(true)" class="bg-blue-950 text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter un prete</button>
                </div>
                <div class="w-full rounded-md bg-white min-h-[100px] mt-5 p-6">
                    <div class="w-full max-w-sm mb-2">
                            <input
                                type="search"
                                id="diocese"
                                placeholder="Rechercher ici par nom ,numéro ,email"
                                class="block w-full rounded-lg mb-5 border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white  rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 capitalize text-[11px] leading-normal">
                                    <th class="p-3 text-left">Nom</th>
                                    <th class="p-3 text-left">Prénoms</th>
                                    <th class="p-3 text-left">Matricule</th>
                                    <th class="p-3 text-left">Diocèse</th>
                                    <!-- <th class="p-3 text-left">Date de Naissance</th> -->
                                    <!-- <th class="p-3 text-left">Lieu de Naissance</th> -->
                                    <!-- <th class="p-3 text-left">Date Ordination Sacerdotale</th> -->
                                    <th class="p-3 text-left">Lieu Ordination</th>
                                    <!-- <th class="p-3 text-left">Diplôme Ecclésiastique</th> -->
                                    <!-- <th class="p-3 text-left">Diplôme Profane</th> -->
                                    <th class="p-3 text-left">Téléphone</th>
                                    <th class="p-3 text-left">Email</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-[12px] font-light ">
                                <tr v-for="(item,index) in pretes" :key="index" class="cursor-pointer hover:bg-slate-100">
                                    <td class="p-3 border-b">{{ item.nom }}</td>
                                    <td class="p-3 border-b">{{ item.prenoms }}</td>
                                    <td class="p-3 border-b">{{ item.matricule }}</td>
                                    <td class="p-3 border-b">{{ item.diocess }}</td>
                                    <!-- <td class="p-3 border-b">{{ formatDate(item.date_naissance) }}</td> -->
                                    <!-- <td class="p-3 border-b">{{ item.lieu_naissance }}</td> -->
                                    <!-- <td class="p-3 border-b">{{ formatDate(item.date_ordination_sacerdotale) }}</td> -->
                                    <td class="p-3 border-b">{{ item.lieu_ordination_sacerdotale }}</td>
                                    <!-- <td class="p-3 border-b">{{ item.diplome_etude_ecclesiastique }}</td> -->
                                    <!-- <td class="p-3 border-b">{{ item.diplome_etude_profane }}</td> -->
                                    <td class="p-3 border-b">{{ item.numero_telephone }}</td>
                                    <td class="p-3 border-b">{{ item.adresse_electronique }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
             <Modal :isActive="isModalOpen" :onClose="openModal">
               <div class=" mb-2 p-5 max-h-full">
                 <add-prete-component :dioceses="dioceses"/>
               </div>
            </Modal>
        </AppLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
