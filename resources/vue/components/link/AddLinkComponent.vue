
<script setup>
import { computed, inject, onMounted, reactive, ref } from 'vue';
const { dioceses, callback, detail } = defineProps([ 'dioceses', 'callback', 'detail' ]);
import {useToast} from 'vue-toast-notification';
import ButtonLoader from '../ButtonLoader.vue';

const user = computed(()=>inject('user'))

const link = reactive({
    username:"",
    password:"",
    dioceses_id:"",
    status:"active",
});

const selectedDiocese=ref()
const isLoading =ref(false);
const pass = ref(false);

const errrMessage =ref('')

const createLink =async (data) => {
    errrMessage.value = ""
    isLoading.value = true
    await axios.post('/register-links/create',data)
        .then(async response => {
            if (callback) {
                await callback()
            }
            const $toast = useToast();

            $toast.success('Opération effectuée avec succès');
        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
    .catch(error => {
        if (error.response.data?.errors) {
        errrMessage.value = error.response.data?.errors
        }
    if (error.response.data?.message) {
        errrMessage.value = error.response.data?.message.split('.')[ 0 ]
    }
    console.error('Error fetching user data:', error.response.data?.errors);
    });
    isLoading.value = false
};

const onSelect = (event) => {
    link.username = event.abreviation
    link.dioceses_id = event.id
}
onMounted(() => {
    if (detail) {
        Object.assign(link, detail)
    }
});

</script>

<template>
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
                <h2 class="text-xl font-semibold text-zinc-900 mb-3">{{link?.id ? 'Modifier un utilisateur' : 'Créer un lien'}}</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                <form action="" @submit.prevent="createLink(link)">
                <div class=" my-2">
                    <div class="w-full  mb-3" v-if="user?.role ==='super_admin'" >
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Assingner à un diocèse
                        </label>
                        <select v-model="selectedDiocese" required @change="onSelect(selectedDiocese)" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary  ">
                            <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                            <option :value="item" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div>
                    <div class="w-full  mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Statut
                        </label>
                        <select required v-model="link.status" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                            <option value="active" class="cursor-pointer">Active</option>
                            <option value="Inactive" class="cursor-pointer"> Inactive</option>
                        </select>
                    </div>
                    <div class="w-full  mb-3"  v-if="user?.role ==='super_admin'" >
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Utilisateur
                        </label>
                        <input
                            v-model="link.username"
                            type="text"
                            id="diocese"
                            required
                            disabled
                            placeholder="Nom utilisateur"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full  mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            mot de passe
                        <!-- {{ link?.id ? 'Modifier le mot de passe temporaire (falcutatif)' : 'Définir un mot de passe temporaire' }} -->
                        </label>
                        <input
                            v-model="link.password"
                            :type="pass ? 'text': 'password'"
                            id="diocese"
                            :required="link?.id ? false : true"
                            placeholder="mot de passe temporaire"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="flex items-center gap-1 cursor-pointer">
                        <input type="checkbox" v-model="pass" name="pass" id="pass">
                        <label for="pass" class="cursor-pointer text-[13px]"> afficher le mot de passe</label>
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
