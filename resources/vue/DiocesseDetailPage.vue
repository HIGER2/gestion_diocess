
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddPreteComponent from './components/AddPreteComponent.vue';
import TableComponent from './components/prete/TableComponent.vue';
import DeleteDioceseComponent from './components/diocese/DeleteDioceseComponent.vue';
import EditDioceseComponent from './components/diocese/EditDioceseComponent.vue';
import ContentLoading from './components/ContentLoading.vue';
import { provide } from 'vue';

const { diocese_id } = defineProps([ 'diocese_id' ]);
const pretres = ref()
const diocese = ref()
const count = ref()
const isLoading=ref(false)
const isModalOpen = ref(false)

class Pretre {
  constructor({id,nom, prenoms, matricule, diocese, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_etude_ecclesiastique, diplome_etude_profane, numero_telephone, adresse_electronique}) {
    this.id = id;
    this.nom = nom;
    this.prenoms = prenoms;
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
  }
}


const openModal = (state) => {
    isModalOpen.value = state
};

const hanldeliste = async (diocese_id) => {
    isLoading.value =true
    await axios.get(`/diocesse/${diocese_id}`)
    .then(response => {

        pretres.value = response?.data?.diocese?.pretres.map(value => new Pretre(value))
        // delete response?.data?.diocese?.pretres
        diocese.value = response?.data?.diocese
        count.value = response?.data?.count_pretes
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
    isLoading.value =false
};

provide('listeprete',()=> hanldeliste(diocese_id))
onMounted(() => {
    hanldeliste(diocese_id)
});
</script>


<template>
    <div>
        <div class="w-full">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-[30px] font-[900] uppercase">{{diocese?.diocese}}</h1>
                <div class="flex items-center justify-center gap-2 " v-if="diocese">
                    <EditDioceseComponent :item="diocese"/>
                    <DeleteDioceseComponent :item="diocese"/>
                </div>
            </div>
            <!-- {{ diocese }} -->
                <ContentLoading v-if="isLoading"/>

            <div v-else class="flex gap-2 items-start mt-8">
                <!-- <div class="w-[300px] min-h-[20px] bg-white rounded-md p-3">
                    <div class="flex gap-3  border-b py-2">
                        <div class="w-[60px] h-[60px]">
                            <img class="w-full h-full object-cover rounded-md" :src="diocese?.url_image || 'https://cdn.pixabay.com/photo/2016/11/18/22/37/cathedral-1837206_1280.jpg'" alt="">
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col">
                                <h1>{{diocese?.diocese}}</h1>
                                <span class="text-zinc-500 text-[12px] font-[600]">{{ diocese?.abreviation }}</span>
                            </div>
                            <div class="text-zinc-500"><i class="uil uil-map-marker-alt"></i>
                            {{ diocese?.emplacement }}
                            </div>
                        </div>
                    </div>
                    <ul class="w-ful mt-3">
                        <li class="mb-2 flex gap-3 text-gray-600  text-[15px] leading-normal">
                            <span><i class="uil uil-phone"></i></span>
                            <span> +225 988 9089</span>
                        </li>
                        <li class=" flex gap-3 mb-2 text-gray-600  text-[15px] leading-normal">
                            <span><i class="uil uil-envelope"></i></span>
                            <span>exemple@mail.com</span>
                        </li>
                        <li class="flex gap-3 mb-2 text-gray-600  text-[15px] leading-normal">
                            <span>
                                <i class="uil uil-location-point"></i>
                            </span>
                            <span>daloa</span>
                        </li>
                    </ul>
                </div> -->
                <div class="w-full rounded-md bg-white min-h-[100px]">
                    <!-- {{ pretres }} -->
                    <div class="flex items-center justify-between">
                        <h6>Liste des prêtres du diocèse ({{ count }})</h6>
                        <button type="button" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter un prêtres</button>
                    </div>
                    <div class="overflow-x-auto mt-4 border rounded-md">
                            <TableComponent :liste_Prete="pretres"/>
                    </div>
                </div>
            </div>
        </div>
            <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <add-prete-component :callback="()=>hanldeliste(diocese_id)"  :dioceseId="diocese?.id"/>
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
