
<script setup>
import { onMounted, provide, ref, watch } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddPreteComponent from './components/AddPreteComponent.vue';
import TableComponent from './components/prete/TableComponent.vue';
import Empty from './components/Empty.vue';
import ContentLoading from './components/ContentLoading.vue';
const {dioceses}=defineProps(['dioceses'])
const pretes = ref([])
const isModalOpen = ref(false)
// const dioceses =ref()
const searchQuery =ref("")
const isLoading=ref(true)

const openModal = (state) => {
    isModalOpen.value = state
};

class Pretre {
  constructor({id,nom,diplome_academique, prenoms,status, matricule, diocese, date_naissance, lieu_naissance, date_ordination_sacerdotale, lieu_ordination_sacerdotale, diplome_ecclesiastique, numero_telephone, adresse_electronique}) {
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
    this.numero_telephone = numero_telephone;
    this.adresse_electronique = adresse_electronique;
    this.diplome_ecclesiastique = diplome_ecclesiastique;
    this.diplome_academique = diplome_academique;
  }
}

 function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
  }

const hanldeliste = async (url='/pretres/all?page=1') => {
    isLoading.value =true
   await  axios.get(url,
        {
            params: { search: searchQuery.value },
        }
    )
    .then(response => {
        if (response) {
            pretes.value = response?.data?.pretres?.data?.map(value =>new Pretre(value) )
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
    isLoading.value =false
};

watch(() => searchQuery.value, () => {

    hanldeliste();
})

provide('listeprete',hanldeliste)



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
onMounted(async () => {
        hanldeliste()

    // await Promise.all([
        hanldeliste()
    // hanldelisteDiocese()])
});
</script>


<template>
    <div>
            <div class="w-full">
                <div class="flex-row flex justify-between items-center w-full">
                    <h1 class="uppercase text-[16px] font-[800]">Liste des prêtres</h1>
                    <div class=" flex-row flex gap-3  items-center ">
                       <input
                                type="search"
                                id="diocese"
                                v-model="searchQuery"
                                placeholder="Rechercher ici par nom ,numéro ,email"
                                class="w-[300px] rounded-lg  border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none "
                            />
                        <button type="button" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer w-max">Ajouter un prêtres</button>
                    </div>
                </div>
                <!-- <div class="text-[12px] flex gap-2 item-center w-full bg-red ">
                    <span> Lien d' inscription</span>
                    <a class="underline cursor-pointer text-blue-500" href="http://demo.africarice.site/auth/inscription/ba5d380c-2a26-4dd0-9486-9ebfed4df817">
                        http://demo.africarice.site/auth/inscription/ba5d380c-2a26-4dd0-9486-9ebfed4df817
                    </a>
                </div> -->
                <ContentLoading v-if="isLoading"/>
                <div v-else class="w-full rounded-md bg-white border min-h-[100px] mt-5 p-6">
                    <div class="overflow-x-auto">
                        <template v-if="pretes?.length > 0">
                            <table-component :liste_Prete="pretes" :dioceses="JSON.parse(dioceses)"/>
                        </template>
                        <Empty v-else/>
                    </div>
                </div>
            </div>
             <Modal :isActive="isModalOpen" :onClose="openModal">
               <div class=" mb-2 p-5 max-h-full">
                 <add-prete-component :callback="hanldeliste" :dioceses="JSON.parse(dioceses)"/>
               </div>
            </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
