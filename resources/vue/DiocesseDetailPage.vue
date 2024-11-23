
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddPreteComponent from './components/AddPreteComponent.vue';

const { diocese_id } = defineProps([ 'diocese_id' ]);
const pretres = ref()
const diocese = ref()
const isModalOpen = ref(false)

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


const openModal = (state) => {
    isModalOpen.value = state
};

const hanldeliste = async (diocese_id) => {
    axios.get(`/diocesse/${diocese_id}`)
    .then(response => {

        pretres.value = response?.data?.diocese?.pretres.map(value => new Pretre(value))
        delete response?.data?.diocese?.pretres
        diocese.value = response?.data?.diocese
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
onMounted(() => {
    hanldeliste(diocese_id)
});
</script>


<template>
    <div>
        <AppLayout>
            <div class="w-full">
                <h1 class="text-[30px] font-[900] uppercase">{{diocese?.diocese}}</h1>
                <!-- {{ diocese }} -->
                <div class="flex gap-2 items-start mt-5">
                    <div class="w-[400px] min-h-[20px] bg-white rounded-md p-3">
                        <div class="flex gap-3  border-b py-2">
                            <div class="w-[100px] h-[100px]">
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
                    </div>
                    <div class="w-full rounded-md bg-white min-h-[100px] p-3">
                        <div class="flex items-center justify-between">
                            <h6>Lites des prêtres de la diocèse</h6>
                            <button type="button" @click="openModal(true)" class="bg-blue-950 text-white p-2 rounded-md text-[14px] cursor-pointer">Ajouter un prêtres</button>

                        </div>
                        <div class="overflow-x-auto mt-4">
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
                                        <th class="p-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-[12px] font-light ">
                                    <tr v-for="(item,index) in pretres" :key="index" class="cursor-pointer hover:bg-slate-100">
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
                                        <td class="p-3 border-b">
                                            <a :href="`/prete-manager/${item?.id}`" class="bg-gray-100 px-3 rounded-md py-2"><i class="uil uil-ellipsis-h"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <Modal :isActive="isModalOpen" :onClose="openModal">
               <div class=" mb-2 p-5 max-h-full">
                 <add-prete-component :callback="()=>hanldeliste(diocese_id)"  :dioceseId="diocese?.id"/>
               </div>
            </Modal>
        </AppLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
