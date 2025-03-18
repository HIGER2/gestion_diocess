
<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
const { diocese, callback, dioceseId, detail } = defineProps([ 'diocese', 'callback', 'dioceseId', 'detail' ]);


import {useToast} from 'vue-toast-notification';
import ButtonLoader from '@/components/ButtonLoader.vue';

const previewUrl = ref(null);
const fileInput = ref(null);

const errrMessage = ref('')
const isLoading =ref(false);
const formData = reactive({
    selectedFile:null,
    nom: "",
    prenoms: "",
    matricule: "",
    date_naissance: "",
    dioceses_id:'' ,
    lieu_naissance: "",
    date_ordination_sacerdotale: "",
    lieu_ordination_sacerdotale: "",
    diplome_ecclesiastique: [],
    diplome_academique: [],
    numero_telephone: "",
    adresse_electronique: "",
    specialite:'',
    communautaire: '',
    lieu_affectation: {
        nom: '',
        adresse:'',
        date:''
    }
});

const listeprete = inject('listeprete')

const AddDiplomeEcclesiastique = () => {
    formData.diplome_ecclesiastique.push({intitule_diplome:"",date:''})
}

const DeleteiplomeEcclesiastique = (index) => {
   if (index >= 0 && index < formData.diplome_ecclesiastique.length) {
        formData.diplome_ecclesiastique.splice(index, 1);
    }
}


const AddDiplomeAcademique = () => {
    formData.diplome_academique.push({intitule_diplome:"",date:''})
}

const DeleteiplomeAcademique = (index) => {
   if (index >= 0 && index < formData.diplome_academique.length) {
        formData.diplome_academique.splice(index, 1);
    }
}

const handleSave = async (data) => {
    const response = confirm('Êtes-vous sûr de vouloir soumettre ?')
    if (!response) return

    let formData = new FormData()
    isLoading.value = true
    errrMessage.value = ""
    formData.append("id", data.id ? data.id : "");
    formData.append("nom", data.nom);
    formData.append("prenoms", data.prenoms);
    formData.append("matricule", data.matricule);
    formData.append("date_naissance", data.date_naissance);
    formData.append("dioceses_id", diocese.id);
    formData.append("status","inactive");
    formData.append("lieu_naissance", data.lieu_naissance);
    formData.append("date_ordination_sacerdotale", data.date_ordination_sacerdotale);
    formData.append("lieu_ordination_sacerdotale", data.lieu_ordination_sacerdotale);
    formData.append("numero_telephone", data.numero_telephone);
    formData.append("adresse_electronique", data.adresse_electronique);
    formData.append("specialite", data.specialite);
    formData.append("communautaire", data.communautaire);
    formData.append("lieu_affectation", JSON.stringify(data.lieu_affectation));

    // Gérer le fichier sélectionné
    if (data.selectedFile) {
        formData.append("selectedFile", data.selectedFile);
    }

   data.diplome_ecclesiastique.forEach((value, index) => {
    // Convertir l'objet en chaîne JSON
    formData.append(`diplome_ecclesiastique[${index}]`, JSON.stringify(value));
});

    data.diplome_academique.forEach((value, index) => {
        formData.append(`diplome_academique[${index}]`, JSON.stringify(value));
    });
    await axios.post('/auth/inscription',formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(async response => {
            if (listeprete) {
            await listeprete()
            }
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
    })
    .catch(error => {
        errrMessage.value = error.response.data?.message.split('.')[ 0 ]
        window.scrollTo(0,0)
        console.error('Error fetching user data:', error.response.data?.message.split('.'));
    });

    isLoading.value = false
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    formData.selectedFile = file;
    previewUrl.value = URL.createObjectURL(file); // Générer un aperçu
  }
};

const openFileDialog = () => {
  fileInput.value.click(); // Simule un clic sur l'input file caché
};

onMounted(() => {

    // if (detail) {
    //     Object.assign(formData, detail)
    //     formData.dioceses_id = detail?.diocess?.id
    //     previewUrl.value =  detail?.profile_path ? '/storage/'+detail?.profile_path: null
    //     // formData.diplome_ecclesiastique = detail?.diplomes_academique
    //     // formData.diplome_academique = detail?.diplomes_ecclesiastique
    // }
});
</script>

