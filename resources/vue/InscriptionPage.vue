
<script setup>
import { computed, inject, onMounted, reactive, ref } from 'vue';
const { dioceses, callback,diocese, dioceseId, detail } = defineProps([ 'dioceses','diocese' ,'callback', 'dioceseId', 'detail' ]);


import {useToast} from 'vue-toast-notification';
import ButtonLoader from './components/ButtonLoader.vue';

const previewUrl = ref(null);
const fileInput = ref(null);
const user = computed(()=>inject('user'))

const errrMessage = ref('')
const isLoading =ref(false);
const formData = reactive({
    selectedFile:null,
    nom: "",
    prenoms: "",
    matricule: "",
    date_naissance: "",
    dioceses_id:''  ,
    lieu_naissance: "",
    date_ordination_sacerdotale: "",
    lieu_ordination_sacerdotale: "",
    diplome_ecclesiastique: [],
    diplome_academique: [],
    numero_telephone: "",
    adresse_electronique: "",
    specialite:'',
    communautaire: '',
    parcours:[]
});

// const listeprete = inject('listeprete')


const AddDiplomeEcclesiastique = () => {
    formData.diplome_ecclesiastique.push({intitule_diplome:"",date:''})
}


const Addparcours = () => {
    formData.parcours.push( {
        nom: '',
        adresse:'',
        date: '',
        fonction: '',
        dioceses_id:'' ,
        date_fin:'' ,
    })
}

const DeleteParcours = (index) => {
   if (index >= 0 && index < formData.parcours.length) {
        formData.parcours.splice(index, 1);
    }
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

    if (!confirm('Voulez-vous effectuer cette opération ?')) {
        return;
    }
    console.log('====================================');
    console.log(data);
    console.log('====================================');
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
    if (dioceseId) {
        formData.append('dioceses_id',dioceseId)
    }
    // Gérer le fichier sélectionné
    if (data.selectedFile) {
        formData.append("selectedFile", data.selectedFile);
    }

    data.parcours.forEach((value, index) => {
        // Convertir l'objet en chaîne JSON
        formData.append(`parcours[${index}]`, JSON.stringify(value));
    });

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
    if (detail) {
        Object.assign(formData, detail)
        formData.dioceses_id = detail?.diocess?.id
        previewUrl.value =  detail?.profile_path ? '/storage/'+detail?.profile_path: null
        // formData.diplome_ecclesiastique = detail?.diplomes_academique
        // formData.diplome_academique = detail?.diplomes_ecclesiastique
    }
});
</script>

