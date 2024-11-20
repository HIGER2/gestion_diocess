
<script setup>
import { ref } from "vue";
import axios from "axios";

// Variables pour stocker les données du formulaire
const image = ref(null);
const diocese = ref("");
const abreviation = ref("");
const emplacement = ref("");


// Fonction pour gérer la soumission
const enregistrerDiocese = async () => {
    try {
        // Création de l'objet FormData pour envoyer des données, y compris l'image
        const formData = new FormData();
        formData.append("url_image", image.value);
        formData.append("diocese", diocese.value);
        formData.append("abreviation", abreviation.value);
        formData.append("emplacement", emplacement.value);

        // Requête POST via Axios
        const response = await axios.post("/diocesse", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        if (response.status === 201) {
            alert("Diocèse ajouté avec succès !");
        }
    } catch (error) {
        if (error.response) {
            // Affiche les erreurs de validation ou autres
            alert(`Erreur : ${error.response.data.message}`);
        } else {
            console.error("Erreur réseau :", error);
            alert("Une erreur s'est produite lors de l'enregistrement.");
        }
    }
};
</script>




<template>
    <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
        <h2 class="text-xl font-semibold mb-3">Ajouter une diocèse</h2>
        <div class="my-2">
            <div class="w-full max-w-sm mb-2">
                <label for="image" class="block text-[13px] font-medium text-gray-700 mb-2">
                   Ajouter une image
                </label>
                <input
                    type="file"
                    id="url_image" 
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                    @change="event => {
                        const image = event.target.files[0];
                        if (image) {
                            image.value = image;  // Assigner le fichier sélectionné à `image`
                            console.log('Fichier sélectionné:', image.value);
                        }
                    }"

                />

            </div>
            <div class="w-full max-w-sm mb-2">
                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                    Nom de la diocèse
                </label>
                <input
                    type="text"
                    id="diocese"
                    v-model="diocese"
                    placeholder="Entrez le nom de la diocèse"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                />
            </div>
            <div class="w-full max-w-sm mb-2">
                <label for="abreviation" class="block text-[13px] font-medium text-gray-700 mb-2">
                    Abreviation de la diocèse
                </label>
                <input
                    type="text"
                    id="abreviation"
                    v-model="abreviation"
                    placeholder="Entrez l'abreviation de la diocèse"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                />
            </div>
            <div class="w-full max-w-sm mb-2">
                <label for="emplacement" class="block text-[13px] font-medium text-gray-700 mb-2">
                    Ville ou emplacement    
                </label>
                <input
                    type="text"
                    id="emplacement"
                    v-model="emplacement"
                    placeholder="Entrez la Ville ou emplacement de la diocèse"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                />
            </div>
        </div>
        <button
            class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-md"
            @click="enregistrerDiocese"
        >
            Enregistrer
        </button>
    </div>
</template>



<style lang="scss" scoped>

</style>