<template>
    <div class="w-full min-h-screen bg-white p-2 cursor-pointer flex flex-row items-center justify-center">
        <div class="md:w-[520px] bg-white min-h-[100px] rounded-lg">
                <div class="bg-white p-6 rounded-lg shadow-sm max-w-lg w-full" @click.stop>
                <h2 class="text-xl font-semibold mb-3 text-center">
                    Fiche d'inscription
                </h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class="w-[120px] flex items-center justify-center overflow-hidden h-[120px] mx-auto mb-4 border rounded-[50%]">
                    <input
                        type="file"
                        accept="image/*"
                        ref="fileInput"
                        @change="handleFileChange"
                        class="hidden-input"
                        hidden
                        />
                        <img v-if="previewUrl" :src="previewUrl" alt="Preview" class=" object-cover h-full w-full" />
                        <i v-else class="uil uil-user text-[50px] text-primary"></i>
                    </div>
                    <button type="button" @click="openFileDialog" class="shadow-sm flex mb-2 p-3 rounded-md text-[12px] border mx-auto">Choisir une photo de profile</button>
                    <div class=" my-2 w-full">
                        <!-- {{ detail }} -->
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                    Nom
                                </label>
                                <input
                                    v-model="formData.nom"
                                    type="text"
                                    id="diocese"
                                    placeholder="Nom"
                                    required
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                    Prenoms
                                </label>
                                <input
                                    type="text"
                                    v-model="formData.prenoms"
                                    id="diocese"
                                    required
                                    placeholder="Prenoms"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <!-- <div class="w-full  mb-2" v-if="dioceses">
                            <label for="diocese" class="block  font-medium text-gray-700 mb-2">
                                Selectionner une diocèse
                            </label>

                            <select required v-model="formData.dioceses_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                                <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                                <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                            </select>
                        </div> -->

                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input
                                v-model="formData.numero_telephone"
                                    type="text"
                                    required
                                    id="diocese"
                                    placeholder="Téléphone"
                                    class="block text-[12px] w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                Email
                                </label>
                                <input
                                    v-model="formData.adresse_electronique"
                                    type="text"
                                    id="diocese"
                                    placeholder="Email"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                    Lieu de naissance
                                </label>
                                <input
                                    v-model="formData.lieu_naissance"
                                    type="text"
                                    required
                                    id="diocese"
                                    placeholder="Lieu de naissance"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                    Date de Naissance
                                </label>
                                <input
                                    type="date"
                                    v-model="formData.date_naissance"
                                    id="diocese"
                                    required
                                    placeholder=" Date de Naissance"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-2">
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
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                    Lieu ordination sacerdotale
                                </label>
                                <input
                                    v-model="formData.lieu_ordination_sacerdotale"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Lieu ordination sacerdotale"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                    Spécialité
                                </label>
                                <input
                                    v-model="formData.specialite"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Spécialité"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                    Qualité communautaire
                                </label>
                                <input
                                    v-model="formData.communautaire"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Qualité Diocésain ou communautaire"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>
                        <h1 class="my-4 text-center text-xl">Diplôme</h1>

                        <div  v-if="formData?.diplome_ecclesiastique?.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full  mb-2">
                                <div class="flex mb-2 items-end justify-between gap-2" v-for="(item, index) in formData.diplome_ecclesiastique" :key="index">
                                <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                            Diplôme etude ecclesiastique
                                        </label>
                                        <input
                                        v-model="item.intitule_diplome"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Diplome etude ecclesiastique"
                                        class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />

                                </div>
                                <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                            Date
                                        </label>
                                        <input
                                        v-model="item.date"
                                        type="date"
                                        id="diocese"
                                        required
                                        placeholder="Date"
                                        class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />

                                </div>
                                <span class="p-2" @click="DeleteiplomeEcclesiastique(index)"><i class="uil uil-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="AddDiplomeEcclesiastique" class=" block text-[12px] shadow border mx-auto my-3 p-2 rounded-md">Ajouter un diplome ecclesiastique</button>

                        <div v-if="formData?.diplome_academique?.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full mb-2">
                                <div class="w-full flex mb-2 items-end justify-between gap-2" v-for="(item, index) in formData.diplome_academique" :key="index">
                                    <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                            Diplôme etude profane
                                        </label>
                                        <input
                                        v-model="item.intitule_diplome"
                                        type="text"
                                        id="diocese"
                                        required
                                        placeholder="Diplome etude ecclesiastique"
                                        class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                    </div>
                                    <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                            Date
                                        </label>
                                        <input
                                        v-model="item.date"
                                        type="date"
                                        id="diocese"
                                        required
                                        placeholder="Diplome etude ecclesiastique"
                                        class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                    </div>
                                    <span class="p-2" @click="DeleteiplomeAcademique(index)"><i class="uil uil-times"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="AddDiplomeAcademique" class=" block text-[12px] shadow border mx-auto my-3 p-2 rounded-md">Ajouter un diplome profane</button>
                    </div>
                    <h1 class="my-4 text-center text-xl">Lieu d’affectation</h1>
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                            Nom du lieu
                            </label>
                            <input
                                v-model="formData.lieu_affectation.nom"
                                type="text"
                                id="diocese"
                                required
                                placeholder=" Nom du lieu"
                                class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                        <!-- <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block  font-medium text-gray-700 mb-2">
                                Adresse
                            </label>
                            <input
                                v-model="formData.lieu_affectation.adresse"
                                type="text"
                                id="diocese"
                                required
                                placeholder="Adresse"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div> -->
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                Date
                            </label>
                            <input
                                v-model="formData.lieu_affectation.date"
                                type="date"
                                id="diocese"
                                required
                                placeholder="date"
                                class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
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
