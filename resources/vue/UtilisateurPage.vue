
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddUtilisateurComponent from './components/AddUtilisateurComponent.vue';
import EditUtilisateurComponent from './components/utilisateur/EditUtilisateurComponent.vue';
import DeleteUtilisateurComponent from './components/utilisateur/DeleteUtilisateurComponent.vue';
import ContentLoading from './components/ContentLoading.vue';
const { dioceses } = defineProps([ 'dioceses' ]);
const user = ref()
const isModalOpen = ref(false)
const isLoading=ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

class Pretre {
  constructor({id,nom, prenoms, matricule, diocese, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_etude_ecclesiastique, diplome_etude_profane, numero_telephone, adresse_electronique}) {
    this.id = id;
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
    isLoading.value =true
    await axios.get('/user/all')
    .then(response => {
        if (response) {
            user.value = response?.data?.user
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
    isLoading.value =false
};



// const hanldelisteDiocese = async () => {
//     axios.get('/diocesse/all')
//     .then(response => {
//         if (response) {
//             dioceses.value = response?.data?.data
//         }
//     })
//     .catch(error => {
//         console.error('Error fetching user data:', error.response.data);
//     });
// };
onMounted(async() => {
  await  Promise.all([
     hanldeliste()
    //   hanldelisteDiocese()
  ])
});
</script>


<template>
    <div>
            <div class="w-full">
                <div class="flex justify-between items-center">
                    <h1 class="uppercase text-[16px] font-[800]">Liste des utilisateurs</h1>
                    <button type="button" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter un utilsateur</button>
                </div>
                <ContentLoading v-if="isLoading"/>
                <div v-else class="w-full ">
                    <!-- <div class="w-full max-w-sm mb-2">
                            <input
                                type="search"
                                id="diocese"
                                placeholder="Rechercher ici par nom ,numéro ,email"
                                class="block w-full rounded-lg mb-5 border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div> -->
                    <div class="rounded-md bg-white border min-h-[100px] mt-5">
                        <table class="min-w-full bg-white  rounded-lg">
                            <thead>
                                <tr class="bg-custom text-gray-600 capitalize text-[11px] leading-normal">
                                    <th class="p-3 text-left">Nom</th>
                                    <th class="p-3 text-left">Prénoms</th>
                                    <th class="p-3 text-left">Role</th>
                                    <th class="p-3 text-left">Diocese</th>
                                    <th class="p-3 text-left">Téléphone</th>
                                    <th class="p-3 text-left">Email</th>
                                    <th class="p-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-[12px] font-light ">
                                <tr v-for="(item,index) in user" :key="index" class="cursor-pointer hover:bg-gray-50">
                                    <td class="p-3 border-b">{{ item?.nom }}</td>
                                    <td class="p-3 border-b">{{ item?.prenoms }}</td>
                                    <td class="p-3 border-b">{{ item?.role }}</td>
                                    <td class="p-3 border-b">{{ item?.diocese?.diocese || 'N/A' }}</td>
                                    <td class="p-3 border-b">{{ item?.phone }}</td>
                                    <td class="p-3 border-b">{{ item?.email }}</td>
                                    <td class="p-3 border-b flex gap-2">
                                        <EditUtilisateurComponent :hanldeliste="hanldeliste" :item="item" :dioceses="dioceses"/>
                                        <DeleteUtilisateurComponent :item="item"/>
                                        <!-- <a :href="`/prete-manager/${item?.id}`" class="bg-gray-100 px-3 rounded-md py-2"><i class="uil uil-ellipsis-h"></i></a> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
            <Modal :isActive="isModalOpen" :onClose="openModal">
                <div class=" mb-2 p-5 max-h-full">
                    <AddUtilisateurComponent :callback="hanldeliste" :dioceses="dioceses"/>
                </div>
            </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
