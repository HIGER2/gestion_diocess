
<script setup lang="ts">
import { reactive, ref } from 'vue';
import ButtonLoader from '@/components/ButtonLoader.vue';
import {useToast} from 'vue-toast-notification';


const props = defineProps(['user'])

// const user = reactive({
//     nom:"",
//     prenoms:"",
//     role:"super_admin",
//     phone:"",
//     email:"",
//     password:"",
//     diocese_id:"",
// });

const pass = ref(false);

const isLoading =ref(false);

const errrMessage =ref('')

const createUser =async (data) => {
    errrMessage.value = ""
    isLoading.value = true
    await axios.post('/user/me',data)
        .then(async response => {
        const $toast = useToast();
        $toast.success('Opération effectuée avec succès');
    })
        .catch(error => {
            if (error.response.data?.errors) {
            errrMessage.value = error.response.data?.errors
            }
        if (error.response.data?.message) {
            errrMessage.value = error.response.data?.message.split('.')[ 0 ]
        }

        });

    isLoading.value = false
    window.scrollTo(0, 0);
};

</script>


<template>
    <div class="w-full">
        <!-- {{ props }} -->
        <div class="  max-w-lg w-[450px] m-auto" @click.stop>
            <h2 class="text-xl font-semibold text-zinc-900 mb-3">Mon compte</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                    {{ errrMessage }}
            </div>
            <form action="" @submit.prevent="createUser(props.user)">
            <div class=" my-2 w-full bg-white p-6 rounded-lg">
                <div class=" items-center justify-between gap-2">
                    <div class="w-full max-w-sm mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Nom
                        </label>
                        <input
                            v-model="props.user.nom"
                            type="text"
                            required
                            id="diocese"
                            placeholder="Nom"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full max-w-sm mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Prenoms
                        </label>
                        <input
                            v-model="props.user.prenoms"
                            type="text"
                            required
                            id="diocese"
                            placeholder="Prenoms"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                </div>
                <div class=" items-center justify-between gap-2">
                    <div class="w-full max-w-sm mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input
                            v-model="props.user.phone"
                            type="text"
                            required
                            id="diocese"
                            placeholder="Téléphone"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full max-w-sm mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            email
                        </label>
                        <input
                            v-model="props.user.email"
                            type="text"

                            id="diocese"
                            placeholder="email"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                </div>
                <!-- <div class="w-full  mb-3">
                    <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                        Selectionner le role
                    </label>
                    <select required disabled v-model="props.user.role" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                        <option value="super_admin" class="cursor-pointer">Super administratreur</option>
                        <option value="admin" class="cursor-pointer"> Administratreur</option>
                    </select>
                </div> -->
                    <!-- <div class="w-full  mb-3" v-if="user.role =='admin'">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Assingner à une diocèse
                        </label>
                        <select required v-model="user.diocese_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary  ">
                            <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                            <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div> -->
                    <div class="w-full  mb-3" v-if="props.user?.role !=='super_admin'">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                          Ancien mot de passe
                        </label>
                        <input
                            v-model="props.user.old_password"
                            :type="pass ? 'text': 'password'"
                            id="diocese"
                            placeholder="Ancien mot de passe"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full  mb-3">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Modifier mon mot de passe (falcutatif)
                        </label>
                        <input
                            v-model="props.user.password"
                            :type="pass ? 'text': 'password'"
                            id="diocese"
                            placeholder="Nouveau mot de passe"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                <div class="flex items-center cursor-pointer gap-1">
                    <input type="checkbox" v-model="pass"  id="show">
                    <label for="show"> afficher le mot de passe</label>
                </div>
            </div>
            <button class="mt-6 bg-primary w-full flex items-center justify-center text-white py-2 px-4 rounded-md ">
                <ButtonLoader title="Enregistrer" :isLoading="isLoading" />
            </button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
