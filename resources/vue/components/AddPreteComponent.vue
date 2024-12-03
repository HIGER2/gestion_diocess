
<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
const { dioceses, callback, dioceseId, detail } = defineProps([ 'dioceses', 'callback', 'dioceseId', 'detail' ]);


import {useToast} from 'vue-toast-notification';
import ButtonLoader from './ButtonLoader.vue';

const errrMessage = ref('')
const isLoading =ref(false);
const formData = reactive({
    nom: "",
    prenoms: "",
    matricule: "",
    date_naissance: "",
    dioceses_id:'' ,
    lieu_naissance: "",
    date_ordination_sacerdotale: "",
    lieu_ordination_sacerdotale: "",
    diplome_etude_ecclesiastique: "",
    diplome_etude_profane: "",
    numero_telephone: "",
    adresse_electronique: "",
});

const listeprete = inject('listeprete')

const handleSave = async (formData) => {
    isLoading.value = true
    if (dioceseId) {
        formData.dioceses_id=dioceseId
    }
    errrMessage.value = ""
    await axios.post('/pretres',formData)
        .then(async response => {
            if (listeprete) {
            await listeprete()
            }
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');


        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });

    isLoading.value = false
};

onMounted(() => {

    if (detail) {
        Object.assign(formData, detail)
        formData.dioceses_id = detail?.diocess?.id
    }
});
</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[460px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter un prêtres</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class=" my-2">
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
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Diplome etude ecclesiastique
                                </label>
                                <input
                                    v-model="formData.diplome_etude_ecclesiastique"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Diplome etude ecclesiastique"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Diplome etude profane
                                </label>
                                <input
                                    v-model="formData.diplome_etude_profane"
                                    type="text"
                                    required
                                    id="diocese"
                                    placeholder="Diplome etude profane"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>
                    </div>
                    <button class="mt-6 bg-primary w-full flex items-center justify-center text-white py-2 px-4 rounded-md ">
                        <ButtonLoader title="Enregistrer" :isLoading="isLoading" />
                    </button>
                </form>
        </div>
</template>


<style lang="scss" scoped>

</style>
