
<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
const { diocese, callback, dioceseId, detail } = defineProps([ 'diocese', 'callback', 'dioceseId', 'detail' ]);


import {useToast} from 'vue-toast-notification';
import ButtonLoader from './components/ButtonLoader.vue';
const isLoading =ref(false)
const errrMessage =ref('')
const formData = reactive({
    nom: "",
    prenoms: "",
    matricule: "",
    date_naissance: "",
    dioceses_id:diocese?.id ,
    lieu_naissance: "",
    status: "inactive",
    date_ordination_sacerdotale: "",
    lieu_ordination_sacerdotale: "",
    diplome_ecclesiastique: [],
    diplome_academique: [],
    numero_telephone: "",
    adresse_electronique: "",
});

const handleSave = async (formData) => {

    const response = confirm('Êtes-vous sûr de vouloir soumettre ?')
    if (!response)return

    isLoading.value =true
    errrMessage.value = ""
    await axios.post('/auth/inscription',formData)
        .then(async response => {
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
    })
    .catch(error => {
        errrMessage.value = error.response.data?.message.split('.')[ 0 ]
        window.scrollTo(0, 0);
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });
    isLoading.value =false
};

onMounted(() => {
});



const AddDiplomeEcclesiastique = () => {
    formData.diplome_ecclesiastique.push({intitule_diplome:""})
}

const DeleteiplomeEcclesiastique = (index) => {
   if (index >= 0 && index < formData.diplome_ecclesiastique.length) {
        formData.diplome_ecclesiastique.splice(index, 1);
    }
}


const AddDiplomeAcademique = () => {
    formData.diplome_academique.push({intitule_diplome:""})
}

const DeleteiplomeAcademique = (index) => {
    if (index >= 0 && index < formData.diplome_academique.length) {
        formData.diplome_academique.splice(index, 1);
    }
};
</script>



<template>
    <div class="w-full min-h-screen bg-primary p-2 cursor-pointer flex flex-row items-center justify-center">
        <div class="md:w-[420px] bg-white min-h-[100px] rounded-lg">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full" @click.stop>
                    <h2 class="text-xl font-semibold mb-5">Formulaire d'enregistrement</h2>
                    <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                    </div>
                    <form action="" @submit.prevent="handleSave(formData)">
                        <div class=" my-2 w-full">
                        <!-- {{ detail }} -->
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Nom
                                </label>
                                <input
                                    v-model="formData.nom"
                                    type="text"
                                    id="diocese"
                                    placeholder="Nom"
                                    required
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Prenoms
                                </label>
                                <input
                                    type="text"
                                    v-model="formData.prenoms"
                                    id="diocese"
                                    required
                                    placeholder="Prenoms"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <div class="w-full  mb-2" v-if="dioceses">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Selectionner une diocèse
                            </label>

                            <select required v-model="formData.dioceses_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                                <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                                <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input
                                v-model="formData.numero_telephone"
                                    type="text"
                                    required
                                    id="diocese"
                                    placeholder="Téléphone"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Email
                                </label>
                                <input
                                    v-model="formData.adresse_electronique"
                                    type="text"
                                    id="diocese"
                                    placeholder="Email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Lieu de naissance
                                </label>
                                <input
                                    v-model="formData.lieu_naissance"
                                    type="text"
                                    required
                                    id="diocese"
                                    placeholder="Lieu de naissance"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Date de Naissance
                                </label>
                                <input
                                    type="date"
                                    v-model="formData.date_naissance"
                                    id="diocese"
                                    required
                                    placeholder=" Date de Naissance"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Date ordination sacerdotale
                                </label>
                                <input
                                    v-model="formData.date_ordination_sacerdotale"
                                    type="date"
                                    id="diocese"
                                    required
                                    placeholder="Date ordination sacerdotale"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Lieu ordination sacerdotale
                                </label>
                                <input
                                    v-model="formData.lieu_ordination_sacerdotale"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Lieu ordination sacerdotale"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <div  v-if="formData.diplome_ecclesiastique.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full  mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Diplome etude ecclesiastique
                                </label>
                                <div class="flex mb-2 items-center justify-between gap-2" v-for="(item, index) in formData.diplome_ecclesiastique" :key="index">
                                    <input
                                    v-model="item.intitule_diplome"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Diplome etude ecclesiastique"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                                <span class="p-2" @click="DeleteiplomeEcclesiastique(index)"><i class="uil uil-times"></i></span>
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="AddDiplomeEcclesiastique" class=" block text-[13px] shadow border mx-auto my-3 p-2 rounded-md">Ajouter un diplome ecclesiastique</button>

                        <div v-if="formData.diplome_academique.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Diplome etude profane
                                </label>
                                <div class="w-full flex mb-2 items-center justify-between gap-2" v-for="(item, index) in formData.diplome_academique" :key="index">
                                    <input
                                    v-model="item.intitule_diplome"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Diplome etude ecclesiastique"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                                <span class="p-2" @click="DeleteiplomeAcademique(index)"><i class="uil uil-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="AddDiplomeAcademique" class=" block text-[13px] shadow border mx-auto my-3 p-2 rounded-md">Ajouter un diplome profane</button>
                    </div>
                        <button class="mt-6 bg-primary w-full flex items-center justify-center text-white py-2 px-4 rounded-md ">
                            <ButtonLoader title="Enregistrer" :isLoading="isLoading" />
                        </button>
                    </form>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>
