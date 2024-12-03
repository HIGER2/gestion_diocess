
<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
const { dioceses, callback, dioceseId, detail } = defineProps([ 'dioceses', 'callback', 'dioceseId', 'detail' ]);


import {useToast} from 'vue-toast-notification';
import ButtonLoader from './components/ButtonLoader.vue';
const isLoading =ref(false)
const errrMessage =ref('')
const formData = reactive({
    nom: "",
    prenoms: "",
    matricule: "",
    date_naissance: "",
    status: "inactive",
    dioceses_id:'' ,
    lieu_naissance: "",
    date_ordination_sacerdotale: "",
    lieu_ordination_sacerdotale: "",
    diplome_etude_ecclesiastique: "",
    diplome_etude_profane: "",
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
                        <div class=" my-2">
                            <!-- {{ detail }} -->
                            <div class="flex flex-col md:flex-row items-end justify-between gap-2 mb-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="name" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Nom
                                    </label>
                                    <input
                                        v-model="formData.nom"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Nom"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[10px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Prenoms
                                    </label>
                                    <input
                                        type="text"
                                        v-model="formData.prenoms"
                                        required
                                        id="diocese"
                                        placeholder="Prenoms"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[10px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                            </div>
                            <div class="w-full  mb-3" >
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                    Selectionner votre diocèse
                                </label>
                                <select required v-model="formData.dioceses_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[10px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                                    <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                                    <option :value="item?.id" v-for="(item, index) in JSON.parse(dioceses)" :key="index">{{ item?.diocese }}</option>
                                </select>
                            </div>

                            <div class="flex items-end justify-between gap-2 mb-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Téléphone
                                    </label>
                                    <input
                                    v-model="formData.numero_telephone"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Téléphone"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                    Email
                                    </label>
                                    <input
                                        v-model="formData.adresse_electronique"
                                        type="text"
                                        id="diocese"
                                        placeholder="Email"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                            </div>

                            <div class="flex items-end justify-between gap-2 mb-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Lieu de naissance
                                    </label>
                                    <input
                                        v-model="formData.lieu_naissance"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Lieu de naissance"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Date de Naissance
                                    </label>
                                    <input
                                        type="date"
                                        v-model="formData.date_naissance"
                                        id="diocese"
                                        required
                                        placeholder=" Date de Naissance"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                            </div>

                            <div class="flex items-end justify-between gap-2 mb-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Date ordination sacerdotale
                                    </label>
                                    <input
                                        v-model="formData.date_ordination_sacerdotale"
                                        type="date"
                                        id="diocese"
                                        required
                                        placeholder="Date ordination sacerdotale"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Lieu ordination sacerdotale
                                    </label>
                                    <input
                                        v-model="formData.lieu_ordination_sacerdotale"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Lieu ordination sacerdotale"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                            </div>
                            <div class="flex items-end justify-between gap-2 mb-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Diplome étude ecclesiastique
                                    </label>
                                    <input
                                        v-model="formData.diplome_etude_ecclesiastique"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Diplome etude ecclesiastique"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Diplome étude profane
                                    </label>
                                    <input
                                        v-model="formData.diplome_etude_profane"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Diplome etude profane"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[11px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                            </div>
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
