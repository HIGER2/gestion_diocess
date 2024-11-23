
<script setup>
import { onMounted, reactive, ref } from 'vue';
const { dioceses, callback ,dioceseId} = defineProps([ 'dioceses', 'callback','dioceseId' ]);
import {useToast} from 'vue-toast-notification';

const errrMessage =ref('')
const formData = reactive({
    nom: "Jean",
    prenoms: "Dupont",
    matricule: "123456",
    date_naissance: "1985-05-20",
    dioceses_id:'' ,
    lieu_naissance: "Abidjan",
    date_ordination_sacerdotale: "2010-06-15",
    lieu_ordination_sacerdotale: "Yamoussoukro",
    diplome_etude_ecclesiastique: "Théologie",
    diplome_etude_profane: "Informatique",
    numero_telephone: "0123456789",
    adresse_electronique: "jean.dupont@example.com",
});
const handleSave =async (formData) => {
    if (dioceseId) {
        formData.dioceses_id=dioceseId
    }
    errrMessage.value = ""
    await axios.post('/pretres',formData)
        .then(async response => {
            const $toast = useToast();

            $toast.success('Opération effectuée avec succès');
            await callback()

        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
    .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });
};
</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[460px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter un prêtres</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class=" my-2">
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
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    placeholder="Prenoms"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                                />
                            </div>
                        </div>
                        <div class="w-full  mb-2" v-if="dioceses">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Selectionner une diocèse
                            </label>
                            <select v-model="formData.dioceses_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
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
                                    id="diocese"
                                    placeholder="Téléphone"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    id="diocese"
                                    placeholder="Lieu de naissance"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    placeholder=" Date de Naissance"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    placeholder="Date ordination sacerdotale"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    placeholder="Lieu ordination sacerdotale"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
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
                                    placeholder="Diplome etude ecclesiastique"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Diplome etude profane
                                </label>
                                <input
                                    v-model="formData.diplome_etude_profane"
                                    type="text"
                                    id="diocese"
                                    placeholder="Diplome etude profane"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                                />
                            </div>
                        </div>
                    </div>
                    <button class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-md ">Enregistrer</button>
                </form>
        </div>
</template>


<style lang="scss" scoped>

</style>