<template>
    <div class="w-full flex items-center justify-center bg-gray-50 p-4">
        <!-- {{ diocese }} -->
        <div class="  max-w-lg w-[500px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3 text-center">Fiche d'insciption</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class="w-full bg-white border p-4 mb-3 rounded-lg">
                    <h1 class="my-4 text-center text-xl">Informations personnelles</h1>
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
                    <button type="button" @click="openFileDialog" class="shadow-sm flex text-[12px] mb-2 p-3 rounded-md border mx-auto">
                        Choisir une photo de profile
                    </button>
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
                    <div class="w-full  mb-2" v-if="dioceses && user?.role ==='super_admin'">
                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                            Selectionner un diocèse
                        </label>

                        <select  v-model="formData.dioceses_id" name="" id=""  class="cursor-pointer text-[12px] block w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                            <option value="" class="cursor-pointer" disabled>Selectionner un diocèse</option>
                            <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input
                            v-model="formData.numero_telephone"
                                type="text"
                                required
                                id="diocese"
                                placeholder="Téléphone"
                                class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
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
                                class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
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
                            <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
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
                            <label for="diocese" class="block  text-[12px] font-medium text-gray-700 mb-2">
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
                            <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
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
                            <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
                                Qualité communautaire
                            </label>
                            <input
                                v-model="formData.communautaire"
                                type="text"
                                id="diocese"
                                required
                                placeholder="Qualité Diocésain ou communautaire"
                                class="block text-[12px] w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                    </div>

                    </div>
                    <div class="w-full bg-white border p-4 mb-3 rounded-lg">
                         <h1 class="my-4 text-center text-xl">Diplôme</h1>

                        <div  v-if="formData?.diplome_ecclesiastique?.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full  mb-2">
                                <div class="flex mb-2 items-end justify-between gap-2" v-for="(item, index) in formData.diplome_ecclesiastique" :key="index">
                                <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
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
                                        <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
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
                                <span class="block text-[12px] shadow border  cursor-pointer p-2 rounded-md" @click="DeleteiplomeEcclesiastique(index)">
                                   <i class="uil uil-minus-circle"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="AddDiplomeEcclesiastique" class=" block text-[12px] shadow border mx-auto my-3 p-2 rounded-md">
                            Ajouter un diplôme ecclesiastique
                        </button>

                        <div v-if="formData?.diplome_academique?.length > 0" class="flex items-center justify-between gap-2">
                            <div class="w-full mb-2">
                                <div class="w-full flex mb-2 items-end justify-between gap-2" v-for="(item, index) in formData.diplome_academique" :key="index">
                                    <div class="w-full max-w-sm">
                                        <label for="diocese" class="block text-[12px]  font-medium text-gray-700 mb-2">
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
                                        <label for="diocese" class="block  text-[12px] font-medium text-gray-700 mb-2">
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
                                    <span class=" block text-[12px] shadow border  cursor-pointer p-2 rounded-md" @click="DeleteiplomeAcademique(index)">
                                        <i class="uil uil-minus-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="AddDiplomeAcademique" class=" block text-[12px] shadow border mx-auto my-3 p-2 rounded-md">
                            Ajouter un diplôme académique
                        </button>
                    </div>
                    <div class="w-full bg-white border  p-4 rounded-lg mb-3">
                        <h1 class="my-4 text-center text-xl"> Parcours pastoral</h1>
                        <div class="border-b border-b-gray-300 mb-1 py-2" v-for="(item, index) in formData?.parcours" :key="index">
                            <button type="button" @click="DeleteParcours(index)" class=" block text-[12px] shadow border my-3 p-2 rounded-md">
                                <i class="uil uil-minus-circle"></i>
                                Retirer
                            </button>
                            <div class="flex items-center justify-between gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                Nom de la paroise
                                </label>
                                <input
                                    v-model="item.nom"
                                    type="text"
                                    id="diocese"
                                    required
                                    placeholder="Nom de la paroise"
                                    class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                Fonction
                                </label>
                                <select  v-model="item.fonction" name="" id=""  class="cursor-pointer text-[12px] block w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                                    <option value="curé" >Curé</option>
                                    <option value="vicaire" >Vicaire</option>
                                    <option value="autre" >Autre</option>
                                </select>
                            </div>

                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <div class="w-full  mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Diocèse
                                    </label>
                                    <select  v-model="item.dioceses_id" name="" id=""  class="cursor-pointer text-[12px] block w-full rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                                        <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                                        <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full flex items-center justify-between gap-2">
                                <div class="w-full max-w-sm mb-2">
                                    <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                        Date début
                                    </label>
                                    <input
                                        v-model="item.date"
                                        type="date"
                                        id="diocese"
                                        required
                                        placeholder="date"
                                        class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                    />
                                </div>
                                <div class="w-full max-w-sm mb-2">
                                        <label for="diocese" class="block text-[12px] font-medium text-gray-700 mb-2">
                                            Date fin
                                        </label>
                                        <input
                                            v-model="item.date_fin"
                                            type="date"
                                            id="diocese"
                                            required
                                            placeholder="date"
                                            class="block w-full text-[12px] rounded-lg border border-gray-300 bg-gray-50 p-2  shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                        />
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="Addparcours" class=" block text-[12px] shadow border mx-auto my-3 p-2 rounded-md">
                            Ajouter un parcours
                        </button>
                    </div>
                    <button class="mt-6 bg-primary w-full flex items-center justify-center text-white py-2 px-4 rounded-md ">
                        <ButtonLoader title="Enregistrer" :isLoading="isLoading" />
                    </button>
                </form>
        </div>
    </div>
</template>


<style lang="scss" scoped>

</style>
