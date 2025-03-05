
<script setup>
import { onMounted, reactive, ref } from 'vue';
import {useToast} from 'vue-toast-notification';
import ButtonLoader from '../ButtonLoader.vue';
const props = defineProps([ 'id','callback','detail' ,'onClose'])

const errrMessage = ref('')
const isLoading =ref(false);
const formData = reactive({
    date_debut: "",
    date_fin: "",
    description: "",
    pretre_id: "",
});


const handleSave = async (formData) => {

    formData.pretre_id = props.id
    errrMessage.value = ""
    isLoading.value = true
    await axios.post('/pretres/parcourt',formData)
        .then(async response => {
            isLoading.value = false
            const $toast = useToast();
            $toast.success('Opération effectuée avec succès');
            location.reload();

            // if (callback) {
            //     await callback()
            // }
    })
        .catch(error => {
        errrMessage.value =  error.response.data?.message.split('.')[0]
        console.error('Error fetching user data:', error.response.data);
        });
};

onMounted(() => {

});
</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
                <div class="flex w-full justify-between items-center mb-6">
                    <h1 class="text-md font-semibold mb-3">Ajouter un parcourt</h1>
                    <button type="button"  @click="props.onClose(false)" class=" top-[5px]  bg-gray-200 text-black w-[25px] rounded-[50%] h-[25px] right-3"><i class="uil uil-times"></i></button>
                </div>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="handleSave(formData)">
                    <div class=" my-2">
                        <div class="flex gap-2">
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Date de début
                                </label>
                                <input
                                required
                                    type="date"
                                    v-model="formData.date_debut"
                                    id="diocese"
                                    accept="image/*"
                                    placeholder="Entrez le nom de la diocèse"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                            <div class="w-full max-w-sm mb-2">
                                <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                    Date de fin
                                </label>
                                <input
                                    v-model="formData.date_fin"
                                    type="date"
                                    id="diocese"
                                    required
                                    placeholder="Entrez le nom de la diocèse"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                                />
                            </div>
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name=""
                            v-model="formData.description"
                            placeholder="Description"
                            required
                            class="block w-full resize-none rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                            id="" cols="30" rows="3"></textarea>
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
