
<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
const { diocese_id } = defineProps([ 'diocese_id' ]);
const pretres = ref()
const diocese =ref()
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

const hanldeliste = async (diocese_id) => {
    axios.get(`/diocesse/${diocese_id}`)
    .then(response => {
        
        pretres.value = response?.data?.diocese?.pretres.map(value => new Pretre(value))
        delete response?.data?.diocese?.pretres
        diocese.value = response?.data?.diocese

        console.log('====================================');
        console.log(diocese.value);
        console.log('====================================');
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
            
                <h6>Lites des prêtres de la diocèse</h6>
            <div class="w-full rounded-md bg-white min-h-[100px] mt-5">
                <div class="overflow-x-auto p-3 ">
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
                            </tr>
                        </tbody>
                    </table>
                    </div>
            </div>
            </div>
        </AppLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
