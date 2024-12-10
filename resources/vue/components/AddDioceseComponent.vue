
<script setup>
import { onMounted, reactive, ref } from 'vue';
const { dioceses, callback,detail } = defineProps([ 'dioceses', 'callback','detail' ]);
import {useToast} from 'vue-toast-notification';
import ButtonLoader from './ButtonLoader.vue';

const errrMessage = ref('')
const isLoading =ref(false);

const formData = reactive({
    diocese: "",
    abreviation: "",
    emplacement: "",
    file: "",
});
const handleFile = (event) => {
      const file = event.target.files[0]; // Récupère le premier fichier
      if (file) {
        formData.file = file; // Assigne le fichier à formData.file
      }
};

const handleSave =async (formData) => {
    errrMessage.value = ""
    isLoading.value = true

    const formDataToSend = new FormData();
        formDataToSend.append("diocese", formData.diocese);
        formDataToSend.append("emplacement", formData.emplacement);
            if (formData?.id) {
                formDataToSend.append("id", formData.id);
            } else {
                formDataToSend.append("abreviation", formData.abreviation);
            }
        if (formData.file) {
            formDataToSend.append("file", formData.file);
        }
    await axios.post('/diocesse',formDataToSend)
        .then(async response => {
            const $toast = useToast();

            $toast.success('Opération effectuée avec succès');
            if (callback) {
                await callback()
            }

        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
        .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data);
        });
    isLoading.value = false
};


onMounted(() => {
    if (detail) {
        Object.assign(formData, detail)
        // formData.dioceses_id = detail?.diocess?.id
    }
});
</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter un diocèse</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class=" my-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Ajouter une image
                            </label>
                            <input
                                type="file"
                                @change="handleFile"
                                id="diocese"
                                accept="image/*"
                                placeholder="Entrez le nom de la diocèse"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Nom du diocèse
                            </label>
                            <input
                                v-model="formData.diocese"
                                type="text"
                                id="diocese"
                                required
                                placeholder="Entrez le nom de la diocèse"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Abreviation de la diocèse
                            </label>
                            <input
                                type="text"
                                v-model="formData.abreviation"
                                id="diocese"
                                required

                                placeholder="Entrez l'abreviation de la diocèse"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Ville ou emplacement
                            </label>
                            <input
                                type="text"
                                v-model="formData.emplacement"
                                id="diocese"
                                required

                                placeholder="Entrez la  Ville ou emplacement de la diocèse"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            />
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
